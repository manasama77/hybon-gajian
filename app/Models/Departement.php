<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departement extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }

    public function karyawan_user()
    {
        return $this->hasOneThrough(User::class, Karyawan::class);
    }
}
