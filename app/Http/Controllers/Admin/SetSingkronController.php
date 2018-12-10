<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AutoUpload;
class SetSingkronController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$setsingkrons = AutoUpload::all();
    	return view('admin.setsingkron', compact('setsingkrons'));
    }
    public function validasi(Request $request)
    {
      $this->validate($request, [
        'time' => 'required',
      ]);
    }
    public function store(Request $request)
    {
        $this->validasi($request);
        $setsingkron = new AutoUpload();
        $setsingkron->fill($request->all());
        $setsingkron->save();
        return back()->with('success', 'Berhasil Menambahkan AutoUpload');
    }

    public function update(Request $request)
    {
        $this->validasi($request);
        $setsingkron = AutoUpload::find($request->id);
        $setsingkron->fill($request->all());
        $setsingkron->save();
        return back()->with('success', 'Berhasil Mengupdate AutoUpload');
    }
    public function delete($id)
    {
        $setsingkron = AutoUpload::find($id);
        $setsingkron->delete();
        return redirect('admin/singkron')->with('success', 'Berhasil Menghapus AutoUpload');
    }
}
