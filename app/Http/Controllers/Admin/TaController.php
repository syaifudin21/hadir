<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;

class TaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$tahunajarans = TahunAjaran::all();
    	return view('admin.tahunajaran', compact('tahunajarans'));
    }
    public function validasi(Request $request)
    {
      $this->validate($request, [
        'tahun_ajaran' => 'required',
        'mulai' => 'required',
      ]);
    }
    public function store(Request $request)
    {
        $this->validasi($request);
        $tahunajaran = new TahunAjaran();
        $tahunajaran->fill($request->all());
        $tahunajaran['selesai'] = date('Y-m-d', strtotime('+1 year', strtotime($request->mulai)));
        $tahunajaran->save();
        return back()->with('success', 'Berhasil Menambahkan Tahun Ajaran');
    }

    public function update(Request $request)
    {
        $this->validasi($request);
        $tahunajaran = TahunAjaran::find($request->id);
        $tahunajaran->fill($request->all());
        $tahunajaran->update();
        return back()->with('success', 'Berhasil Mengupdate Tahun Ajaran');
    }
    public function delete($id)
    {
        $tahunajaran = TahunAjaran::find($id);
        $tahunajaran->delete();
        return redirect('admin/tahunajaran')->with('success', 'Berhasil Menghapus Tahun Ajaran');
    }
}
