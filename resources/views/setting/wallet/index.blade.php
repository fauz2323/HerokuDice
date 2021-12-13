@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Wallet Settings</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">BIGFAIR99</li>
                        <li class="breadcrumb-item active">settingWallet</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-body">
                <h3 class="card-title ">Tron Address</h3>
                <p class="card-text">{{ $wallet->tronAddress }}</p>
                <a href="#" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Edit</a>
            </div>
        </div>
    </div>

    {{-- modals --}}

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Main Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('walletStore', $wallet->id) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">WalletAddress</label>
                            <input type="text" class="form-control" name="address" value="{{ $wallet->tronAddress }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Key</label>
                            <input type="text" class="form-control" name="key">
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
