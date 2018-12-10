<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Waktu;

class WaktuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$waktus = Waktu::all();
    	return view('admin.waktu', compact('waktus'));
    }
    public function validasi(Request $request)
    {
      $this->validate($request, [
        'masuk_1' => 'required',
        'keluar_1' => 'required',
      ]);
    }
    public function store(Request $request)
    {
        $this->validasi($request);
        $waktu = new Waktu();
        $waktu->fill($request->all());
        $waktu->save();
        return back()->with('success', 'Berhasil Menambahkan Waktu');
    }

    public function update(Request $request)
    {
        $this->validasi($request);
        $waktu = Waktu::find($request->id);
        $waktu->fill($request->all());
        $waktu->save();
        return back()->with('success', 'Berhasil Mengupdate Waktu');
    }
    public function delete($id)
    {
        $waktu = Waktu::find($id);
        $waktu->delete();
        return redirect('admin/waktu')->with('success', 'Berhasil Menghapus Waktu');
    }
}
