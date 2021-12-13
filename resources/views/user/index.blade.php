@extends('layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row d-flex justify-content-between">
                <div class="col md-6">
                    <h6 class="m-0  font-weight-bold text-primary">Data User</h6>
                </div>
                <div class="col md-6 d-flex flex-row-reverse">
                    <a href="{{ route('bonusAdd') }}" class="btn btn-primary">Transfer Bonus</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="users-table" width="100%" cellspacing="0">
                    <thead class="mt-5">
                        <tr>
                            <th width='30px'>number</th>
                            <th>Username</th>
                            <th>Balance</th>
                            <th>Deposit</th>
                            <th>WD</th>
                            <th>Total</th>
                            <th>Bonus</th>
                            <th>Wager</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '',
                columns: [{
                        data: 'no',
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'balance',
                        name: 'balance'
                    },
                    {
                        data: 'history.payIn',
                        name: 'history.payIn',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'history.payOut',
                        name: 'history.payOut',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'total',
                        name: 'total',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'bonus',
                        name: 'bonus',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'wager',
                        name: 'wager',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },

                ]
            });
        });
    </script>
@endpush
