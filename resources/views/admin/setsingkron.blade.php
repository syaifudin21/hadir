@extends('admin.admin-template')

@section('content')

<div class="nav-scroller bg-white box-shadow">
   <ul class="nav nav-underline" id="myTab" role="tablist">
        <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Set Singkron</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tambah" role="tab" aria-controls="profile" aria-selected="false">Tambah</a>
        </li>
    </ul>
</div>

<br><br>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
<h1 class="h2">Set Singkron</h1>
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
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php $n=1;?>
        <tbody>
            @foreach($setsingkrons as $setsingkron)
            <tr>
                <td>{{$n++}}</td>
                <td>{{$setsingkron->time}}</td>
                <td>{{$setsingkron->status}}</td>
                <td>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" 
                    data-id="{{$setsingkron->id}}"
                    data-time="{{$setsingkron->time}}"
                    data-status="{{$setsingkron->status}}"
                    >Update</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="event.preventDefault(); document.getElementById('hapus-form{{$setsingkron->id}}').submit();" > Hapus </button>
                    <form id="hapus-form{{$setsingkron->id}}" action="{{ route('setsingkron.hapus', ['id'=> $setsingkron->id]) }}" method="POST" style="display: none;">
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
    <form method="POST" action="{{ route('setsingkron.tambah') }}">
        {{ csrf_field() }}
        <div class="form-group row">
            <label for="time" class="col-sm-4 col-form-label text-md-right">Time</label>
            <div class="col-md-6">
                <input id="time" type="time" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" name="time" value="{{ old('time') }}" required autofocus>
                @if ($errors->has('time'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('time') }}</strong>
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
    <form method="post" action="{{route('setsingkron.update')}}">
      <div class="modal-body">
            @csrf @method('put')
            <input type="hidden" name="id" id="id">
            <div class="form-group row">
                <label for="time" class="col-md-3 col-form-label text-md-right">{{ __('Time') }}</label>
                <div class="col-md-9">
                    <input id="time" type="time" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" name="time" value="{{ old('time') }}" required autofocus>
                    @if ($errors->has('time'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('time') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
             <div class="form-group row">
                <label for="status" class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>
                <div class="col-md-9">
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
      var time = button.data('time')
      var status = button.data('status')

      var modal = $(this)
      modal.find('.modal-title').text('Update Mesin')
      modal.find('#id').val(id)
      modal.find('#time').val(time)
      modal.find('#status').val(status)
    })

</script>
@endsection
