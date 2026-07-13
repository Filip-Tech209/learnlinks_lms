<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use HasFactory, Notifiable;
    
    protected $fillable = ['role_name'];

    public function permissions(): BelongsToMany
    {
        // 'permission_role' is the table name, 
        // Laravel defaults to role_id and permission_id as keys
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}