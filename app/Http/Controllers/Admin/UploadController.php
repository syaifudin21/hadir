<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rekam;
class UploadController extends Controller
{
    public function kirim($nisn, $mesin, $id_finger, $event, $masuk_1, $keluar_1, $masuk_2, $keluar_2, $id_user_edit, $keterangan, $id_absen, $tanggal)
    {
    	$param['nisn'] = $nisn;
        $param['mesin'] = $mesin;
        $param['id_finger'] = $id_finger;
        $param['event'] = $event;
        $param['masuk_1'] = $masuk_1;
        $param['keluar_1'] = $keluar_1;
        $param['masuk_2'] = $masuk_2;
        $param['keluar_2'] = $keluar_2;
        $param['id_user_edit'] = $id_user_edit;
        $param['keterangan'] = $keterangan;
        $param['id_absen'] = $id_absen;
        $param['tanggal'] = $tanggal;
        $url = 'http://localhost/smadel/v1/absen/upload';
        $data = array('http' =>
                            array(
                                'method'  => 'POST',
                                'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                                'content' => http_build_query($param)
                            )
                        );
        $convert = stream_context_create($data);
        $kirim = file_get_contents($url, false, $convert);

        $hasil = json_decode($kirim, TRUE);
        return $hasil;
    }
    public function upload()
    {
    	$rekams = Rekam::whereNull('id_absen')
                ->join('users', 'rekams.id_finger', '=', 'users.id_finger')
                ->join('mesins', 'rekams.id_mesin', '=', 'mesins.id')
                ->select('rekams.*', 'mesins.ip', 'users.nisn')
                ->get();
        $berhasil = '';
        $gagal = '';
        foreach ($rekams as $rekam) {
            $nisn  = $rekam->nisn;
            $mesin = $rekam->ip;
            $id_finger = $rekam->id_finger;
            $event= $rekam->event;
            $masuk_1 = $rekam->masuk_1;
            $keluar_1 = $rekam->keluar_1;
            $masuk_2 = $rekam->masuk_2;
            $keluar_2 = $rekam->keluar_2;
            $id_user_edit = $rekam->id_user_edit;
            $keterangan = $rekam->keterangan;
            $id_absen = $rekam->id_absen;
            $tanggal = $rekam->tanggal;
            $kirim = $this->kirim($nisn, $mesin, $id_finger, $event, $masuk_1, $keluar_1, $masuk_2, $keluar_2, $id_user_edit, $keterangan, $id_absen, $tanggal);
            if ($kirim['kode']=='00') {
                $rek = Rekam::find($rekam->id);
                $rek['id_absen'] = $kirim['id_absen'];
                $rek->update();
                if ($rek) {
                    $berhasil .= 'Berhasil Kirim ['.$kirim['id_absen'].']';
                }else{
                    $gagal .= 'Gagal Simpan ';
                }
            }else{
                $gagal .= 'Gagal Kirim ';
            }
        }
        return back()->with('success', $berhasil)->with('gagal', $gagal);
    }
}
