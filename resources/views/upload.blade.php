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
                    <form>
                        <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" class="form-control" id="title" placeholder="Title">
                        </div>
                        <div class="form-group">
                          <label for="description">Description</label>
                          <textarea class="form-control" id="description" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group">
                          <label for="file">File</label>
                          <input type="file" id="file" accept="{{ implode(',', config('accept.file_types')) }}">
                          <p class="help-block">({{ implode(' and ', config('accept.file_types')) }} file types are supported)</p>
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control bootstrap-tagsinput" data-role="tagsinput" id="tags" value="tags">
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
