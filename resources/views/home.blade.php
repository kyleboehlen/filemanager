@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Your Files</h2>
                    <h4>Storage Remaining: {{ \formatBytes($storage_left) }}</h4>
                </div>

                <div class="card-body">
                    <a href="{{ route('upload') }}">
                        <button type="button" class="btn btn-primary btn-lg">Upload File</button>
                    </a>
                    <form class="float-right" action="{{ route('home') }}" method="GET">
                        <div class="form-group">
                            <label for="search">Search:</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Title, tag, description..." value="{{ $search }}">
                        </div>
                    </form>
                </div>

                {{-- Files List --}}
                <table class="table">
                    <tr>
                        <th>Title</th>
                        <th>Date Added</th>
                        <th>File Type</th>
                        <th>Size</th>
                    </tr>
                    @foreach($files as $file)
                        <tr>
                            <td>
                                <a href="{{ route('preview', ['slug' => $file->slug]) }}">
                                    {{ $file->title }}
                                </a>
                            </td>
                            <td>{{ $file->created_at->format('n/j/y h:i A') }}</td>
                            <td>{{ $file->fileType() }}</td>
                            <td>{{ \formatBytes($file->size) }}</td>
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
