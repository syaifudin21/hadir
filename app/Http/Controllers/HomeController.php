<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekam;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Models\SuratIzin;
use Carbon\Carbon;
use File;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.index');
    }
    public function cari()
    {
    	$nisn = $_GET['nisn'];
    	$hadirs = Rekam::join('users', function ($join) {
	            $join->on('rekams.id_finger', '=', 'users.id_finger')
		                 ->select('users.nisn', 'users.nama');
		        })
    			->where('nisn', $nisn)
		        ->get();
        $user = User::where('nisn', $nisn)->first();
        $izins = SuratIzin::where('nisn', $nisn)->get();
        
        $ta = TahunAjaran::where('status', 'Aktif')->select('mulai')->first();
        if (!empty($ta)) {
            $mulai = new Carbon($ta['mulai']);
            $totalhari = $mulai->diffInDays(Carbon::now());
        }

		return view('front.search', compact('hadirs', 'totalhari', 'user','izins'));
    }
    public function izin()
    {
        if (isset($_GET['nisn'])) {
            $user = User::where('nisn', $_GET['nisn'])->first();
        }
        return view('front.izin', compact('user'));
    }
    public function storeizin(Request $request)
    {
        $izin = new SuratIzin();
        $izin->fill($request->all());
        if ($request->hasFile('bukti')){
            $filenamewithextension = $request->file('bukti')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('bukti')->getClientOriginalExtension();
            $filenametostore = $filename.'_'.uniqid().'.'.$extension;
            $request->file('bukti')->move('images/bukti',$filenametostore);
            $mapelbab['bukti'] = $filenametostore;
        }
        $izin['mulai']= Carbon::now();
        $izin->save();
        return back()->with('success', 'Berhasil Mengirim Izin Tidak Masuk <a href="/upload/izin"> Kirim izin Lagi</a>');
    }
}
