<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function authorizeUser(User $user, string $permission): bool
    {
        // Check if user is active and has the required permission
        return $user->status === 'active' && $user->hasPermission($permission);
    }

    public function registerUser(array $data)
    {
        return DB::transaction(function () use ($data) {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => 3, // Default role = students/unless changed
                'status' => 'active', //default status = active/unless changed
            ]);
        });
    }
}
