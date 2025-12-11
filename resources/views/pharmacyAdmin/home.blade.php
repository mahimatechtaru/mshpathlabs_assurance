@extends('layout.mainlayout_admin',['activePage' => 'home'])

@section('title', __('pharmacy Dashboard'))

@section('content')

    <section class="section">
        @include('layout.breadcrumb',['title' => __('Pharmacy Dashboard')])

        <div class="row">
            <div class="col-xl-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-money-bill-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Sales Today') }}</h4>
                        </div>
                        <div class="card-body">
                            <h3>{{ $currency }}{{ $today_sells }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-tablets"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Medicines') }}</h4>
                        </div>
                        <div class="card-body">
                            <h3>{{ $total_medicines }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-sm-12 col-12">
                <div class="card card-chart">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Revenue') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                        <input type="hidden" name="years" value="{{ $revenueCharts['label'] }}">
                        <input type="hidden" name="data" value="{{ $revenueCharts['data'] }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script src="{{ url('assets_admin/js/chart.min.js') }}"></script>
    <script src="{{ url('assets_admin/js/chart.js') }}"></script>
@endsection
