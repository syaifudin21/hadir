<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rekam;
use App\Models\Mesin;
use App\Models\Waktu;
use Carbon\Carbon;

class DownloadController extends Controller
{
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
    public function download()
    {
		$mesins = Mesin::where('status', 'Aktif')->get();
    	$berhasil = '';
    	$gagal = '';

    	foreach ($mesins as $mesin) {
	    	$connect = fsockopen($mesin->ip, "80", $errno, $errstr, 1);

			if($connect) {
				$soap_request = "<GetAttLog>
								<ArgComKey xsi:type=\"xsd:integer\">" . $mesin->nomor . "</ArgComKey>
									<Arg>
									<DateTime xsi:type=\"xsd:string\">" . date("Y-m-d H:i:s") . "</DateTime>
									</Arg>
								</GetAttLog>";
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
				$gagal .= "Gagal Koneksi ".$mesin->ip.":".$mesin->nomor."<br>";
			}
			$buffer = $this->Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
			$buffer = explode("\r\n", $buffer);
			for($a = 1; $a < count($buffer)-1; $a++):
				$data = $this->Parse_Data($buffer[$a], "<Row>", "</Row>");
				$pin = $this->Parse_Data($data, "<PIN>", "</PIN>");
				$datetime = $this->Parse_Data($data, "<DateTime>", "</DateTime>");
				$Verified = $this->Parse_Data($data, "<Verified>", "</Verified>");
				$Status = $this->Parse_Data($data, "<Status>", "</Status>");

				$date = date("Y-m-d", strtotime($datetime));
				$time = date("H:i:s", strtotime($datetime));
				// $datesekarang = date("Y-m-d", strtotime(Carbon::now()));

				$waktu = Waktu::where('status', 'Aktif')->first();
				// dd($time , $waktu->batas_pencatatan);
				$find = Rekam::where(['id_finger'=> $pin, 'tanggal'=>$date])->first();

				if (!empty($find)) {
					$dd = Rekam::where(['id_finger'=> $pin, 'tanggal'=>$date])->first();
					if ($time >= $waktu->masuk_1 && $time < $waktu->keluar_1) {
						$find['masuk_1'] = ($time > $dd->masuk_1 && !empty($dd->masuk_1))? $dd->masuk_1 : $time;
						$find->update();
						if($find) { $berhasil .= "Berhasil Update Catat"; }else{ $gagal .= "Gagal Catat"; }
					}elseif ($time >= $waktu->keluar_1 && $time < $waktu->masuk_2) {
						$find['keluar_1'] = ($time > $dd->keluar_1 && !empty($dd->keluar_1))? $dd->keluar_1 : $time;
						$find->update();
						if($find) { $berhasil .= "Berhasil Update Catat"; }else{ $gagal .= "Gagal Catat"; }
					}elseif ($time >= $waktu->masuk_2 && $time < $waktu->keluar_2) {
						$find['masuk_2'] = ($time > $dd->masuk_2 && !empty($dd->masuk_2))? $dd->masuk_2 : $time;
						$find->update();
						if($find) { $berhasil .= "Berhasil Update Catat"; }else{ $gagal .= "Gagal Catat"; }
					}elseif ($time >= $waktu->keluar_2 && $time < $waktu->batas_pencatatan) {
						$find['keluar_2'] = ($time > $dd->keluar_2 && !empty($dd->keluar_2))? $dd->keluar_2 : $time;
						$find->update();
						if($find) { $berhasil .= "Berhasil Update Catat"; }else{ $gagal .= "Gagal Catat"; }
					}
				}else{
					$rekam = new Rekam;
					$rekam['id_mesin'] = $mesin->id;
					$rekam['id_finger'] = $pin;
					$rekam['tanggal'] = $date;
					if ($time >= $waktu->masuk_1 && $time < $waktu->keluar_1) {
							$rekam['masuk_1'] = $time;
							$rekam->save();
							if($rekam) { $berhasil .= "Berhasil Catat"; }else{ $gagal .= "Gagal Catat"; }
					}elseif ($time >= $waktu->keluar_1 && $time < $waktu->masuk_2) {
							$rekam['keluar_1'] = $time;
							$rekam->save();
							if($rekam) { $berhasil .= "Berhasil Catat"; }else{ $gagal .= "Gagal Catat"; }
					}elseif ($time >= $waktu->masuk_2 && $time < $waktu->keluar_2) {
							$rekam['masuk_2'] = $time;
							$rekam->save();
							if($rekam) { $berhasil .= "Berhasil Catat"; }else{ $gagal .= "Gagal Catat"; }
					}elseif ($time >= $waktu->keluar_2 && $time < $waktu->batas_pencatatan) {
							$rekam['keluar_2'] = $time;
							$rekam->save();
							if($rekam) { $berhasil .= "Berhasil Catat"; }else{ $gagal .= "Gagal Catat"; }
					}
				}

			endfor;
    	}
    	$hasil = [
    		$berhasil = $berhasil,
    		$gagal = $gagal
    	];
    	return $hasil;
    }
    public function clear()
    {
    	$mesins = Mesin::where('status', 'Aktif')->get();
    	$berhasil = '';
    	$gagal = '';

    	foreach ($mesins as $mesin) {
	    	$connect = fsockopen($mesin->ip, "80", $errno, $errstr, 1);
			if($connect) {
				$soap_request = "<ClearData><ArgComKey xsi:type=\"xsd:integer\">" . $mesin->nomor . "</ArgComKey><Arg><Value xsi:type=\"xsd:integer\">3</Value></Arg></ClearData>";
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
				$gagal .= 'Gagal Koneksi';
			}
			$buffer = $this->Parse_Data($buffer, "<Information>", "</Information>");
			$berhasil .= 'Berhasil';
		}
		$hasil = [
    		$berhasil = $berhasil,
    		$gagal = $gagal
    	];
    	return $hasil;
    }
    public function downloadmanual()
    {
    	$hasil = $this->download();
    	return back()->with('success', $hasil[0])->with('gagal', $hasil[1]);
    }
    public function downloadclear()
    {
    	$hasil = $this->download();
    	$clear = $this->clear();
    	return back()->with('success', $hasil[0])->with('gagal', $hasil[1])->with('success', $clear[0])->with('gagal', $clear[1]);
    }
}
