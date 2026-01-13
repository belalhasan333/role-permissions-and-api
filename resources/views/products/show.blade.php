@extends('master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Show Product</h2>
                <a class="btn btn-primary" href="{{ route('products.index') }}">Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <strong>Title:</strong>
                <span>{{ $product->title }}</span>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <strong>Description:</strong>
                <span>{{ $product->description }}</span>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <strong>Price:</strong>
                <span>
                    {{ number_format($product->price, 2) }}
                </span>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <strong>Status:</strong>
                <span>
                    @if ($product->status === 1 || $product->status === 'active' || $product->status === 'Active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </span>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <strong>Product Image:</strong><br>

                @if (!empty($product->medias) && is_array($product->medias) && isset($product->medias[0]['url']))
                    <img src="{{ $product->medias[0]['url'] }}" alt="Product Image" width="150"
                        class="img-thumbnail mb-2">
                @else
                    <span class="text-muted">No image available.</span>
                @endif
            </div>
        </div>

    </div>

    <p class="text-center text-primary"><small>Belal Hasan</small></p>
@endsection
