<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        $data = Role::all();
        return view('register', [
            'role' => $data
        ]);
    }
}
