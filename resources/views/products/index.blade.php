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

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="products-table" class="table table-bordered table-hover" style="width:100%">
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
        $(document).ready(function() {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: "text-center fw-bold"
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
                        data: 'category_name',
                        name: 'category.title'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        className: "text-end"
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: "text-center"
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
                    processing: "<div class='text-center py-4'><i class='fa fa-spinner fa-spin fa-3x text-primary'></i><br>Loading products...</div>"
                }
            });
        });
    </script>
@endpush
