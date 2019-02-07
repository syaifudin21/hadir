@extends('admin.admin-template')

@section('content')

<div class="nav-scroller bg-white box-shadow">
   <ul class="nav nav-underline" id="myTab" role="tablist">
        <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Waktu</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tambah" role="tab" aria-controls="profile" aria-selected="false">Tambah</a>
        </li>
    </ul>
</div>

<br><br>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
<h1 class="h2">Waktu Dimensi</h1>
<div class="btn-toolbar mb-2 mb-md-0">
  <div class="btn-group mr-2">
    <button class="btn btn-sm btn-outline-secondary">Share</button>
    <button class="btn btn-sm btn-outline-secondary">Export</button>
  </div>
  <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
    <span data-feather="calendar"></span>
    This week
  </button>
</div>
</div>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-white" style="padding: 0px">
    <li class="breadcrumb-item active" aria-current="page">Waktu Dimensi</li>
  </ol>
</nav>


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
                <th>Masuk 1</th>
                <th>Keluar 1</th>
                <th>Masuk 2</th>
                <th>Keluar 2</th>
                <th>Batas Pencatatan</th>
                <th>Singkron Auto</th>
                <th>Clear Auto</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php $n=1;?>
        <tbody>
            @foreach($waktus as $waktu)
            <tr>
                <td>{{$n++}}</td>
                <td>{{$waktu->masuk_1}}</td>
                <td>{{$waktu->keluar_1}}</td>
                <td>{{$waktu->masuk_2}}</td>
                <td>{{$waktu->keluar_2}}</td>
                <td>{{$waktu->batas_pencatatan}}</td>
                <td>{{$waktu->singkron_auto}}</td>
                <td>{{$waktu->clear_auto}}</td>
                <td>{{$waktu->status}}</td>
                <td>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" 
                    data-id="{{$waktu->id}}"
                    data-masuk_1="{{$waktu->masuk_1}}"
                    data-keluar_1="{{$waktu->keluar_1}}"
                    data-masuk_2="{{$waktu->masuk_2}}"
                    data-keluar_2="{{$waktu->keluar_2}}"
                    data-batas_pencatatan="{{$waktu->batas_pencatatan}}"
                    data-singkron_auto="{{$waktu->singkron_auto}}"
                    data-clear_auto="{{$waktu->clear_auto}}"
                    data-status="{{$waktu->status}}"
                    >Update</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="event.preventDefault(); document.getElementById('hapus-form{{$waktu->id}}').submit();" > Hapus </button>
                    <form id="hapus-form{{$waktu->id}}" action="{{ route('waktu.hapus', ['id'=> $waktu->id]) }}" method="POST" style="display: none;">
                        {{ csrf_field() }}{{ method_field('DELETE') }}
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    </div>

    <div class="tab-pane fade" id="tambah" role="tabpanel" aria-labelledby="profile-tab">
    <form method="POST" action="{{ route('waktu.tambah') }}">
        {{ csrf_field() }}
        <div class="form-group row">
            <label for="masuk_1" class="col-sm-4 col-form-label text-md-right">Masuk 1</label>
            <div class="col-md-6">
                <input id="masuk_1" type="time" class="form-control{{ $errors->has('masuk_1') ? ' is-invalid' : '' }}" name="masuk_1" required autofocus  value="04:00">
                @if ($errors->has('masuk_1'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('masuk_1') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="keluar_1" class="col-sm-4 col-form-label text-md-right">Keluar 1</label>
            <div class="col-md-6">
                <input id="keluar_1" type="time" class="form-control{{ $errors->has('keluar_1') ? ' is-invalid' : '' }}" name="keluar_1" required autofocus  value="09:00">
                @if ($errors->has('keluar_1'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('keluar_1') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="masuk_2" class="col-sm-4 col-form-label text-md-right">Masuk 2</label>
            <div class="col-md-6">
                <input id="masuk_2" type="time" class="form-control{{ $errors->has('masuk_2') ? ' is-invalid' : '' }}" name="masuk_2" required autofocus value="14:00">
                @if ($errors->has('masuk_2'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('masuk_2') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="keluar_2" class="col-sm-4 col-form-label text-md-right">Keluar 2</label>
            <div class="col-md-6">
                <input id="keluar_2" type="time" class="form-control{{ $errors->has('keluar_2') ? ' is-invalid' : '' }}" name="keluar_2" required autofocus value="16:00">
                @if ($errors->has('keluar_2'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('keluar_2') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="batas_pencatatan" class="col-sm-4 col-form-label text-md-right">Batas Pencatatan</label>
            <div class="col-md-6">
                <input id="batas_pencatatan" type="time" class="form-control{{ $errors->has('batas_pencatatan') ? ' is-invalid' : '' }}" name="batas_pencatatan" required autofocus  value="19:00">
                @if ($errors->has('batas_pencatatan'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('batas_pencatatan') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="singkron_auto" class="col-sm-4 col-form-label text-md-right">Singkron Auto</label>
            <div class="col-md-6">
                <input id="singkron_auto" type="time" class="form-control{{ $errors->has('singkron_auto') ? ' is-invalid' : '' }}" name="singkron_auto"  required autofocus  value="07:00">
                @if ($errors->has('singkron_auto'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('singkron_auto') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="clear_auto" class="col-sm-4 col-form-label text-md-right">Clear Auto</label>
            <div class="col-md-6">
                <input id="clear_auto" type="time" class="form-control{{ $errors->has('clear_auto') ? ' is-invalid' : '' }}" name="clear_auto" required autofocus value="21:00">
                @if ($errors->has('clear_auto'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('clear_auto') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    
        <div class="form-group row">
            <label for="status" class="col-sm-4 col-form-label text-md-right">Status</label>
            <div class="col-md-6">
                <select class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status">
                    <option selected disabled>Pilih Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Non Aktif">Non Aktif</option>
                </select>
            </div>
        </div>
            <div class="form-group row">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
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
    <form method="post" action="{{route('waktu.update')}}">
      <div class="modal-body">
            @csrf @method('put')
            <input type="hidden" name="id" id="id">
            <div class="form-group row">
                <label for="masuk_1" class="col-md-4 col-form-label text-md-right">{{ __('Masuk 1') }}</label>
                <div class="col-md-8">
                    <input id="masuk_1" type="time" class="form-control{{ $errors->has('masuk_1') ? ' is-invalid' : '' }}" name="masuk_1" value="{{ old('masuk_1') }}" required autofocus>
                    @if ($errors->has('masuk_1'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('masuk_1') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="keluar_1" class="col-md-4 col-form-label text-md-right">{{ __('Keluar 1') }}</label>
                <div class="col-md-8">
                    <input id="keluar_1" type="time" class="form-control{{ $errors->has('keluar_1') ? ' is-invalid' : '' }}" name="keluar_1" value="{{ old('keluar_1') }}" required autofocus>
                    @if ($errors->has('keluar_1'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('keluar_1') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="masuk_2" class="col-md-4 col-form-label text-md-right">{{ __('Masuk 2') }}</label>
                <div class="col-md-8">
                    <input id="masuk_2" type="time" class="form-control{{ $errors->has('masuk_2') ? ' is-invalid' : '' }}" name="masuk_2" value="{{ old('masuk_2') }}" required autofocus>
                    @if ($errors->has('masuk_2'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('masuk_2') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="keluar_2" class="col-md-4 col-form-label text-md-right">{{ __('Keluar 2') }}</label>
                <div class="col-md-8">
                    <input id="keluar_2" type="time" class="form-control{{ $errors->has('keluar_2') ? ' is-invalid' : '' }}" name="keluar_2" value="{{ old('keluar_2') }}" required autofocus>
                    @if ($errors->has('keluar_2'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('keluar_2') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="batas_pencatatan" class="col-md-4 col-form-label text-md-right">{{ __('Batas Pencatatan') }}</label>
                <div class="col-md-8">
                    <input id="batas_pencatatan" type="time" class="form-control{{ $errors->has('batas_pencatatan') ? ' is-invalid' : '' }}" name="batas_pencatatan" value="{{ old('batas_pencatatan') }}" required autofocus>
                    @if ($errors->has('batas_pencatatan'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('batas_pencatatan') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="singkron_auto" class="col-md-4 col-form-label text-md-right">{{ __('Singkron Auto') }}</label>
                <div class="col-md-8">
                    <input id="singkron_auto" type="time" class="form-control{{ $errors->has('singkron_auto') ? ' is-invalid' : '' }}" name="singkron_auto" value="{{ old('singkron_auto') }}" required autofocus>
                    @if ($errors->has('singkron_auto'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('singkron_auto') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="clear_auto" class="col-md-4 col-form-label text-md-right">{{ __('Clear Auto') }}</label>
                <div class="col-md-8">
                    <input id="clear_auto" type="time" class="form-control{{ $errors->has('clear_auto') ? ' is-invalid' : '' }}" name="clear_auto" value="{{ old('clear_auto') }}" required autofocus>
                    @if ($errors->has('clear_auto'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('clear_auto') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
             <div class="form-group row">
                <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                <div class="col-md-8">
                    <select id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status">
                        <option>Pilih Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non Aktif">Non Aktif</option>
                    </select>
                    @if ($errors->has('status'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('status') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
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
      var masuk_1 = button.data('masuk_1')
      var keluar_1 = button.data('keluar_1')
      var masuk_2 = button.data('masuk_2')
      var keluar_2 = button.data('keluar_2')
      var batas_pencatatan = button.data('batas_pencatatan')
      var singkron_auto = button.data('singkron_auto')
      var clear_auto = button.data('clear_auto')
      var status = button.data('status')

      var modal = $(this)
      modal.find('.modal-title').text('Update Mesin')
      modal.find('#id').val(id)
      modal.find('#masuk_1').val(masuk_1)
      modal.find('#keluar_1').val(keluar_1)
      modal.find('#masuk_2').val(masuk_2)
      modal.find('#keluar_2').val(keluar_2)
      modal.find('#batas_pencatatan').val(batas_pencatatan)
      modal.find('#singkron_auto').val(singkron_auto)
      modal.find('#clear_auto').val(clear_auto)
      modal.find('#status').val(status)
    })

</script>
@endsection
