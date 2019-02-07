@extends('admin.admin-template')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
<h1 class="h2">Rekaman Kehadiran</h1>
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
                <td>{!!(empty($rekam->masuk_1))? '<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" 
                    data-id="'.$rekam->id.'" data-finger="'.$rekam->id_finger.'" data-tanggal="'.$rekam->tanggal.'" data-dimensi="masuk_1"
                    >Gagal Absen</button>': $rekam->masuk_1!!}</td>
                <td>{!!(empty($rekam->keluar_1))? '<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" 
                    data-id="'.$rekam->id.'" data-finger="'.$rekam->id_finger.'" data-tanggal="'.$rekam->tanggal.'" data-dimensi="keluar_1"
                    >Gagal Absen</button>': $rekam->keluar_1!!}</td>
                <td>{!!(empty($rekam->masuk_2))? '<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" 
                    data-id="'.$rekam->id.'" data-finger="'.$rekam->id_finger.'" data-tanggal="'.$rekam->tanggal.'" data-dimensi="masuk_2"
                    >Gagal Absen</button>': $rekam->masuk_2!!}</td>
                <td>{!!(empty($rekam->keluar_2))? '<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" 
                    data-id="'.$rekam->id.'" data-finger="'.$rekam->id_finger.'" data-tanggal="'.$rekam->tanggal.'" data-dimensi="keluar_2"
                    >Gagal Absen</button>': $rekam->keluar_2!!}</td>
                <td>{{(empty($rekam->event))? $rekam->keterangan: $rekam->event}}</td>
                <td>{{(!empty($rekam->id_absen))? 'Terkirim': 'Belum Terkirim'}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form method="post" action="{{route('rekam.gagalabsen')}}">
      <div class="modal-body">
            @csrf
            <input type="hidden" name="id_rekam" id="id">
            <input type="hidden" name="id_finger" id="finger">
            <input type="hidden" name="dimensi_waktu" id="dimensi">
            <input type="hidden" name="tanggal" id="tanggal">
           
            <div class="form-group row">
                <label for="waktu_input" class="col-md-4 col-form-label text-md-right">{{ __('Waktu Input') }}</label>
                <div class="col-md-8">
                    <input id="waktu_input" type="time" class="form-control{{ $errors->has('waktu_input') ? ' is-invalid' : '' }}" name="waktu_input" value="{{ old('waktu_input') }}" required autofocus>
                    @if ($errors->has('waktu_input'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('waktu_input') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Tambah</button>
      </div>
    </form>
    </div>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
     $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id')
      var dimensi = button.data('dimensi')
      var finger = button.data('finger')
      var tanggal = button.data('tanggal')

      var modal = $(this)
      modal.find('.modal-title').text('Gagal Absen')
      modal.find('#id').val(id)
      modal.find('#dimensi').val(dimensi)
      modal.find('#finger').val(finger)
      modal.find('#tanggal').val(tanggal)
    })
</script>
@endsection
