<?php

namespace App\Http\Controllers\Clubs;


use App\ClubModel;
use App\Http\Controllers\Controller;

class ClubesListController extends Controller
{
    public function index(){
        $clubes = ClubModel::disabled()->get();
        return view('modules.clubes.list', [
            'clubes' => $clubes
        ]);
    }
}