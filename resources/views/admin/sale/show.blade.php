@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('sale.sales_view') }}</h1>
            {{ Breadcrumbs::render('sale/view') }}
        </div>
        <div class="section-body">
            <div class="card-header">
                <a href="#" class="btn btn-icon icon-left btn-primary" onclick="printDiv('printablediv')"><i class="fas fa-print"></i> {{ __('levels.print') }}
                </a>
            </div>
            <div class="card">
                <div class="card-body"  id="printablediv">
                    <style>
                        @media print {
                            .img-1{
                                width: 280px;
                            }
                        }
                    </style>
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">
                                <small class="pull-right small-text"><?='Create Date'.' : '.date('d M Y')?></small>
                            </h2>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-7 invoice-col">
                            <i class="fa fa-3x fa-truck padding010 text-muted"></i>
                            <address>
                                <strong>{{optional($sale->shop)->name}}</strong><br>
                                {{__('levels.phone')}} : {{optional($sale->shop->user)->phone}}<br>
                                {{__('levels.email')}} : {{optional($sale->shop->user)->email}}<br>
                                {{optional($sale->shop)->address}}
                            </address>
                        </div>

                        <div class="col-sm-5 invoice-col ">
                            <address>
                                <b class="pull-right">{{__('sale.sale_no')}}# : {{$sale->sale_no}}</b><br>
                                <b class="pull-right">{{__('sale.date')}} : {{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y')}}</b><br>
                                <b class="pull-right">{{__('sale.customer')}} : {{$sale->user->name}}</b><br>
                                <b class="pull-right">{{__('levels.phone')}} : {{$sale->user->phone}}</b><br>
                                <b class="pull-right">{{__('sale.paid_by')}} : {{__('Cash/Credit')}}</b><br>
                                <b class="pull-right "><img class="mr-1 img-1" src="{{ $sale->barcodeprint }}" alt="POS-{{$sale->id}}"><img src="{{ $sale->qrcodeprint }}" alt="POS-{{$sale->id}}"></b>
                            </address>
                        </div>
                    </div>

                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered product-style">
                                    <thead>
                                    <tr>
                                        <th class="row-cols-sm-1">{{__('#')}}</th>
                                        <th class="row-cols-sm-3">{{__('sale.products')}}</th>
                                        <th class="row-cols-sm-3">{{__('sale.unit')}}</th>
                                        <th class="row-cols-sm-1" >{{__('sale.unit_price')}}</th>
                                        <th class="row-cols-sm-1" >{{__('sale.tax')}}</th>
                                        <th class="row-cols-sm-1">{{__('sale.quantity')}}</th>
                                        <th class="row-cols-sm-2">{{__('sale.subtotal')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $subtotal = 0; $totalsubtotal = 0; $i=1 ?>
                                    <?php $subtotal = 0; $totalsubtotal = 0; $i=1; foreach ($sale->items as $item) { $subtotal = ($item->unit_price +$item->tax_amount)* $item->quantity; $totalsubtotal += $subtotal; ?>
                                    <tr>
                                        <td data-title="#">
                                            <?php echo $i; ?>
                                        </td>

                                        <td data-title="Product">
                                            @if(optional($item->product)->type ==10)
                                                {{optional($item->product)->barcode.'-'.$item->product_item->id}}-{{optional($item->product)->name }} ({{$item->product_item->name}})
                                            @else
                                                {{optional($item->product)->barcode}}-{{optional($item->product)->name}}
                                            @endif
                                        </td>

                                        <td data-title="Selling price">
                                            {{optional($item->product->unit)->name}}
                                        </td>
                                        <td data-title="Selling price">
                                           {{currencyFormat($item->unit_price)}}
                                        </td>
                                        <td data-title="Selling price">
                                           {{currencyFormat($item->tax_amount)}}
                                        </td>

                                        <td data-title="Quantity">
                                            {{number_format($item->quantity,2)}}
                                        </td>
                                        <td data-title="Subtotal ">
                                            {{currencyFormat($subtotal)}}
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6"><span class="pull-right"><b>{{__('sale.total_order_tax')}}</b></span></td>
                                        <td><b>{{currencyFormat($sale->tax_amount)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"><span class="pull-right"><b>{{__('sale.total_amount')}}</b></span></td>
                                        <td><b>{{currencyFormat($totalsubtotal+$sale->tax_amount)}}</b></td>
                                    </tr>

                                    <tr>
                                        <td colspan="6"><span class="pull-right"><b>{{__('sale.total_credit_amount')}}</b></span></td>
                                        <td><b>{{currencyFormat($sale->paid_credit_amount)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"><span class="pull-right"><b>{{__('sale.total_cash_amount')}}</b></span></td>
                                        <td><b>{{currencyFormat($sale->paid_cash_amount)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"><span class="pull-right"><b>{{__('sale.total_paid_amount')}}</b></span></td>
                                        <td><b>{{currencyFormat($sale->paid_amount)}}</b></td>
                                    </tr>

                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-sm-9 col-xs-12 pull-left">
                            <p>{{$sale->description}}</p>
                        </div>
                        <div class="col-sm-3 col-xs-12 pull-right">
                            <div class="well well-sm">
                                <p>
                                    {{__('sale.create_by')}} : {{optional($sale->creator)->name}}
                                    <br>
                                    {{__('sale.date')}}:{{\Carbon\Carbon::parse($sale->created_at)->format('d M Y, h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('js/sale/show.js') }}"></script>
@endsection
