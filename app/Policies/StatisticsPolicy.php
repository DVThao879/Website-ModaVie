<?php

namespace App\Policies;

use App\Models\User;

class StatisticsPolicy
{
    public function viewStatistics(User $user)
    {
        return in_array($user->role, [1, 2]);
    }

    public function showStatistics(User $user)
    {
        return in_array($user->role, [1, 2]);
    }
}
