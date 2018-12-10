@extends('admin.admin-template')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
<h1 class="h2">Rekaman</h1>
<div class="btn-toolbar mb-2 mb-md-0">
  <div class="btn-group mr-2">
    <a class="btn btn-sm btn-outline-secondary" href="{{url('admin/upload/server')}}">Singkron Server</a>
    <a class="btn btn-sm btn-outline-secondary" href="{{url('admin/download/manual')}}">Tarik Data</a>
    <a class="btn btn-sm btn-outline-secondary" href="{{url('admin/download/clear')}}">Tarik Data & Clear Data</a>
  </div>
  <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
    <span data-feather="calendar"></span>
    This week
  </button>
</div>
</div>

@if(Session::has('success'))
    <div class="alert alert-info alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('success') }}
    </div>
@endif

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        
<div class="table-responsive-sm">
<table id="example" class="table table-hover table-sm" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>ID Mesin</th>
                <th>Finger</th>
                <th>Tanggal</th>
                <th>Masuk 1</th>
                <th>Keluar 1</th>
                <th>Masuk 2</th>
                <th>Keluar 2</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <?php $n=1;?>
        <tbody>
            @foreach($rekams as $rekam)
            <?php
                $mesin = App\Models\Mesin::find($rekam->id_mesin);
                $user = App\Models\User::where('id_finger', $rekam->id_finger)->first();
            ?>
            <tr>
                <td>{{$n++}}</td>
                <td>{{(!empty($mesin))? $mesin->ip: ''}}</td>
                <td>{{(!empty($user))? $user->nama: ''}}</td>
                <td>{{$rekam->tanggal}}</td>
                <td>{{$rekam->masuk_1}}</td>
                <td>{{$rekam->keluar_1}}</td>
                <td>{{$rekam->masuk_2}}</td>
                <td>{{$rekam->keluar_2}}</td>
                <td>{{(empty($rekam->event))? $rekam->keterangan: $rekam->event}}</td>
                <td>{{(!empty($rekam->id_absen))? 'Terkirim': 'Belum Terkirim'}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
</script>
@endsection
