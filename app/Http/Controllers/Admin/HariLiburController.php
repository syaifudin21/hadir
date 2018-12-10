<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HariLiburController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$kategoris = Kategori::all();
    	return view('admin.kategori', compact('kategoris'));
    }
    public function validasi(Request $request)
    {
      $this->validate($request, [
        'kategori' => 'required|max:40',
      ]);
    }
    public function store(Request $request)
    {
        $this->validasi($request);
        $kategori = new Kategori();
        $kategori->fill($request->all());
        $kategori->save();
        return back()->with('success', 'Berhasil Menambahkan Kategori');
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
