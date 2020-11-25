<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the user associated with the absence.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'advisor_id');
    }
}
