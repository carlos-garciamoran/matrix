<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advisor extends Model
{
    public $timestamps    = false;
    public $incrementing  = false;
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all of the absences of the advisor.
     *
     * @return Collection \App\Absence
     */
    public function absences()
    {
        return $this->hasMany('App\Absence', 'advisor_id');
    }

    /**
     * Get the user associated with the advisor.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the students who belong to the advisor.
     *
     * @param null|string type
     * @return Collection
     */
    public function students($type = null)
    {
        $students = $this->belongsToMany('App\Student', 'advisories', 'advisor_id', 'student_id');

        if ($type === 'as_user') $students = $students->with('user')->get()->map->user;

        return $students;
    }
}
