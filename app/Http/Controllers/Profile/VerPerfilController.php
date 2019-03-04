<?php


namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VerPerfilController extends  Controller
{
    public function index(){
        return view('modules.profile.index', [
            'user' => Auth::user()
        ]);
    }
}