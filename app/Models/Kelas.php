<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = [
        'nama',
        'pelaksanaan',
        'pendaftaran',
        'quota',
        'prince',
        'ispublished',
        'register_status_id',
    ];

    // mutator untuk merubah format tanggal pelaksanaan supaya dapat tampil di input datetime-local
    public function getPelaksanaanAttribute($value)
    {
        // return Carbon::parse($this->attributes['pelaksanaan'])->isoFormat('YYYY-MM-DDThh:mm:ss');
        return Carbon::parse($this->attributes['pelaksanaan']);
    }

    // mutator untuk merubah format tanggal pendaftaran supaya dapat tampil di input datetime-local
    public function getPendaftaranAttribute($value)
    {
        // return Carbon::parse($this->attributes['pendaftaran'])->isoFormat('YYYY-MM-DDThh:mm:ss');
        return Carbon::parse($this->attributes['pendaftaran']);
    }

    // sebuah kelas bisa memiliki banyak toefl, dan toefl jg dimiliki oleh banyak kelas
    public function toefls()
    {
        return $this->belongsToMany(Toefl::class, 'kelas_has_toefls', 'kelas_id', 'toefl_id');
    }

    // peserta mksdnya
    public function users()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }

    public function registerStatus()
    {
        return $this->belongsTo(RegisterStatus::class, 'register_status_id');
    }
}
