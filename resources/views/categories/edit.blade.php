@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Category</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('categories.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
    {{-- Title --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" value="{{ old('title',$category->title) }}" class="form-control"
                        placeholder="Enter title">
                </div>
            </div>

            {{-- Description --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Enter description">{{ old('description',$category->description) }}</textarea>
                </div>
            </div>

            {{-- Status --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                        <select name="status" class="form-control">
                            <option value="">-- Select Status --</option>
                            <option value="active"
                                {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive"
                                {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                </div>
            </div>

            {{-- Media --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Category Image:</strong>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
          <button type="submit" class="btn btn-primary btn-sm mb-2 mt-2"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </div>
    </div>
</form>

<p class="text-center text-primary"><small>Belal Hasan</small></p>
@endsection
