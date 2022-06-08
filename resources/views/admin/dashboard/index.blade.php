@extends('admin.layouts.master')

@section('main-content')
	<section class="section">


        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">{{__('order.total_summary')}}</div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$totalProduct}}</div>
                                <div class="card-stats-item-label">{{__('levels.product')}}</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$totalCustomer->count()}}</div>
                                <div class="card-stats-item-label">{{__('levels.customer')}}</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$totalTodaySale}}</div>
                                <div class="card-stats-item-label">{{__('levels.today_sales')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{__('levels.total_sales')}}</h4>
                        </div>
                        <div class="card-body">
                           {{$totalSales->count()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="balance-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{__('levels.total_purchases')}}</h4>
                        </div>
                        <div class="card-body">
                            {{currencyFormat($purchaseAmount)}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="sales-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{__('levels.total_sales')}}</h4>
                        </div>
                        <div class="card-body">
                            {{currencyFormat($totalIncome)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('levels.budget_vs_sales')}}</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="158"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="earningGraph"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
		        <div class="card">
		            <div class="card-header">
		                <h4>{{ __('levels.recent_sales') }} <span class="badge badge-primary">{{ 0 }}</span></h4>
		                <div class="card-header-action">
		                    <a href="{{ route('admin.sale.index') }}" class="btn btn-primary">{{ __('View More') }} <i class="fas fa-chevron-right"></i></a>
		                </div>
		            </div>
		            <div class="card-body p-0">
		                <div class="table-responsive table-invoice">
		                    <table class="table table-striped">
		                        <tr>
		                            <th>{{ __('levels.invoice_id') }}</th>
		                            <th>{{ __('levels.customer') }}</th>
		                            <th>{{ __('levels.date') }}</th>
		                            <th>{{ __('levels.total') }}</th>
		                            <th>{{ __('levels.action') }}</th>
		                        </tr>
		                        @if(!blank($todaySale))
		                        	@foreach($todaySale as $sale)
			                        		@if($loop->index > 4) {
			                        			@break
			                        		@endif
				                        <tr>
				                            <td>{{ $sale->sale_no }}</td>
				                            <td>{{ $sale->user->name }}</td>
				                            <td>{{ date('d M Y', strtotime($sale->created_at)) }}</td>
				                            <td>{{ number_format($sale->total, 2) }}</td>
				                            <td>
				                                <a href="{{ route('admin.sale.show', $sale) }}" class="btn btn-sm btn-icon btn-primary"><i class="far fa-eye"></i></a>
				                            </td>
				                        </tr>
				                    @endforeach
				                @endif
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		    <div class="col-md-4">
				<div class="card">
				    <div class="profile-dashboard bg-maroon-light">
					    <a href="{{ route('admin.profile') }}">
					        <img src="{{ auth()->user()->images }}" alt="">
					    </a>
					    <h1>{{ auth()->user()->name }}</h1>
					    <p>
			            	{{ auth()->user()->getrole->name ?? '' }}
					    </p>
					</div>
			        <div class="list-group">
			            <li class="radius-none list-group-item list-group-item-action"><i class="fa fa-user"></i> {{ auth()->user()->username }}</li>
			            <li class="list-group-item list-group-item-action"><i class="fa fa-envelope"></i> {{ auth()->user()->email }}</li>
			            <li class="list-group-item list-group-item-action"><i class="fa fa-phone"></i> {{ auth()->user()->phone }}</li>
			            <li class="list-group-item list-group-item-action"><i class="fa fa-map"></i> {{ auth()->user()->address }}</li>
			        </div>
				</div>
		    </div>
		</div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/modules/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/modules/highcharts/highcharts.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/highcharts-more.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/data.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/drilldown.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/exporting.js') }}"></script>
	@include('admin.dashboard.SaleIncomeGraph')
@endsection
