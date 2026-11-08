<?php

namespace App\Policies;

use App\Enums\Role as RoleEnum;
use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    private function staff(User $user): bool
    {
        return $user->hasRole(RoleEnum::Admin) || $user->hasRole(RoleEnum::Receptionniste);
    }

    public function viewAny(User $user): bool { return $this->staff($user); }

    public function view(User $user, Client $client): bool { return $this->staff($user); }

    public function create(User $user): bool { return $this->staff($user); }

    public function update(User $user, Client $client): bool { return $this->staff($user); }

    // Désactivation / réactivation et export : administratrice uniquement
    public function toggleStatus(User $user, Client $client): bool { return $user->isAdmin(); }

    public function export(User $user): bool { return $user->isAdmin(); }
}