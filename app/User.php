<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the profile photo of the user or the default one.
     *
     * @return string
     */
    public function profile_photo()
    {
        return $this->profile_photo
            ? '/images/profile-photos/' . $this->profile_photo
            : '/vendor/open-iconic/svg/person.svg';
    }

    /**
     * Get all of the absences of the user (teacher).
     *
     * @return Collection \App\Absence
     */
    public function absences()
    {
        return $this->hasMany('App\Absence', 'advisor_id');
    }

    /**
     * Get all of the posts of the user.
     *
     * @return Collection \App\Post
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * Get the advisor associated with the user.
     *
     * @return Advisor
     */
    public function advisor()
    {
        return $this->hasOne('App\Advisor');
    }

    /**
     * Get the student associated with the user.
     *
     * @return Student
     */
    public function student()
    {
        return $this->hasOne('App\Student');
    }

    /**
     * Determine if the user is an advisor.
     *
     * @return bool
     */
    public function isAdvisor()
    {
        return $this->role === 'advisor';
    }

    /**
     * Determine if the user is staff.
     *
     * @return bool
     */
    public function isStaff()
    {
        return $this->role === 'staff';
    }

    /**
     * Determine if the user is a student.
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }
}
