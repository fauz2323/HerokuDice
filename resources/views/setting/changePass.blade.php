@extends('layouts.app')

@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('changePass') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Old Password</label>
                    <input type="password" name="old" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">New Password</label>
                    <input type="password" name="newPass" class="form-control" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
