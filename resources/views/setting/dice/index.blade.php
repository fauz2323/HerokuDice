@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-21">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Wallet Settings</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">BigFair99</li>
                        <li class="breadcrumb-item active">settingWallet</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-around">
        <div class="col-md-6">
            <div class="card card-body">
                <h3 class="card-title ">Cost WD</h3>
                <p class="card-text">{{ $cost->costWd }}</p>
                <a href="#" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Edit</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body">
                <h3 class="card-title ">Diff Balance</h3>
                <p class="card-text">{{ $cost->diff }}</p>
                <a href="#" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                    data-bs-target="#diff">Edit</a>
            </div>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-6">
            <div class="card card-body">
                <h3 class="card-title ">Bonus Settings</h3>
                <p class="card-text"></p>
                <a href="#" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                    data-bs-target="#bonus">Edit</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body">
                <h3 class="card-title ">Top Settings</h3>
                <p class="card-text"></p>
                <a href="#" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                    data-bs-target="#top">Edit</a>
            </div>
        </div>
    </div>

    {{-- modals --}}

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Cost WD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('cost.setting') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Cost WD</label>
                            <input type="text" class="form-control" name="costWd" value="{{ $cost->costWd }}">
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

    {{-- modals2 --}}
    <div class="modal fade" id="diff" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit min. Diff Balance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('diffStore.setting') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">diff</label>
                            <input type="text" class="form-control" name="diff" value="{{ $cost->diff }}">
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

    {{-- modal3 --}}
    <div class="modal fade" id="bonus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Bonus Lvl</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bonus.setting') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">IT</label>
                            <input type="text" class="form-control" name="itProfit" value="{{ $bonus->itProfit }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Management</label>
                            <input type="text" class="form-control" name="manajementProfit"
                                value="{{ $bonus->manajementProfit }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Lvl 1</label>
                            <input type="text" class="form-control" name="lvl1" value="{{ $bonus->lvl1 }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Lvl 2</label>
                            <input type="text" class="form-control" name="lvl2" value="{{ $bonus->lvl2 }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Lvl 3</label>
                            <input type="text" class="form-control" name="lvl3" value="{{ $bonus->lvl3 }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Cashback Wagered</label>
                            <input type="text" class="form-control" name="wagerBonus" value="{{ $bonus->wagerBonus }}">
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

    {{-- modal4 --}}
    <div class="modal fade" id="top" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Top</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('topStore') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Top</label>
                            <input type="text" class="form-control" name="top" value="{{ $cost->divider }}">
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
