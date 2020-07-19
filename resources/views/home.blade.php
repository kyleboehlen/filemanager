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

                {{-- Files List --}}
                <table class="table">
                    <tr>
                        <th>Title</th>
                        <th>Date Added</th>
                        <th>File Type</th>
                    </tr>
                    @foreach($files as $file)
                        <tr>
                            <td>
                                <a href="{{ route('preview', ['slug' => $file->slug]) }}">
                                    {{ $file->title }}
                                </a>
                            </td>
                            <td>{{ $file->created_at->format('n/j/y h:i A') }}</td>
                            <td>{{ $file->file_type() }}</td>
                        </tr>
                    @endforeach
                </table>

                {{-- Pagination --}}
                <div class="d-flex">
                    <div class="mx-auto">
                        {{ $files->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
