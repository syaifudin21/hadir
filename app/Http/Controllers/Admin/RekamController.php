<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rekam;
use App\Models\GagalAbsen;

class RekamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$rekams = Rekam::all();
    	return view('admin.rekam', compact('rekams'));
    }
    public function validasi(Request $request)
    {
      $this->validate($request, [
        'waktu_input' => 'required',
        'id_rekam' => 'required',
      ]);
    }
    public function gagalabsen(Request $request)
    {
        $this->validasi($request);
        $rekam = Rekam::find($request->id_rekam);
        $rekam[$request->dimensi_waktu] = $request->waktu_input;
        $rekam['id_absen'] = null;
        $rekam->update();

        $kategori = new GagalAbsen();
        $kategori->fill($request->all());
        $kategori->save();
        return back()->with('success', 'Berhasil Menambahkan Waktu');
    }

    public function update(Request $request)
    {
        $this->validasi($request);
        $kategori = Kategori::find($request->id);
        $kategori->fill($request->all());
        $kategori->save();
        return back()->with('success', 'Berhasil Mengupdate Kategori');
    }
    public function delete($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();
        return redirect('admin/kategori')->with('success', 'Berhasil Menghapus Kategori');
    }
}
