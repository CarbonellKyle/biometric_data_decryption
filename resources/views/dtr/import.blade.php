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
            <div class="alert alert-success mt-4" role="alert">
                {{ session('file_uploaded') . ' has been uploaded. You can now import its data!' }}
            </div>
            <form action="{{ route('import') }}" method="POST" id="importForm">
                @csrf
                <input type="hidden" name="filename" value="{{ session('file_uploaded') }}">
                <div class="progress">
                    <div class="bar"></div>
                    <div class="percent">0%</div>
                </div>
                <button class="btn btn-success w-100 mt-4">Import Data</button>
            </form>
        @endif

    </div>
</div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
    <script src="https://malsup.github.com/jquery.form.js"></script>
    
    <script type="text/javascript">

        (function() {
            var bar = $('.bar');
            var percent = $('.percent');
            var status = $('#status');

            $('form').ajaxForm({
                beforeSubmit: validate,
                beforeSend: function() {
                    status.empty();
                    var percentVal = 0%;
                    var filenameValue = $('input[name=filename]').fieldValue();
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                success: function() {
                    var percentVal = 'Importing';
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                complete: function(xhr) {
                    status.html(xhr.responseText);
                    alert('Imported Successfully');
                    //window.location.href="/upload";
                }
            });
        })();

    </script>
@endpush