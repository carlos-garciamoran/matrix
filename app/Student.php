<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps    = false;
    public $incrementing  = false;
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['advisors'];

    /**
     * Get the user associated with the student.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the advisors whom the student belongs to.
     *
     * @param null|string type
     * @return Collection Advisor|User
     */
    public function advisors($type = null)
    {
        $advisors = $this->belongsToMany('App\Advisor', 'advisories', 'student_id', 'advisor_id');

        if ($type === 'as_user') $advisors = $advisors->with('user')->get()->map->user;

        return $advisors;
    }

    /**
     * Get the student's overnight trip authorisation.
     *
     * @return OvernightAuthorisation
     */
    public function authorisation()
    {
        return $this->hasOne('App\OvernightAuthorisation', 'student_id');
    }

    /**
     * Determine if the student has an overnight trip authorisation.
     *
     * @return bool
     */
    public function hasAuthorisation()
    {
        return $this->authorisation !== null;
    }

    /**
     * Get all the student trips.
     *
     * @return Collection \App\Trip
     */
    public function trips()
    {
        return $this->hasMany('App\Trip', 'student_id');
    }

    /**
     * Get all the student open trips.
     *
     * @return Collection \App\Trip
     */
    public function openTrips()
    {
        return $this->trips()->where('signed_in', false);
    }

    /**
     * Determine if the student has any open trip.
     *
     * @return bool
     */
    public function isOnCampus()
    {
        return $this->openTrips->first() === null;
    }

    /**
     * Determine if the student is late for sign-in (given that isOnCampus()).
     *
     * @return bool
     */
    public function isLate()
    {
        $currentTrip = $this->openTrips->first();

        return strtotime(now()) > strtotime($currentTrip->return_date);
    }
}
