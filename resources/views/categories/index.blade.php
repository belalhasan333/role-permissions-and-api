@extends('master')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-6">
            <h2>Categories Management</h2>
        </div>
        <div class="col-lg-6 text-end">
            @can('category-create')
                <a href="{{ route('categories.create') }}" class="btn btn-success">
                    <i class="fa fa-plus"></i> Create New Category
                </a>
            @endcan
        </div>
    </div>

    {{-- Swift Toastr Notification Script --}}
    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    @endpush
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            $(function() {
                @if (session('success'))
                    toastr.success("{{ session('success') }}", 'Success', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3500
                    });
                @endif

                @if (session('error'))
                    toastr.error("{{ session('error') }}", 'Error', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3500
                    });
                @endif

                @if (session('info'))
                    toastr.info("{{ session('info') }}", 'Info', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3500
                    });
                @endif

                @if (session('warning'))
                    toastr.warning("{{ session('warning') }}", 'Warning', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3500
                    });
                @endif
            });
        </script>
    @endpush
    {{-- Swift Toastr Notification Script --}}
    <div class="card">
        <div class="card-body">
            <table id="categories-table" class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Media</th>
                        <th width="22%">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <p class="text-center text-primary mt-4"><small>Belal Hasan</small></p>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'media',
                        name: 'media',
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                pageLength: 10,
                language: {
                    processing: "<i class='fa fa-spinner fa-spin fa-2x'></i> Loading..."
                }
            });
        });
    </script>
@endpush
