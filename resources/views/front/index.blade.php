@extends('front.front-template')
@section('css')
    <style>
        .full-height {
            height: 100vh;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
    </style>
@endsection
@section('content')
<div class="flex-center full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <center>
        <h1>SayaHadir</h1>
        <form action="{{url('cari')}}" method="get">
            <div class="input-group" style="width: 400px"> 
                <div class="input-group-prepend">
                  <div class="input-group-text" id="btnGroupAddon2">@nisn</div>
                </div>
                <input type="text" name="nisn" class="form-control" placeholder="Cek Absen disini" aria-label="Input group example" aria-describedby="btnGroupAddon2">
            </div>

        <br>
        <a href="{{url('tarik/upload')}}" class="btn btn-light btn-sm">Tarik Data dan Sinkron</a>
        <a href="{{url('upload/izin')}}" class="btn btn-light btn-sm">Buat Surat Izin</a>
        <button type="submit" class="btn btn-light btn-sm">Lihat Absensi Saya</button>
        </form>
        
        </center>
    </div>
</div>
@endsection

@section('script')

@endsection