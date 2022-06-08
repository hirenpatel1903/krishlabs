@extends('admin.layouts.master')

@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('order.purchaseView') }}</h1>
            {{ Breadcrumbs::render('purchase/view') }}
        </div>
        <div class="section-body">
            <div class="card-header">
                <a href="#" class="btn btn-icon icon-left btn-primary" onclick="printDiv('printablediv')"><i class="fas fa-print"></i> {{ __('levels.print') }}
                </a>
            </div>
            <div class="card">
                <div class="card-body" id="printablediv">
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
                        <div class="col-sm-7 invoice-col purchase-table-font">
                            <i class="fa fa-3x fa-truck padding010 text-muted"></i>
                            <address>
                                <strong>{{optional($purchase->shop)->name}}</strong><br>
                                {{__('levels.phone')}} : {{optional($purchase->shop->user)->phone}}<br>
                                {{__('levels.email')}} : {{optional($purchase->shop->user)->email}}<br>
                                {{optional($purchase->shop)->address}}
                            </address>
                        </div>

                        <div class="col-sm-5 invoice-col ">
                            <address>
                                <b class="pull-right">{{__('levels.reference_no')}} : {{$purchase->purchases_no}}</b><br>
                                <b class="pull-right">{{__('levels.date')}} : {{ \Carbon\Carbon::parse($purchase->date)->format('d M Y')}}</b><br>
                                <span class="pull-right "><img class="mr-1 img-1" src="{{ $purchase->barcodeprint }}" alt="POS-{{$purchase->id}}"> <img src="{{ $purchase->qrcodeprint }}" alt="POS-{{$purchase->id}}"> </span>
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
                                        <th class="row-cols-sm-3">{{__('levels.product')}}</th>
                                        <th class="row-cols-sm-1">{{__('levels.unit')}}</th>
                                        <th class="row-cols-sm-1" >{{__('levels.unit_price')}}</th>
                                        <th class="row-cols-sm-1">{{__('levels.quantity')}}</th>
                                        <th class="row-cols-sm-2">{{__('levels.subtotal')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $subtotal = 0; $totalsubtotal = 0; $i=1 ?>
                                <?php $subtotal = 0; $totalsubtotal = 0; $i=1; foreach ($purchase->items as $item) { $subtotal = ($item->unit_price * $item->quantity); $totalsubtotal += $subtotal; ?>
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
                                            {{number_format($item->unit_price, 2)}}
                                        </td>

                                        <td data-title="Quantity">
                                           {{number_format($item->quantity, 2)}}
                                        </td>
                                        <td data-title="Subtotal ">
                                            {{number_format($subtotal, 2)}}
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5"><span class="pull-right"><b><?='Total amount'?></b></span></td>
                                        <td><b>{{number_format($totalsubtotal, 2)}}</b></td>
                                    </tr>

                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-sm-9 col-xs-12 pull-left">
                            <p>{{$purchase->description}}</p>
                        </div>
                        <div class="col-sm-3 col-xs-12 pull-right">
                            <div class="well well-sm">

                                <p>
                                    {{__('Create by')}} : {{optional($purchase->creator)->name}}
                                    <br>
                                    {{__('Date')}}:{{\Carbon\Carbon::parse($purchase->created_at)->format('d M Y, h:i A') }}
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
    <script src="{{ asset('js/purchase/show.js') }}"></script>
@endsection
