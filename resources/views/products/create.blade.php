@extends('master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm" href="{{ route('products.index') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul class="mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mt-3">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <select name="category_id" class="form-control">
                        <option value="">Select Category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                        placeholder="Enter title" required>
                </div>
            </div>

            {{-- Description --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="ckeditor form-control" id="editor" style="height:150px" name="description"
                        placeholder="Enter description">{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- Price --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price:</strong>
                    <input type="number" name="price" value="{{ old('price') }}" class="form-control"
                        placeholder="Enter price" required>
                </div>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <strong>Status:</strong>
                <select name="status" class="form-control" required>
                    <option value="">-- Select Status --</option>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- Product Images --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Product Images:</strong>
                    <input type="file" name="medias[]" id="medias" class="form-control" multiple accept="image/*">
                    <div class="form-text"><small>Accepts jpg, jpeg, png, webp up to 20MB each</small></div>
                    @error('medias')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div id="media-previews" class="mt-3 d-flex flex-wrap gap-2"></div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-sm mb-3 mt-2">
                    <i class="fa-solid fa-floppy-disk"></i> Submit
                </button>
            </div>

        </div>
    </form>

    <p class="text-center text-primary">
        <small>Belal Hasan</small>
    </p>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
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
    {{-- image preview --}}
    <script>
        document.getElementById('medias').addEventListener('change', function(event) {
            const previews = document.getElementById('media-previews');
            previews.innerHTML = ''; // Clear previous previews

            Array.from(event.target.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.border = '1px solid #ddd';
                        img.style.borderRadius = '4px';
                        previews.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
