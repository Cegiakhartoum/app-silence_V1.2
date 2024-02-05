<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\ProjetAction;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebtvController extends Controller
{
    public function index($id)
    {
        $projet=ProjetAction::where('id',$id)->first();
     
        return view('student.pages.action-webtv', ['projet' => $projet]);  
    }
} 