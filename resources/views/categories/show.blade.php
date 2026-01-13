@extends('master')

@section('content')
    <div class="container">
        <h2>Category Details</h2>

        <p><strong>Title:</strong> {{ $category->title }}</p>
        <p><strong>Description:</strong> {{ $category->description }}</p>
        <p><strong>Status:</strong> {{ ucfirst($category->status) }}</p>


        <div class="col-md-12 mb-3">
            <div class="form-group">
                <strong>Category Image:</strong><br>

                @if (!empty($category->medias) && is_array($category->medias) && isset($category->medias[0]['url']))
                    <img src="{{ $category->medias[0]['url'] }}" alt="Category Image" width="150" class="img-thumbnail mb-2">
                @else
                    <span class="text-muted">No image available.</span>
                @endif
            </div>
        </div>




        <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm">
            Back
        </a>
    </div>
@endsection
