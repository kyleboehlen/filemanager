@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $file->title }}</h2>
                </div>

                <div class="card-body">
                    <p class="lead">{{ $file->description }} <em>{{ implode(', ', $file->tags->pluck('value')->toArray() ) }}</em></p>
                </div>

                @if($file->fileType() == 'image')
                    <img src="{{ route('media', ['slug' => $file->slug]) }}" class="img-responsive mx-auto" />
                @else
                    <video controls>
                        <source src="{{ route('media', ['slug' => $file->slug]) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
