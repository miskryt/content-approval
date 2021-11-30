<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return true;
    }

    public function edit(User $user)
    {
        return true;
    }

    public function viewAssetHistory(User $user)
    {
        return $user->isSuperAdmin() || $user->isClient();
    }

    public function update(User $user)
    {
        return true;
    }

    public function delete(User $user)
    {
        return $user->isSuperAdmin() || $user->isClient();
    }
}
