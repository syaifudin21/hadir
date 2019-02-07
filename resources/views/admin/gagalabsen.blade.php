@extends('admin.admin-template')

@section('content')

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
                <th>ID Finger</th>
                <th>Dimensi Waktu</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php $n=1;?>
        <tbody>
            @foreach($gagals as $gagal)
            <?php
                $user = App\Models\User::where('id_finger', $gagal->id_finger)->first();
            ?>
            <tr>
                <td>{{$n++}}</td>
                <td>{{(!empty($user))? $user->nama: ''}}</td>
                <td>{{$gagal->dimensi_waktu}}</td>
                <td>{{$gagal->tanggal}}</td>
                <td>{{$gagal->waktu_input}}</td>
                <td>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" 
                    data-id="{{$gagal->id}}"
                    data-id_rekam="{{$gagal->id_rekam}}"
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
            <input type="hidden" name="id_rekam" id="id_rekam">
            
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
      var waktu_input = button.data('waktu_input')
      var id_rekam = button.data('id_rekam')

      var modal = $(this)
      modal.find('.modal-title').text('Update Mesin')
      modal.find('#id').val(id)
      modal.find('#waktu_input').val(waktu_input)
      modal.find('#id_rekam').val(id_rekam)
    })

</script>
@endsection
