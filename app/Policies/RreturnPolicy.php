<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rreturn;
use Illuminate\Auth\Access\HandlesAuthorization;

class RreturnPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function updateanddestroy(User $currentUser, Rreturn $rreturn)
      {
        $project_manager=explode("、",$rreturn->project_manager);
        return in_array($currentUser->name, $project_manager);

      }
}
