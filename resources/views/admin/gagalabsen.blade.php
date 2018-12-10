@extends('admin.admin-template')

@section('content')

<div class="nav-scroller bg-white box-shadow">
   <ul class="nav nav-underline" id="myTab" role="tablist">
        <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Gagal Absen</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tambah" role="tab" aria-controls="profile" aria-selected="false">Tambah</a>
        </li>
    </ul>
</div>

<br><br>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
<h1 class="h2">Gagal Absen</h1>
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
                <th>ID Finger</th>
                <th>Dimensi Waktu</th>
                <th>Waktu</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php $n=1;?>
        <tbody>
            @foreach($gagals as $gagal)
            <tr>
                <td>{{$n++}}</td>
                <td>{{$gagal->id_finger}}</td>
                <td>{{$gagal->dimensi_waktu}}</td>
                <td>{{$gagal->waktu_input}}</td>
                <td>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" 
                    data-id="{{$gagal->id}}"
                    data-id_finger="{{$gagal->id_finger}}"
                    data-dimensi_waktu="{{$gagal->dimensi_waktu}}"
                    data-waktu_input="{{$gagal->waktu_input}}"
                    >Update</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="event.preventDefault(); document.getElementById('hapus-form{{$gagal->id}}').submit();" > Hapus </button>
                    <form id="hapus-form{{$gagal->id}}" action="{{ route('gagalabsen.hapus', ['id'=> $gagal->id]) }}" method="POST" style="display: none;">
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
    <form method="POST" action="{{ route('gagalabsen.tambah') }}">
        {{ csrf_field() }}
        <div class="form-group row">
            <label for="id_finger" class="col-sm-4 col-form-label text-md-right">ID Finger</label>
            <div class="col-md-6">
                <input id="id_finger" type="text" class="form-control{{ $errors->has('id_finger') ? ' is-invalid' : '' }}" name="id_finger" value="{{ old('id_finger') }}" required autofocus>
                @if ($errors->has('id_finger'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('id_finger') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="dimensi_waktu" class="col-sm-4 col-form-label text-md-right">Dimensi Waktu</label>
            <div class="col-md-6">
                <select class="form-control{{ $errors->has('dimensi_waktu') ? ' is-invalid' : '' }}" name="dimensi_waktu" required>
                    <option selected disabled>Pilih Dimensi</option>
                    <option value="masuk_1">Masuk 1</option>
                    <option value="keluar_1">Keluar 1</option>
                    <option value="masuk_2">Masuk 2</option>
                    <option value="keluar_2">Keluar 2</option>
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
    <form method="post" action="{{route('gagalabsen.update')}}">
      <div class="modal-body">
            @csrf @method('put')
            <input type="hidden" name="id" id="id">
            <div class="form-group row">
                <label for="id_finger" class="col-md-4 col-form-label text-md-right">{{ __('ID Finger') }}</label>
                <div class="col-md-8">
                    <input id="id_finger" type="text" class="form-control{{ $errors->has('id_finger') ? ' is-invalid' : '' }}" name="id_finger" value="{{ old('id_finger') }}" required autofocus>
                    @if ($errors->has('id_finger'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('id_finger') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
             <div class="form-group row">
                <label for="waktu_input" class="col-md-4 col-form-label text-md-right">{{ __('Waktu Input') }}</label>
                <div class="col-md-8">
                    <input id="waktu_input" type="text" class="form-control{{ $errors->has('waktu_input') ? ' is-invalid' : '' }}" name="waktu_input" value="{{ old('waktu_input') }}" required autofocus>
                    @if ($errors->has('waktu_input'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('waktu_input') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
             <div class="form-group row">
                <label for="dimensi_waktu" class="col-md-4 col-form-label text-md-right">{{ __('Dimensi Waktu') }}</label>
                <div class="col-md-8">
                    <select id="dimensi_waktu" class="form-control{{ $errors->has('dimensi_waktu') ? ' is-invalid' : '' }}" name="dimensi_waktu" required>
                        <option selected disabled>Pilih Dimensi</option>
                        <option value="masuk_1">Masuk 1</option>
                        <option value="keluar_1">Keluar 1</option>
                        <option value="masuk_2">Masuk 2</option>
                        <option value="keluar_2">Keluar 2</option>
                    </select>
                    @if ($errors->has('dimensi_waktu'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('dimensi_waktu') }}</strong>
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
      var id_finger = button.data('id_finger')
      var dimensi_waktu = button.data('dimensi_waktu')
      var waktu_input = button.data('waktu_input')

      var modal = $(this)
      modal.find('.modal-title').text('Update Mesin')
      modal.find('#id').val(id)
      modal.find('#id_finger').val(id_finger)
      modal.find('#dimensi_waktu').val(dimensi_waktu)
      modal.find('#waktu_input').val(waktu_input)
    })

</script>
@endsection
