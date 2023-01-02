<?php

namespace LeadBrowser\Mailbox\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Organization\Models\PersonProxy;
use LeadBrowser\Lead\Models\LeadProxy;
use LeadBrowser\Mailbox\Contracts\Mailbox as MailboxContract;

class Mailbox extends Model implements MailboxContract
{
    protected $table = 'mailboxes';

    protected $casts = [
        'folders'       => 'array',
        'sender'        => 'array',
        'from'          => 'array',
        'reply_to'      => 'array',
        'cc'            => 'array',
        'bcc'           => 'array',
        'reference_ids' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'source',
        'name',
        'user_type',
        'is_read',
        'folders',
        'from',
        'sender',
        'reply_to',
        'cc',
        'bcc',
        'unique_id',
        'message_id',
        'reference_ids',
        'reply',
        'person_id',
        'parent_id',
        'lead_id',
    ];

    /**
     * Get the parent email.
     */
    public function parent()
    {
        return $this->belongsTo(MailboxProxy::modelClass(), 'parent_id');
    }

    /**
     * Get the lead.
     */
    public function lead()
    {
        return $this->belongsTo(LeadProxy::modelClass());
    }

    /**
     * Get the emails.
     */
    public function emails()
    {
        return $this->hasMany(MailboxProxy::modelClass(), 'parent_id');
    }

    /**
     * Get the person that owns the thread.
     */
    public function person()
    {
        return $this->belongsTo(PersonProxy::modelClass());
    }

    /**
     * Get the attachments.
     */
    public function attachments()
    {
        return $this->hasMany(AttachmentProxy::modelClass(), 'email_id');
    }
}
