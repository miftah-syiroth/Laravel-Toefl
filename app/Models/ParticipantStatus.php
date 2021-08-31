<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantStatus extends Model
{
    use HasFactory;

    protected $table = 'participant_statuses';
    protected $fillable = ['status'];

    public function users()
    {
        return $this->hasMany(User::class, 'status_id');
    }
}
