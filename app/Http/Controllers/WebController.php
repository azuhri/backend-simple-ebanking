<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WebController extends Controller
{
    function loginIndex() {
        return view("login");
    }

    function appIndex($userId) {
        $user = User::with("mutations")->where("id",$userId)->first();
        if(!$user) {
            \abort(404);
        }
        return view("app", \compact("user"));
    }
}
