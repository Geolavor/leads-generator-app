<?php

namespace LeadBrowser\Activity\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\User\Models\UserProxy;
use LeadBrowser\Organization\Models\EmployeeProxy;
use LeadBrowser\Activity\Contracts\Participant as ParticipantContract;

class Participant extends Model implements ParticipantContract
{
    public $timestamps = false;

    protected $table = 'activity_participants';

    protected $with = ['user', 'employee'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity_id',
        'user_id',
        'employee_id',
    ];
    
    /**
     * Get the activity that owns the participant.
     */
    public function activity()
    {
        return $this->belongsTo(ActivityProxy::modelClass());
    }
    
   /**
    * Get the user that owns the participant.
    */
   public function user()
   {
       return $this->belongsTo(UserProxy::modelClass());
   }
    
   /**
    * Get the employee that owns the participant.
    */
   public function employee()
   {
       return $this->belongsTo(EmployeeProxy::modelClass());
   }
}
