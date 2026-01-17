@extends('master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Category</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm" href="{{ route('categories.index') }}">
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

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mt-3">

            {{-- Title --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                        placeholder="Enter title">
                </div>
            </div>

            {{-- Description --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" id="description" style="height:150px" name="description" placeholder="Enter description">{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- Status --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Status:</strong>
                    <select name="status" class="form-control">
                        <option value="">-- Select Status --</option>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            {{-- Media --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="medias"><strong>Category Images:</strong></label>
                    <input type="file" name="medias[]" id="medias"
                        class="form-control @error('medias') is-invalid @enderror" multiple accept="image/*">
                    <div class="form-text"><small>Accepts jpg, jpeg, png, webp up to 20MB each</small></div>
                    @error('medias')
                        <span class="text-danger small d-block">{{ $message }}</span>
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
