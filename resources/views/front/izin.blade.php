@extends('front.search-template')
@section('css')
@endsection
@section('content')

<div class="row" style=" height: 80vh;">
    <div class="col-md-12" style="align-items: center; display: flex;justify-content: center;">
        @if(empty($_GET['nisn']))
          <form action="" method="get">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Masukkan NISN" aria-describedby="button-addon1" name="nisn">
              <div class="input-group-prepend">
                <button type="submit" class="btn btn-secondary btn-sm" type="button" id="button-addon1"><i class="material-icons">search</i></button>
              </div>
            </div>
            <button type="submit" class="btn btn-light btn-sm">Cari </button>
        </form>
        @else
        @if(!empty($user))
        @if (session('success'))
            <div class="alert alert-success">
                {!!session('success')!!}
            </div>
        @else

            @if (session('gagal'))
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {!!session('gagal')!!}
            </div>
            @endif

            <form action="{{route('izin.store')}}" method="post" enctype="multipart/form-data">
                @csrf
            <input type="hidden" name="nisn" value="{{$user->nisn}}">
            <input type="hidden" name="id_finger" value="{{$user->id_finger}}">
            <center><h3>{{$user->nama}} <small>{{$user->nisn}}</small></h3></center>
            <div class="form-group row">
                <label for="izin" class="col-md-3 col-form-label text-md-right">{{ __('Izin') }}</label>
                <div class="col-md-8">
                    <select class="form-control{{ $errors->has('izin') ? ' is-invalid' : '' }}" name="izin"  required autofocus>
                        <option disabled selected>Pilih Jenis Izin</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                    </select>

                    @if ($errors->has('izin'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('izin') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

              <div class="form-group row">
                <label for="alasan" class="col-md-3 col-form-label text-md-right">{{ __('Keterangan') }}</label>
                <div class="col-md-8">
                    <textarea class="form-control{{ $errors->has('alasan') ? ' is-invalid' : '' }}" name="alasan" placeholder="Keterangan Alasan"  required autofocus></textarea>

                    @if ($errors->has('alasan'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('alasan') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="bukti" class="col-md-3 col-form-label text-md-right">{{ __('Upload Foto') }}</label>

                <div class="col-md-8">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile02" name="bukti">
                        <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Upload Foto Surat izin</label>
                      </div>
                    </div>
                    @if ($errors->has('bukti'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bukti') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-3">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('Kirim') }}
                    </button>

                   
                </div>
            </div>
            </form>
            @endif            

        </div>
            
            @else
            NISN Tidak Terdaftar, Silahkan Menghubungi Admin
            @endif
        @endif
    </div>
</div>
    

@endsection
@section('script')
<script type="text/javascript">
    // penggunaan form file dengan bostrap 4
    $('.custom-file-input').on('change',function(){
      var fileName = $(this).val();
      console.log(fileName);
      $(this).next('.custom-file-label').addClass("selected").html(fileName);
    })
    // =================================
</script>
@endsection