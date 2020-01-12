<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Role extends Model
{
    public $timestamps = false;

    const STUDENT = 'student';

    const STAFF = 'staff';

    const ADMINISTRATOR = 'administrator';

    const DEVELOPER = 'developer';

    private static $roles = [
        self::STUDENT,
        self::STAFF,
        self::ADMINISTRATOR,
        self::DEVELOPER,
    ];

    protected $fillable = [
        'name',
        'name_fr',
        'hierarchy',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(UserRole::class)
            ->withTimestamps()
            ->withoutGlobalScope(SoftDeletingScope::class);
    }

    public function isCurrentRoleOf(User $user)
    {
        return $user->role()->name === $this->name;
    }

    public static function findByName($name)
    {
        return static::where('name', $name)->first();
    }

    public static function findHierarchyByName($name)
    {
        return static::where('name', $name)->pluck('hierarchy')->first();
    }

    public function isEquivalentTo($name)
    {
        return $this->hierarchy == static::findHierarchyByName($name);
    }

    public function isSuperiorTo($name)
    {
        return $this->hierarchy < static::findHierarchyByName($name);
    }

    public function isSuperiorOrEquivalentTo($name)
    {
        return $this->hierarchy <= static::findHierarchyByName($name);
    }

    public function isInferiorTo($name)
    {
        return $this->hierarchy > static::findHierarchyByName($name);
    }

    public function isInferiorOrEquivalentTo($name)
    {
        return $this->hierarchy >= static::findHierarchyByName($name);
    }

    public static function roles()
    {
        return self::$roles;
    }
}
