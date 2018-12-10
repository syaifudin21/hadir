@extends('admin.admin-template')

@section('content')

<div class="nav-scroller bg-white box-shadow">
   <ul class="nav nav-underline" id="myTab" role="tablist">
        <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Mesin</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tambah" role="tab" aria-controls="profile" aria-selected="false">Tambah</a>
        </li>
    </ul>
</div>

<br><br>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
<h1 class="h2">Users</h1>
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
    <li class="breadcrumb-item active" aria-current="page">User</li>
  </ol>
</nav>


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
                <th>NISN</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php $n=1;?>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$n++}}</td>
                <td>{{$user->id_finger}}</td>
                <td>{{$user->nisn}}</td>
                <td>{{$user->nama}}</td>
                <td>{{$user->status}}</td>
                <td>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" 
                    data-id="{{$user->id}}"
                    data-id_finger="{{$user->id_finger}}"
                    data-nisn="{{$user->nisn}}"
                    data-nama="{{$user->nama}}"
                    data-status="{{$user->status}}"
                    >Update</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="event.preventDefault(); document.getElementById('hapus-form{{$user->id}}').submit();" > Hapus </button>
                    <form id="hapus-form{{$user->id}}" action="{{ route('user.hapus', ['id'=> $user->id]) }}" method="POST" style="display: none;">
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
    <form method="POST" action="{{ route('user.tambah') }}">
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
            <label for="nama" class="col-sm-4 col-form-label text-md-right">Nama</label>
            <div class="col-md-6">
                <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" required autofocus>
                @if ($errors->has('nama'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('nama') }}</strong>
                    </span>
                @endif
            </div>
        </div>
          <div class="form-group row">
            <label for="nisn" class="col-sm-4 col-form-label text-md-right">NISN</label>
            <div class="col-md-6">
                <input id="nisn" type="text" class="form-control{{ $errors->has('nisn') ? ' is-invalid' : '' }}" name="nisn" value="{{ old('nisn') }}" required autofocus>
                @if ($errors->has('nisn'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('nisn') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-4 col-form-label text-md-right">Password</label>
            <div class="col-md-6">
                <input id="password" type="text" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required autofocus>
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="col-sm-4 col-form-label text-md-right">Status</label>
            <div class="col-md-6">
                <select class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status">
                    <option disabled>Pilih Status</option>
                    <option value="Siswa" selected>Siswa</option>
                    <option value="Guru">Guru</option>
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
    <form method="post" action="{{route('user.update')}}">
      <div class="modal-body">
            @csrf @method('put')
            <input type="hidden" name="id" id="id">
            <div class="form-group row">
                <label for="id_finger" class="col-md-4 col-form-label text-md-right">{{ __('ID_Finger') }}</label>
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
                <label for="nisn" class="col-md-4 col-form-label text-md-right">{{ __('NISN') }}</label>
                <div class="col-md-8">
                    <input id="nisn" type="text" class="form-control{{ $errors->has('nisn') ? ' is-invalid' : '' }}" name="nisn" value="{{ old('nisn') }}" required autofocus>
                    @if ($errors->has('nisn'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('nisn') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>
                <div class="col-md-8">
                    <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" required autofocus>
                    @if ($errors->has('nama'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('nama') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                <div class="col-md-8">
                    <input id="password" type="text" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('nama') }}" autofocus>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
             <div class="form-group row">
                <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                <div class="col-md-8">
                    <select id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status">
                        <option>Pilih Status</option>
                        <option value="Siswa">Siswa</option>
                        <option value="Guru">Guru</option>
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
      var id_finger = button.data('id_finger')
      var nisn = button.data('nisn')
      var nama = button.data('nama')
      var status = button.data('status')

      var modal = $(this)
      modal.find('.modal-title').text('Update User')
      modal.find('#id').val(id)
      modal.find('#id_finger').val(id_finger)
      modal.find('#nisn').val(nisn)
      modal.find('#nama').val(nama)
      modal.find('#status').val(status)
    })

</script>
@endsection
