<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$users = User::all();
    	return view('admin.user', compact('users'));
    }
    public function validasi(Request $request)
    {
      $this->validate($request, [
        'nisn' => 'required',
      ]);
    }
    public function store(Request $request)
    {
        $this->validasi($request);
        $user = new User();
        $user->fill($request->all());
        $user['password'] = Hash::make($request['password']);
        $user->save();
        return back()->with('success', 'Berhasil Menambahkan User');
    }

    public function update(Request $request)
    {
        $this->validasi($request);
        $user = User::find($request->id);
        $userlm = User::find($request->id);
        $user->fill($request->all());
        $user['password'] = (empty($request->password))? $userlm->password : Hash::make($request['password']);
        $user->save();
        return back()->with('success', 'Berhasil Mengupdate User');
    }
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('admin/user')->with('success', 'Berhasil Menghapus User');
    }
}
