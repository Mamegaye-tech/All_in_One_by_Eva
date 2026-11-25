<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Employe;
use App\Models\User;

class EmployePolicy
{
    private function gerer(User $user): bool
    {
        return $user->isAdmin() || $user->hasPermission(Permission::EmployesGerer);
    }

    public function viewAny(User $user): bool { return $this->gerer($user); }

    public function view(User $user, Employe $employe): bool { return $this->gerer($user); }

    public function create(User $user): bool { return $this->gerer($user); }

    public function update(User $user, Employe $employe): bool { return $this->gerer($user); }

    public function toggleStatus(User $user, Employe $employe): bool { return $this->gerer($user); }

    // Commissions et performances : administratrice uniquement
    public function voirCommissions(User $user): bool { return $user->isAdmin(); }
}