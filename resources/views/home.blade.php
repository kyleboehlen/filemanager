@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Your Files</h2>
                </div>

                <div class="card-body">
                    <a href="{{ route('upload') }}">
                        <button type="button" class="btn btn-primary btn-lg">Upload File</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
