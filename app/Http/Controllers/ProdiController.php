<?php

namespace App\Http\Controllers;

use App\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodis = DB::table('prodi')->select('nama')->get();

        $data = compact('prodis');
        return view('register')->with('$data');
    }

}
