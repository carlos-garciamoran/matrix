<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OvernightAuthorisation extends Model {
    public $timestamps = false;

    protected $primaryKey = 'student_id';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
