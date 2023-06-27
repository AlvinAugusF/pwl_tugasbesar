<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\TahunAkademik;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\Krs;
use App\Models\Matkul;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = $request->session()->get('mahasiswa');

        $mahasiswa = null;

        if ($data && is_object($data) && property_exists($data, 'id')) {
            $mahasiswa = Mahasiswa::with(['prodis', 'kelas'])->findOrFail($data->id);
        }


        $ta = TahunAkademik::where('status', 1)->first();
        $items = null;

        if ($mahasiswa && $mahasiswa->id && $ta && $ta->id) {
            $items = Krs::where('id_mahasiswa', $mahasiswa->id)->where('id_ta', $ta->id)->with(['schedule'])->get();
        }

        $totalSks = 0;
        $maxSks = 24;
        $totalSks = 0;

        if ($items && is_iterable($items)) {
            foreach ($items as $item) {
                $totalSks += $item->schedule->matkul->sks;
            }
        }

        $iditem = [];

        if ($items && is_array($items)) {
            foreach ($items as $index => $item) {
                $iditem[] = $item['id'];
            }
        }


        return view('user.krs.index')->with([
            'mahasiswa' => $mahasiswa,
            'ta' => $ta,
            'items' => $items,
            'totalSks' => $totalSks,
            'maxSks' => $maxSks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $mahasiswa = $request->session()->get('mahasiswa');
        $ta = TahunAkademik::where('status', 1)->first();
        $krsMahasiswas = Krs::where('id_mahasiswa', $mahasiswa->id)->where('id_ta', $ta->id)->with(['schedule'])->get();
        foreach($krsMahasiswas as $index => $krsMahasiswa){
            $idKrs[] = $krsMahasiswa->id_schedule;
        }
        $totalSks = 0;
        $maxSks = 24;
        foreach($krsMahasiswas as $item){
            $totalSks = $totalSks + $item->schedule->matkul->sks;
        }
        $items = Schedule::where('id_ta', $ta->id)->where('id_prodi', $mahasiswa->id_prodi)->with(['matkul','ruangan'])->get();
        // ambil seluruh id schedule
        foreach($items as $index => $item){
            $idSchedule[] = $item->id;
        }
        if(count($krsMahasiswas) == 0){
            $data = Schedule::where('id_ta', $ta->id)->where('id_prodi', $mahasiswa->id_prodi)->with(['matkul','ruangan'])->get();
        }else{
            $results = array_diff($idSchedule,$idKrs);
            foreach($results as $result){
                $datas[] = Schedule::where('id', $result)->get();
            }
            // dd($datas);
            foreach($datas as $item){
                $data[] = $item[0];
            }
        }

        return view('user.krs.create')->with([
            'data' => $data,
            'idMahasiswa' => $mahasiswa->id,
            'idTa' => $ta->id,
            'totalSks' => $totalSks,
            'maxSks' => $maxSks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        foreach($data['matkul'] as $index => $item){
            $schedule[] = Schedule::where('id', $item)->get();
        }
        foreach($schedule as $index => $item){
            $matkul[] = Matkul::where('id', $item[0]->id_matkul)->get();
        }
        $sks = 0;
        foreach($matkul as $index => $item){
            $sks = $sks + $item[0]->sks;
        }
        // cek jika total sks lebih dari max sks
        if($data['totalSks']+$sks > $data['maxSks']){
            return redirect()->route('krs.index')->with('status', 'Jumlah sks matakuliah melebihi batas maximal pengambilan!');
        }else{
            // simpan krs
            foreach($data['matkul'] as $index=>$value){
                Krs::create([
                    'id_mahasiswa' => $data['idMahasiswa'],
                    'id_schedule' => $data['matkul'][$index],
                    'id_ta' => $data['idTa'],
                ]);
            }

            return redirect()->route('krs.index')->with('status', 'Krs berhasil ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mahasiswa = Mahasiswa::with(['prodis','kelas'])->findOrFail($id);
        $ta = TahunAkademik::where('status', 1)->first();
        // data krs
        $items = Krs::where('id_mahasiswa', $mahasiswa->id)->where('id_ta', $ta->id)->with(['schedule'])->get();
        $totalSks = 0;
        $maxSks = 24;
        foreach($items as $item){
            $totalSks = $totalSks + $item->schedule->matkul->sks;
        }
        return view('user.krs.cetak')->with([
            'mahasiswa' => $mahasiswa,
            'ta' => $ta,
            'items' => $items,
            'totalSks' => $totalSks,
            'maxSks' => $maxSks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Krs::findOrFail($id);
        $item->delete();

        return redirect()->route('krs.index')->with('status', 'Krs berhasil dihapus!');
    }
}
