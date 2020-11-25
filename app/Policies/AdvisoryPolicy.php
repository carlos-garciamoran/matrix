<?php

namespace App\Policies;

use App\User;
use App\Student;
use App\Advisory;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvisoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the $student is an advisee of the logged-in advisor ($user).
     *
     * @param  User  $user
     * @param  Student  $student
     * @return bool
     */
    public function access(User $user, Student $student)
    {
        return Advisory::where('advisor_id', $user->id)->get()->map->student_id
                            ->contains($student->user_id)
                            || app('advisor')->duty;
    }
}
