<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mesin;

class MesinController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$mesins = Mesin::all();
    	return view('admin.mesin', compact('mesins'));
    }
    public function validasi(Request $request)
    {
      $this->validate($request, [
        'ip' => 'required',
        'nomor' => 'required',
      ]);
    }
    public function store(Request $request)
    {
        $this->validasi($request);
        $mesin = new Mesin();
        $mesin->fill($request->all());
        $mesin->save();
        return back()->with('success', 'Berhasil Menambahkan Mesin');
    }

    public function update(Request $request)
    {
        $this->validasi($request);
        $mesin = Mesin::find($request->id);
        $mesin->fill($request->all());
        $mesin->update();
        return back()->with('success', 'Berhasil Mengupdate Mesin');
    }
    public function delete($id)
    {
        $mesin = Mesin::find($id);
        $mesin->delete();
        return redirect('admin/mesin')->with('success', 'Berhasil Menghapus Mesin');
    }
}
