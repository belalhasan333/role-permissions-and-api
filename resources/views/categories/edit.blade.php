@extends('master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Category</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('categories.index') }}"><i class="fa fa-arrow-left"></i>
                    Back</a>
            </div>
        </div>
    </div>

    {{-- Error Alert --}}
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

    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Title --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="title"><strong>Title:</strong></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $category->title) }}"
                        class="form-control @error('title') is-invalid @enderror" placeholder="Enter title" required>
                    @error('title')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="description"><strong>Description:</strong></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" style="height:150px"
                        name="description" placeholder="Enter description">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="status"><strong>Status:</strong></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                        required>
                        <option value="">-- Select Status --</option>
                        <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                    @error('status')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Media --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="medias"><strong>Category Images:</strong></label>
                    <input type="file" name="medias[]" id="medias"
                        class="form-control @error('medias') is-invalid @enderror" multiple accept="image/*">
                    @error('medias')
                        <span class="text-danger small d-block">{{ $message }}</span>
                    @enderror
                    @if (isset($category->medias) && is_array($category->medias) && count($category->medias))
                        <div class="mt-2">
                            @foreach ($category->medias as $i => $media)
                                <input type="hidden" name="existing_medias[]" value="{{ json_encode($media) }}">
                                <img src="{{ asset($media['url']) }}" alt="Category Media {{ $i }}"
                                    style="height:50px;width:70px;object-fit:cover;border-radius:4px;margin-right:4px;">
                            @endforeach
                        </div>
                    @endif
                    <div id="media-previews" class="mt-3 d-flex flex-wrap gap-2"></div>
                    <div class="form-text"><small>Accepts jpg, jpeg, png, webp up to 20MB each</small></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-sm mb-2 mt-2">
                    <i class="fa-solid fa-floppy-disk"></i> Submit
                </button>
            </div>
        </div>
    </form>

    <p class="text-center text-primary"><small>Belal Hasan</small></p>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
