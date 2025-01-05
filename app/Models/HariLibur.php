<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HariLibur extends Model
{
    use SoftDeletes;

    protected $fillable = ['tanggal', 'keterangan'];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
