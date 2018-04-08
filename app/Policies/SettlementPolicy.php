<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Settlement;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettlementPolicy
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

    public function updateanddestroy(User $currentUser, Settlement $settlement)
      {
        $project_manager=explode("、",$settlement->project_manager);
        return in_array($currentUser->name, $project_manager);

      }

}
