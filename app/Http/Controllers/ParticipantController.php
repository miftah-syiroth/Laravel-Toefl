<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    public function index()
    {
        return view('admin.participant.index');
    }
}
