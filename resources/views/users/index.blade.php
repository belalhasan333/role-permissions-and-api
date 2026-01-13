@extends('master')

@section('content')
    <div class="row mb-2">
        <div class="col-md-6">
            <h2>Users Management</h2>
        </div>
        <div class="col-md-6 text-end">
            <a class="btn btn-success" href="{{ route('users.create') }}">Create New User</a>
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

    <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th width="200px">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection

@push('scripts')
    {{-- js --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('users.data') !!}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });
        });
    </script>
@endpush
