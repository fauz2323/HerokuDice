@extends('layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Log Game</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="users-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width='30px'>number</th>
                            <th>Username</th>
                            <th>Bet</th>
                            <th>Number High</th>
                            <th>PayOut</th>
                            <th>Result</th>
                            <th>Number</th>
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
                        data: 'bet',
                        name: 'bet'
                    },
                    {
                        data: 'high',
                        name: 'high',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'payOut',
                        name: 'payOut',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'result',
                        name: 'result',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'number',
                        name: 'number',
                        orderable: false,
                        searchable: false,
                    },
                ]
            });
        });
    </script>
@endpush
