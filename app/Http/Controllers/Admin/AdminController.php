<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mesin;
use App\Models\Rekam;
use App\Models\SuratIzin;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function Parse_Data($data, $p1, $p2)
    {
		$data = " " . $data;
		$hasil = "";
		$awal = strpos($data, $p1);
		if($awal != "") {
			$akhir = strpos(strstr($data, $p1), $p2);
			if($akhir != "") {
				$hasil = substr($data, $awal + strlen($p1), $akhir - strlen($p1));
			}
		}
		return $hasil;
    }
    public function index()
    {
    	$hadir = Rekam::join('users', function ($join) {
	            $join->on('rekams.id_finger', '=', 'users.id_finger')
	            		 ->where('users.status', 'Siswa')
		                 ->select('users.nisn', 'users.nama');
		        })
    			->whereDate('tanggal', Carbon::now())
		        ->count();
		$izin = SuratIzin::where('izin', 'Izin')->whereDate('mulai', Carbon::now())->count();
		$sakit = SuratIzin::where('izin', 'Sakit')->whereDate('mulai', Carbon::now())->count();

    	return view('admin.admin-dashboard',compact('hadir', 'izin', 'sakit'));
    }
    public function sinctime()
    {
    	$mesins = Mesin::where('status', 'Aktif')->get();
    	$berhasil = '';
    	$gagal = '';

    	foreach ($mesins as $mesin) {
	    	$connect = @fsockopen($mesin->ip, "80", $errno, $errstr, 1);
			if($connect) {
				$soap_request = "<SetDate><ArgComKey xsi:type=\"xsd:integer\">" . $mesin->nomor . "</ArgComKey><Arg><Date xsi:type=\"xsd:string\">" . date("Y-m-d") . "</Date><Time xsi:type=\"xsd:string\">" . date("H:i:s") . "</Time></Arg></SetDate>";
				$newLine = "\r\n";
				fputs($connect, "POST /iWsService HTTP/1.0" . $newLine);
				fputs($connect, "Content-Type: text/xml" . $newLine);
				fputs($connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
				fputs($connect, $soap_request . $newLine);
				$buffer = "";
				while($Response = fgets($connect, 1024)) {
					$buffer = $buffer . $Response;
				}
			} else {
				$gagal .= "Gagal Koneksi ".$mesin->ip.":".$mesin->nomor. "<br>";
			}
			if($connect) {
			$buffer = $this->Parse_Data($buffer, "<Information>", "</Information>");
				$berhasil .= "Berhasil Set Jam ".$mesin->ip.":".$mesin->nomor. "<br>";
			}

    	}
    	return back()->with(['success'=> $berhasil, 'gagal'=>$gagal]);
    }
}
