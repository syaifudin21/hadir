@extends('admin.admin-template')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('gagal'))
        <div class="alert alert-danger" role="alert">
            {{ session('gagal') }}
        </div>
    @endif
    <div class="row">
        

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Sinkron Waktu</div>

                <div class="card-body">
                    
                    <a href="{{url('admin/sinctime')}}" class="btn btn-primary">Update Jam {{date("Y-m-d H:i:s")}}</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Download Rekaman</div>

                <div class="card-body">
                    <a href="{{url('admin/download/manual')}}" class="btn btn-primary">Download Rekaman</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Download Rekaman</div>

                <div class="card-body">
                    <a href="{{url('admin/download/clear')}}" class="btn btn-primary">Dawnload Clear Rekaman Mesin</a>
                </div>
            </div>
        </div>
    </div>
@endsection
