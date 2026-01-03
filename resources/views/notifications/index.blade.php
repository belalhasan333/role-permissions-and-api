{{-- @extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Notifications</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm" href="{{ route('notifications.index') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div> --}}

    {{-- Validation Errors --}}
    {{-- @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul class="mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form method="POST" action="{{ route('notifications.store') }}">
    @csrf

    <div>
        <label>Message</label>
        <input type="text" name="message" value="{{ old('message') }}">
        @error('message') <small>{{ $message }}</small> @enderror
    </div>

    <div>
        <label>Roles</label><br>

        <input type="checkbox" name="roles[]" value="admin"> Admin <br>
        <input type="checkbox" name="roles[]" value="user"> User <br>
        <input type="checkbox" name="roles[]" value="seller"> Seller <br>

        @error('roles') <small>{{ $message }}</small> @enderror
    </div>

    <button type="submit">Send Notification</button>
</form>


    <p class="text-center text-primary">
        <small>Belal Hasan</small>
    </p>
@endsection --}}
