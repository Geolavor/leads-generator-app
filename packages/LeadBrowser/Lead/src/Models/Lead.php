<?php

namespace LeadBrowser\Lead\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use LeadBrowser\Activity\Models\ActivityProxy;
use LeadBrowser\Organization\Models\EmployeeProxy;
use LeadBrowser\User\Models\UserProxy;
use LeadBrowser\Mailbox\Models\MailboxProxy;
use LeadBrowser\Quote\Models\QuoteProxy;
use LeadBrowser\Tag\Models\TagProxy;
use LeadBrowser\Attribute\Traits\CustomAttribute;
use LeadBrowser\Lead\Contracts\Lead as LeadContract;

class Lead extends Model implements LeadContract
{
    use CustomAttribute;

    protected $casts = [
        'closed_at'           => 'datetime',
        'expected_close_date' => 'date',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'lead_value',
        'status',
        'lost_reason',
        'expected_close_date',
        'closed_at',
        'user_id',
        'employee_id',
        'lead_source_id',
        'lead_type_id',
        'lead_pipeline_id',
        'lead_pipeline_stage_id',
    ];

    /**
     * Get the user that owns the lead.
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass());
    }

    /**
     * Get the employee that owns the lead.
     */
    public function employee()
    {
        return $this->belongsTo(EmployeeProxy::modelClass());
    }

    /**
     * Get the type that owns the lead.
     */
    public function type()
    {
        return $this->belongsTo(TypeProxy::modelClass());
    }

    /**
     * Get the source that owns the lead.
     */
    public function source()
    {
        return $this->belongsTo(SourceProxy::modelClass());
    }

    /**
     * Get the pipeline that owns the lead.
     */
    public function pipeline()
    {
        return $this->belongsTo(PipelineProxy::modelClass(), 'lead_pipeline_id');
    }

    /**
     * Get the pipeline stage that owns the lead.
     */
    public function stage()
    {
        return $this->belongsTo(StageProxy::modelClass(), 'lead_pipeline_stage_id');
    }

    /**
     * Get the activities.
     */
    public function activities()
    {
        return $this->belongsToMany(ActivityProxy::modelClass(), 'lead_activities');
    }

    /**
     * Get the products.
     */
    public function products()
    {
        return $this->hasMany(ProductProxy::modelClass());
    }

    /**
     * Get the emails.
     */
    public function emails()
    {
        return $this->hasMany(MailboxProxy::modelClass());
    }

    /**
     * The quotes that belong to the lead.
     */
    public function quotes()
    {
        return $this->belongsToMany(QuoteProxy::modelClass(), 'lead_quotes');
    }

    /**
     * The tags that belong to the lead.
     */
    public function tags()
    {
        return $this->belongsToMany(TagProxy::modelClass(), 'lead_tags');
    }

    /**
     * Returns the rotten days 
     */
    public function getRottenDaysAttribute()
    {
        if (in_array($this->stage->code, ['won', 'lost'])) {
            return 0;
        }

        $rottenDate = $this->created_at->addDays($this->pipeline->rotten_days);

        return $rottenDate->diffInDays(Carbon::now(), false);
    }
}
