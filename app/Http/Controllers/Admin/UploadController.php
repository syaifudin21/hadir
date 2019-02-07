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
        $url = 'http://smawahasmodel.sch.id/v1/absen/upload';
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
    public function kirimserver()
    {
    	$rekams = Rekam::whereNull('id_absen')
                ->join('users', 'rekams.id_finger', '=', 'users.id_finger')
                ->join('mesins', 'rekams.id_mesin', '=', 'mesins.id')
                ->select('rekams.*', 'mesins.ip', 'users.nisn')
                ->get();
        $berhasil = '';
        $gagal = '';
        if (empty($rekams) OR count($rekams)==0) {
           $berhasil .= 'Tidak Ada yang Bisa Diupload';
        }else{
            foreach ($rekams as $rekam) {
                $param['nisn']  = $rekam->nisn;
                $param['mesin'] = $rekam->ip;
                $param['id_finger'] = $rekam->id_finger;
                $param['event']= $rekam->event;
                $param['masuk_1'] = $rekam->masuk_1;
                $param['keluar_1'] = $rekam->keluar_1;
                $param['masuk_2'] = $rekam->masuk_2;
                $param['keluar_2'] = $rekam->keluar_2;
                $param['id_user_edit'] = $rekam->id_user_edit;
                $param['keterangan'] = $rekam->keterangan;
                $param['id_absen'] = $rekam->id_absen;
                $param['tanggal'] = $rekam->tanggal;
                    $url = 'http://smawahasmodel.sch.id/v1/absen/upload';
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
                if ($hasil['kode']=='00') {
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
        }
        $data = [
            'success'=>(empty($berhasil)) ? '' :  '<b>Upload Server</b> '. $berhasil, 
            'gagal'=> (empty($gagal)) ? '' : '<b>Upload Server</b> '. $gagal
        ];
        
        return $data;
    }
    public function upload()
    {
        $kirim = $this->kirimserver();
        return back()->with($kirim);
    }
    public function downloadupload()
    {
        $success = session('success');
        $gagal = session('gagal');
        $upload = $this->kirimserver();

        $data = [
            'success' => $success. $upload['success'],
            'gagal' => $gagal. $upload['gagal']
        ];
        return redirect('admin')->with($data);
    }
}
