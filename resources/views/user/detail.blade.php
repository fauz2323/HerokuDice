@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Detail</h6>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                value="{{ $user->username }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Join Date</label>
                            <input type="text" class="form-control" id="exampleInputPassword1"
                                value="{{ $user->created_at }}" disabled>
                        </div>
                    </form>
                    <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Change Password
                    </button>

                    {{-- @foreach ($user->depo as $item)
                        <h1>{{ $item->wallet }}</h1>
                        <h3>{{ $item->total }}</h3>
                    @endforeach --}}
                    {{-- {{ $user->links() }} --}}
                    {{-- {{ $user->depo->total }} --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Deposit Detail</h6>
                </div>
                <div class="card-body">
                    <table class="table table-striped p-4">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Wallet</th>
                                <th scope="col">Id Deposit</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($depo as $item)
                                <tr>
                                    <td></td>
                                    <td>{{ $item->wallet }}</td>
                                    <td>{{ $item->idcode }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>{{ date_format($item->created_at, 'd-M-Y H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    {{ $depo->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">WD Detail</h6>
                </div>
                <div class="card-body">
                    <table class="table table-striped p-4">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Wallet</th>
                                <th scope="col">id WD</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wd as $item)
                                <tr>
                                    <td></td>
                                    <td>{{ $item->wallet }}</td>
                                    <td>{{ $item->idcode }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>{{ date_format($item->created_at, 'd-M-Y H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $wd->links() }}

                </div>
            </div>
        </div>
    </div>


    {{-- modals --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('change-userpass', $user->id) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
