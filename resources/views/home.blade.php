@extends('layouts.app')

@section('content')

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">BotFortune</li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex text-muted">
                        <div class="flex-shrink-0  me-3 align-self-center">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                    <i class="ri-group-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1">Users</p>
                            <h5 class="mb-3">{{ App\Models\UserDiceTron::count() }}</h5>
                            <br>
                        </div>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex text-muted">
                        <div class="flex-shrink-0  me-3 align-self-center">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                    <i class="ri-group-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1">Users Balance</p>
                            <h5 class="mb-3">{{ $balanceUser }} TRX</h5>
                            <br>
                        </div>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex text-muted">
                        <div class="flex-shrink-0  me-3 align-self-center">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                    <i class="ri-group-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1">Ballance Wallet</p>
                            <h5 class="mb-3">{{ $jsonData->data->trxbalance / 1000000 }} TRX</h5>
                            <br>
                        </div>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex text-muted">
                        <div class="flex-shrink-0  me-3 align-self-center">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                    <i class="ri-group-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1">Diff Balance</p>
                            <h5 class="mb-3">{{ $jsonData->data->trxbalance / 1000000 - $balanceUser }} TRX</h5>
                            <br>
                        </div>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">


                    <div>
                        <div id="chart"></div>
                    </div>
                </div>
                <!-- end card-body -->


                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->


        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@push('script')
    <script>
        var data = <?php echo json_encode($user); ?>;
        console.log(data);

        var options = {
            markers: {
                size: 1,
            },
            chart: {
                type: 'line'
            },
            series: [{
                name: 'User',
                data: data
            }],
            xaxis: {
                categories: ['jan', 'feb', 'mar', 'apr', 'may', 'june', 'july', 'aug', 'sep', 'oct', 'nov', 'dec']
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>
@endpush
