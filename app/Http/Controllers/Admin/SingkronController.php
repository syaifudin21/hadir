<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Singkron;

class SingkronController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$singkrons = Singkron::all();
    	return view('admin.singkron', compact('singkrons'));
    }
    public function validasi(Request $request)
    {
      $this->validate($request, [
        'waktu' => 'required',
      ]);
    }
    public function store(Request $request)
    {
        $this->validasi($request);
        $singkron = new Singkron();
        $singkron->fill($request->all());
        $singkron->save();
        return back()->with('success', 'Berhasil Menambahkan Singkron');
    }

    public function update(Request $request)
    {
        $this->validasi($request);
        $singkron = Singkron::find($request->id);
        $singkron->fill($request->all());
        $singkron->save();
        return back()->with('success', 'Berhasil Mengupdate Singkron');
    }
    public function delete($id)
    {
        $singkron = Singkron::find($id);
        $singkron->delete();
        return redirect('admin/singkron')->with('success', 'Berhasil Menghapus Singkron');
    }
}
