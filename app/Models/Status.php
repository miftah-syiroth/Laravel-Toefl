<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';
    protected $fillable = [
        'status',
    ];

    // banyak status dimiliki oleh banyak kelas
    public function classes()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_has_statuses', 'status_id', 'kelas_id');
    }
}
