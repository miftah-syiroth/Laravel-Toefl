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
        'quota'
    ];

    // mutator untuk merubah format tanggal pelaksanaan supaya dapat tampil di input datetime-local
    public function getPelaksanaanAttribute($value)
    {
        return Carbon::parse($this->attributes['pelaksanaan'])->isoFormat('YYYY-MM-DDThh:mm:ss');
    }

    // mutator untuk merubah format tanggal pendaftaran supaya dapat tampil di input datetime-local
    public function getPendaftaranAttribute($value)
    {
        return Carbon::parse($this->attributes['pendaftaran'])->isoFormat('YYYY-MM-DDThh:mm:ss');
    }

    // banyak kelas toefl memilki banyak status
    public function statuses()
    {
        return $this->belongsToMany(Status::class, 'kelas_has_statuses', 'kelas_id', 'status_id');
    }

    // sebuah kelas bisa memiliki banyak toefl, dan toefl jg dimiliki oleh banyak kelas
    public function toefls()
    {
        return $this->belongsToMany(Toefl::class, 'kelas_has_toefls', 'kelas_id', 'toefl_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }
}
