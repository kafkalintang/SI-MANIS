<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'unit_kerja_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi ke tabel unit_kerjas
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function hasAnyRole($roles)
    {
        $roles = (array) $roles;

        $userRoles = explode(',', $this->role);
        $userRoles = array_map('trim', $userRoles);

        return (bool) array_intersect($userRoles, $roles);
    }
    
    public function auditorUnits()
    {
        return $this->belongsToMany(UnitKerja::class, 'auditor_unit', 'auditor_id', 'unit_id');
    }
}
