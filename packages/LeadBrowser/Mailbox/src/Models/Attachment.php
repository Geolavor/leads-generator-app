<?php

namespace LeadBrowser\Mailbox\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Mailbox\Contracts\Attachment as AttachmentContract;

class Attachment extends Model implements AttachmentContract
{
    protected $table = 'email_attachments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'path',
        'size',
        'content_type',
        'content_id',
        'email_id',
    ];

    /**
     * Get the email.
     */
    public function email()
    {
        return $this->belongsTo(MailboxProxy::modelClass());
    }
}
