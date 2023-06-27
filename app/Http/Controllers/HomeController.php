<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\Matkul;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function dashboard()
    {
        $mahasiswa = Mahasiswa::count();
        $matkul = Matkul::count();

        return view('pages.dashboard.index')->with([
            'mahasiswa' => $mahasiswa,
            'matkul' => $matkul,
        ]);
    }

    public function mahasiswa(Request $request)
    {
        $data = $request->session()->get('mahasiswa');
        $item = null;

        if ($data && is_object($data) && property_exists($data, 'id')) {
            $item = Mahasiswa::with(['prodis','kelas'])->findOrFail($data->id);
        }

        $ta = TahunAkademik::where('status', 1)->first();

        return view('user.dashboard.dashboard')->with([
            'item' => $item,
            'ta' => $ta
        ]);
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


}
