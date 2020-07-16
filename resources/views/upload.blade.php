@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Upload File</h2>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('upload.create') }}" enctype="multipart/form-data" method="POST">
                        @csrf

                        <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                          <label for="description">Description</label>
                          <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                          <label for="file">File</label>
                          <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept="{{ implode(',', config('accept.file_types')) }}">
                          <p class="help-block">({{ implode(' and ', config('accept.file_types')) }} file types are supported)</p>
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control bootstrap-tagsinput" data-role="tagsinput" id="tags" name="tags" placeholder="tag" value="{{ old('tags') }}">
                            <p class="help-block">(click enter to delimit tags, backspace to delete tags)</p>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
