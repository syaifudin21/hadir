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
<h1 class="h2">Mesin</h1>
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
    <li class="breadcrumb-item active" aria-current="page">Mesin</li>
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
                <th>IP</th>
                <th>Key Mesin (Key)</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php $n=1;?>
        <tbody>
            @foreach($mesins as $mesin)
            <tr>
                <td>{{$n++}}</td>
                <td>{{$mesin->ip}}</td>
                <td>{{$mesin->nomor}}</td>
                <td>{{$mesin->status}}</td>
                <td>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" 
                    data-id="{{$mesin->id}}"
                    data-ip="{{$mesin->ip}}"
                    data-nomor="{{$mesin->nomor}}"
                    data-status="{{$mesin->status}}"
                    >Update</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="event.preventDefault(); document.getElementById('hapus-form{{$mesin->id}}').submit();" > Hapus </button>
                    <form id="hapus-form{{$mesin->id}}" action="{{ route('mesin.hapus', ['id'=> $mesin->id]) }}" method="POST" style="display: none;">
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
    <form method="POST" action="{{ route('mesin.tambah') }}">
        {{ csrf_field() }}
        <div class="form-group row">
            <label for="ip" class="col-sm-4 col-form-label text-md-right">IP</label>
            <div class="col-md-6">
                <input id="ip" type="text" class="form-control{{ $errors->has('ip') ? ' is-invalid' : '' }}" name="ip" value="{{ old('ip') }}" required autofocus>
                @if ($errors->has('ip'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('ip') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="nomor" class="col-sm-4 col-form-label text-md-right">Nomor Mesin  (Key)</label>
            <div class="col-md-6">
                <input id="nomor" type="text" class="form-control{{ $errors->has('nomor') ? ' is-invalid' : '' }}" name="nomor" value="{{ old('nomor') }}" required autofocus>
                @if ($errors->has('nomor'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('nomor') }}</strong>
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
                    <option value="Off">Off</option>
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
    <form method="post" action="{{route('mesin.update')}}">
      <div class="modal-body">
            @csrf @method('put')
            <input type="hidden" name="id" id="id">
            <div class="form-group row">
                <label for="ip" class="col-md-4 col-form-label text-md-right">{{ __('IP') }}</label>
                <div class="col-md-8">
                    <input id="ip" type="text" class="form-control{{ $errors->has('ip') ? ' is-invalid' : '' }}" name="ip" value="{{ old('ip') }}" required autofocus>
                    @if ($errors->has('ip'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('ip') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
             <div class="form-group row">
                <label for="nomor" class="col-md-4 col-form-label text-md-right">{{ __('Nomor Mesin (Key)') }}</label>
                <div class="col-md-8">
                    <input id="nomor" type="text" class="form-control{{ $errors->has('nomor') ? ' is-invalid' : '' }}" name="nomor" value="{{ old('nomor') }}" required autofocus>
                    @if ($errors->has('nomor'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('nomor') }}</strong>
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
                        <option value="Off">Off</option>
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
      var ip = button.data('ip')
      var nomor = button.data('nomor')
      var status = button.data('status')

      var modal = $(this)
      modal.find('.modal-title').text('Update Mesin')
      modal.find('#id').val(id)
      modal.find('#ip').val(ip)
      modal.find('#nomor').val(nomor)
      modal.find('#status').val(status)
    })

</script>
@endsection
