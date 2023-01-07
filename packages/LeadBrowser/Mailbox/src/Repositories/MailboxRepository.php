<?php

namespace LeadBrowser\Mailbox\Repositories;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Event;
use LeadBrowser\Mailbox\Helpers\Parser;
use LeadBrowser\Mailbox\Helpers\Htmlfilter;
use LeadBrowser\Core\Eloquent\Repository;

class MailboxRepository extends Repository
{
    /**
     * AttachmentRepository object
     *
     * @var \LeadBrowser\Mailbox\Repositories\AttachmentRepository
     */
    protected $attachmentRepository;

    /**
     * Parser object
     *
     * @var \LeadBrowser\Mailbox\Helpers\Parser
     */
    protected $mailboxParser;

    /**
     * Htmlfilter object
     *
     * @var \LeadBrowser\Mailbox\Helpers\Htmlfilter
     */
    protected $htmlFilter;

    /**
     * Create a new repository instance.
     *
     * @param  \LeadBrowser\Mailbox\Repositories\AttachmentRepository  $attachmentRepository
     * @param  \LeadBrowser\Mailbox\Helpers\Parser  $mailboxParser
     * @param  \LeadBrowser\Mailbox\Helpers\Htmlfilter  $htmlFilter
     * @param  \Illuminate\Container\Container  $container
     * @return void
     */
    public function __construct(
        AttachmentRepository $attachmentRepository,
        Parser $mailboxParser,
        Htmlfilter $htmlFilter,
        Container $container
    )
    {
        $this->attachmentRepository = $attachmentRepository;

        $this->mailboxParser = $mailboxParser;

        $this->htmlFilter = $htmlFilter;

        parent::__construct($container);
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Mailbox\Contracts\Mailbox';
    }

    /**
     * @param  array  $data
     * @return \LeadBrowser\Mailbox\Contracts\Mailbox
     */
    public function create(array $data)
    {
        $mailbox = parent::create($this->sanitizeMailboxs($data));

        $this->attachmentRepository->setMailboxParser($this->mailboxParser)->uploadAttachments($mailbox, $data);

        return $mailbox;
    }

    /**
     * @param array  $data
     * @param int    $id
     * @param string $attribute
     * @return \LeadBrowser\Mailbox\Contracts\Mailbox
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $mailbox = $this->findOrFail($id);

        parent::update($this->sanitizeMailboxs($data), $id);

        $this->attachmentRepository->setMailboxParser($this->mailboxParser)->uploadAttachments($mailbox, $data);

        return $mailbox;

    }

    /**
     * @param string $content
     * @return void
     */
    public function processInboundParseMail($content)
    {
        $this->mailboxParser->setText($content);

        $mailbox = $this->findOneWhere(['message_id' => $this->mailboxParser->getHeader('message-id')]);

        if ($mailbox) {
            return;
        }

        if (! $fromNameParts = mailparse_rfc822_parse_addresses($this->mailboxParser->getHeader('from'))) {
            $fromNameParts = mailparse_rfc822_parse_addresses($this->mailboxParser->getHeader('sender'));
        }

        $headers = [
            'from'          => current($this->parseMailboxAddress('from')),
            'sender'        => $this->parseMailboxAddress('sender'),
            'reply_to'      => $this->parseMailboxAddress('to'),
            'cc'            => $this->parseMailboxAddress('cc'),
            'bcc'           => $this->parseMailboxAddress('bcc'),
            'subject'       => $this->mailboxParser->getHeader('subject'),
            'source'        => 'mailbox',
            'name'          => $fromNameParts[0]['display'] == $fromNameParts[0]['address']
                               ? current(explode('@', $fromNameParts[0]['display']))
                               : $fromNameParts[0]['display'],
            'user_type'     => 'employee',
            'message_id'    => $this->mailboxParser->getHeader('message-id') ?? time() . '@' . config('mail.domain'),
            'reference_ids' => htmlspecialchars_decode($this->mailboxParser->getHeader('references')),
            'in_reply_to'   => htmlspecialchars_decode($this->mailboxParser->getHeader('in-reply-to')),
        ];

        foreach ($headers['reply_to'] as $to) {
            if ($mailbox = $this->findOneWhere(['message_id' => $to])) {
                break;
            }
        }

        if (! isset($mailbox) && $headers['in_reply_to']) {
            $mailbox = $this->findOneWhere(['message_id' => $headers['in_reply_to']]);

            if (! $mailbox) {
                $mailbox = $this->findOneWhere([['reference_ids', 'like',  '%' . $headers['in_reply_to'] . '%']]);
            }
        }
        
        if (! isset($mailbox) && $headers['reference_ids']) {
            $referenceIds = explode(' ', $headers['reference_ids']);

            foreach ($referenceIds as $referenceId) {
                if ($mailbox = $this->findOneWhere([['reference_ids', 'like', '%' . $referenceId . '%']])) {
                    break;
                }
            }
        }

        if (! $reply = $this->mailboxParser->getMessageBody('text')) {
            $reply = $this->mailboxParser->getTextMessageBody();
        }

        if (! isset($mailbox)) {
            $mailbox = $this->create(array_merge($headers, [
                'folders'       => ['inbox'],
                'reply'         => $reply, //$this->htmlFilter->HTMLFilter($reply, ''),
                'unique_id'     => time() . '@' . config('mail.domain'),
                'reference_ids' => [$headers['message_id']],
                'user_type'     => 'employee',
            ]));
        } else {
            $this->update([
                'reference_ids' => array_merge($mailbox->reference_ids ?? [], [$headers['message_id']]),
            ], $mailbox->id);

            $this->create(array_merge($headers, [
                'reply'         => $this->htmlFilter->HTMLFilter($reply, ''),
                'parent_id'     => $mailbox->id,
                'user_type'     => 'employee',
            ]));
        }
    }

    /**
     * @param string $type
     * @return array
     */
    public function parseMailboxAddress($type)
    {
        $mailboxs = [];

        $addresses = mailparse_rfc822_parse_addresses($this->mailboxParser->getHeader($type));

        if (count($addresses) > 1) {
            foreach ($addresses as $address) {
                if (filter_var($address['address'], FILTER_VALIDATE_EMAIL)) {
                    $mailboxs[] = $address['address'];
                }
            }
        } else if ($addresses) {
            $mailboxs[] = $addresses[0]['address'];
        }

        return $mailboxs;
    }

    /**
     * @param  array  $data
     * @return array
     */
    public function sanitizeMailboxs(array $data)
    {
        if (isset($data['reply_to'])) {
            $data['reply_to'] = array_values(array_filter($data['reply_to']));
        }

        if (isset($data['cc'])) {
            $data['cc'] = array_values(array_filter($data['cc']));
        }

        if (isset($data['bcc'])) {
            $data['bcc'] = array_values(array_filter($data['bcc']));
        }

        return $data;
    }
}