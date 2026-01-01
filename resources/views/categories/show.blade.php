@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Category Details</h2>

    <p><strong>Title:</strong> {{ $category->title }}</p>
    <p><strong>Description:</strong> {{ $category->description }}</p>
    <p><strong>Status:</strong> {{ ucfirst($category->status) }}</p>
    

    <p><strong>Media:</strong> {{ json_encode($category->medias) }}</p>



    <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm">
        Back
    </a>
</div>
@endsection
