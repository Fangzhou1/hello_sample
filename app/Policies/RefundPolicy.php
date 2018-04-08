<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Refund;
use Illuminate\Auth\Access\HandlesAuthorization;

class RefundPolicy
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

    public function updateanddestroy(User $currentUser,Refund $refund)
      {
        $project_manager=explode("、",$refund->project_manager);
        return in_array($currentUser->name, $project_manager);

      }
}
