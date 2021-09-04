<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterStatus extends Model
{
    use HasFactory;

    protected $table = 'register_statuses';
    protected $fillable = [
        'status',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'register_status_id');
    }
}
