@extends('admin.admin-template')

@section('content')
    @if(session('success')) 
        <div class="alert alert-info alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! session('success') !!}
        </div>
    @endif
    @if (session('gagal'))
        <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!!session('gagal')!!}
        </div>
    @endif
    <div class="container-fluid">

      <div class="card-columns">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Singkron Waktu pada Mesin</h5>
      <p class="card-text">Terkadang Waktu dalam Mesin Mengalami Ketidak cocokan, silahkan singkronkan dengan waktu berdasarkan GMT</p>
            <a href="{{url('admin/sinctime')}}" class="btn btn-outline-secondary btn-sm">Sinkron Jam </a>
    </div>
  </div>
  <div class="card p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p class="card-text">Menarik semua data yang ada di mesin yang terhubung.</p>
            <a href="{{url('admin/download/manual')}}" class="btn btn-outline-secondary btn-sm">Download dari Mesin</a>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </small>
      </footer>
    </blockquote>
  </div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Download dan Clear</h5>
      <p class="card-text">Menarik semua data yang ada di mesin yang terhubung setelah itu menghapus data di webserver.</p>
            <a href="{{url('admin/download/clear')}}" class="btn btn-outline-secondary btn-sm">Download dan Clear</a>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>
 
  <div class="card text-center">
    <div class="card-body">
      <h5 class="card-title">Download dan Upload</h5>
      <p class="card-text">Proses ini akan menarik data pada mesin dan diteruskan mengirim ker server</p>
            <a href="{{url('admin/download/upload')}}" class="btn btn-outline-secondary btn-sm">Download dan Upload</a>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>
  <div class="card p-3 text-right">
    <blockquote class="blockquote mb-0">
      <p>Download (Tarik Data) Clear Data Upload dan Data Server</p>
            <a href="{{url('admin/download/clear/upload')}}" class="btn btn-outline-secondary btn-sm">Download Clear Upload</a>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </small>
      </footer>
    </blockquote>
  </div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Hadir Hari ini</h5>
      <table class="table">
        <tr>
          <td>Siswa Hadir</td><td>{{$hadir}}</td>
        </tr><tr>
          <td>Siswa Izin</td><td>{{$izin}}</td>
        </tr><tr>
          <td>Siswa Sakit</td><td>{{$sakit}}</td>
        </tr><tr>
          <td>Siswa Absen</td><td></td>
        </tr>
      </table>
    </div>
  </div>
</div>

    
    </div>
@endsection
