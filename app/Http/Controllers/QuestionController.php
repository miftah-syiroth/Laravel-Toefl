<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Toefl;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Toefl $toefl, Section $section)
    {
        if ($section->id === 1 ) {
            $page = 'admin.question.create.section1';
        } elseif ($section->id === 2) {
            $page = 'admin.question.create.section2';
        } else {
            $page = 'admin.question.create.section3';
        }
        
        return view($page, compact("toefl", "section"));
    }
}
