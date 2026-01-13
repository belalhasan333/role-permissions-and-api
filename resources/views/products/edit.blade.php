@extends('master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('products.index') }}"><i class="fa fa-arrow-left"></i>
                    Back</a>
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

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            {{-- Category --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Category:</strong>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Title --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" value="{{ old('title', $product->title) }}" class="form-control"
                        placeholder="Enter title" required>
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="ckeditor form-control" id="description" style="height:150px" name="description"
                        placeholder="Enter description">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Price --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price:</strong>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control"
                        placeholder="Enter price" required>
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Status:</strong>
                    <select name="status" class="form-control" required>
                        <option value="">-- Select Status --</option>
                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active
                        </option>
                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                            Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Product Images --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Product Images:</strong>
                    <input type="file" name="medias[]" class="form-control" multiple>
                    @if (is_array($product->medias))
                        <div class="mt-2 mb-2">
                            @foreach ($product->medias as $i => $media)
                                <input type="hidden" name="existing_medias[{{ $i }}]"
                                    value='{{ json_encode($media) }}'>
                                @if (!empty($media['url']))
                                    <img src="{{ str_starts_with($media['url'], ['/', 's']) ? asset($media['url']) : asset('storage/' . $media['url']) }}"
                                        style="height:50px;width:70px;object-fit:cover;border-radius:6px;margin-right:4px;">
                                @endif
                            @endforeach
                        </div>
                    @endif
                    @error('medias')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-sm mb-2 mt-2"><i class="fa-solid fa-floppy-disk"></i>
                    Submit
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                        '|', 'outdent', 'indent', '|', 'undo', 'redo'
                    ]
                },
                language: 'en',
                height: 350
            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });
    </script>
@endpush
