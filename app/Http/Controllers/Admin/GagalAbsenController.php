<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GagalAbsen;
use App\Models\Rekam;

class GagalAbsenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$gagals = GagalAbsen::all();
    	return view('admin.gagalabsen', compact('gagals'));
    }
    public function validasi(Request $request)
    {
      $this->validate($request, [
        'waktu_input' => 'required',
        'id_rekam' => 'required',
      ]);
    }
    public function store(Request $request)
    {
        $this->validasi($request);
        $kategori = new GagalAbsen();
        $kategori->fill($request->all());
        $kategori->save();
        return back()->with('success', 'Berhasil Menambahkan Gagal Absen');
    }

    public function update(Request $request)
    {
        $this->validasi($request);
        $gagal = GagalAbsen::find($request->id);
        $gagal->fill($request->all());
        $gagal->save();

        $rekam = Rekam::find($request->id_rekam);
        $rekam[$gagal->dimensi_waktu] = $request->waktu_input;
        $rekam['id_absen'] = null;
        $rekam->update();

        return back()->with('success', 'Berhasil Mengupdate Gagal Absen');
    }
    public function delete($id)
    {
        $gagal = GagalAbsen::find($id);
        
        $rekam = Rekam::find($gagal->id_rekam);
        $rekam[$gagal->dimensi_waktu] = null;
        $rekam['id_absen'] = null;
        $rekam->update();

        $gagal->delete();
        return redirect('admin/gagalabsen')->with('success', 'Berhasil Menghapus Gagal Absen');
    }
}
