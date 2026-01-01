@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Categories</h2>
        </div>
        <div class="pull-right">
            @can('product-create')
            <a class="btn btn-success btn-sm mb-2" href="{{ route('categories.create') }}"><i class="fa fa-plus"></i> Create New Product</a>
            @endcan
        </div>
    </div>
</div>

@session('success')
    <div class="alert alert-success" role="alert">
        {{ $value }}
    </div>
@endsession

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Title</th>
        <th>Description</th>
        <th>Price</th>
        <th>Status</th>
        <th>Media</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($categories as $category)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $category->title }}</td>
        <td>{{ $category->description }}</td>
        <td>{{ $category->price }}</td>
        <td>{{ $category->status }}</td>
        <td>{{ $category->media }}</td>
        <td>
            <form action="{{ route('categories.destroy',$category->id) }}" method="POST" enctype="multipart/form-data">
                <a class="btn btn-info btn-sm" href="{{ route('categories.show',$category->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                @can('product-edit')
                <a class="btn btn-primary btn-sm" href="{{ route('categories.edit',$category->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                @endcan

                @csrf
                @method('DELETE')

                @can('product-delete')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                @endcan
            </form>
        </td>
    </tr>
    @endforeach
</table>

{!! $categories->links() !!}

<p class="text-center text-primary"><small>Belal Hasan</small></p>
@endsection
