<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public string $modelName = User::class;
}
