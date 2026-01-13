@extends('master')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-6">
            <h2>Products Management</h2>
        </div>
        <div class="col-lg-6 text-end">
            @can('product-create')
                <a href="{{ route('products.create') }}" class="btn btn-success">
                    <i class="fa fa-plus"></i> Create New Product
                </a>
            @endcan
        </div>
    </div>

    {{-- Toastr Notification Script --}}
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

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="products-table" class="table table-bordered table-hover w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Media</th>
                        <th width="28%">Action</th>
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
        $(function() {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'category_name'
                    },
                    {
                        data: 'price',
                        className: 'text-end'
                    },
                    {
                        data: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'media',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return data ? data : '<span class="text-muted">No image</span>';
                        }
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                createdRow: function(row, data, dataIndex) {
                    // Make sure that media and action columns display raw HTML
                    $('td', row).eq(6).html(data.media);
                    $('td', row).eq(7).html(data.action);
                }
            });
        });
    </script>
@endpush
