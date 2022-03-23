@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-8 offset-2 my-2">
        <h2 class="text-center">Upload .dat File</h2>

        <a class="btn btn-primary mt-4" href="{{ route('index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg> Back
        </a>

        @if(Session::has('file_uploaded'))
            <div class="alert alert-success mt-4" role="alert">
                {{ session('file_uploaded') . ' has been uploaded. You can now import its data!' }}
            </div>
        @endif

        @if(Session::has('data_imported'))
            <div class="alert alert-success mt-4" role="alert">
                {{Session::get('data_imported')}}
            </div>
        @endif

        @if(Session::has('upload_fail'))
            <div class="alert alert-danger mt-4" role="alert">
                {{Session::get('upload_fail')}}
            </div>
        @endif

        <form action="{{ route('uploadSubmit') }}" method="POST" enctype="multipart/form-data" class="mt-5" @if(Session::has('file_uploaded')) hidden @endif>
            @csrf
            <input type="file" name="file" class="form-control">
            <button class="btn btn-primary w-100 mt-4" type="submit">Upload File</button>
        </form>

        @if(Session::has('file_uploaded'))
            <a class="btn btn-success w-100 mt-4" href="/import/{{ session('file_uploaded') }}">Import Data</a>
        @endif

    </div>
</div>
@endsection
