<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_dosen',
        'waktu_hadir',
        'status'
    ];

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'id', 'id_dosen');
    }
}
