<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap4.3/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pos-print.css') }}">
</head>
<body>
<div id="wrapper">
    <div id="receiptData" class="pos-print-css">
        <div class="no-print"></div>
        <div id="receipt-data">
            <div>
                <div class="row invoice-info">
                    <div class="col-sm-7 invoice-col pos-print-fontsize">
                        @if(isset($sale->shop))
                        <img src="{{$sale->shop->images}}" class="pos-print-img" alt="SimplePOS">
                        @else
                            <img src="{{settingLogo()}}" class="pos-print-img" alt="SimplePOS">
                        @endif
                        <address>
                            <strong>{{optional($sale->shop)->name}}</strong><br>
                            {{__('levels.phone')}} : {{optional($sale->shop->user)->phone}}<br>
                            {{__('levels.email')}} : {{optional($sale->shop->user)->email}}<br>
                            {{optional($sale->shop)->address}}<br>
                            {{__('sale.sales_person')}}{{optional($sale->creator)->name}}
                        </address>
                    </div>

                    <div class="col-sm-5 invoice-col ">
                        <address>
                            <b class="pull-right "><img class="mr-1 img-1 pos-print-img"  src="{{ $sale->barcodeprint }}" alt="POS-{{$sale->id}}"></b>
                            <b class="pull-right">{{__('sale.sale_no')}} : {{$sale->sale_no}}</b><br>
                            <b class="pull-right">{{__('sale.date')}} : {{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y')}}</b><br>
                            <b class="pull-right">{{__('sale.customer')}} : {{$sale->user->name}}</b><br>
                            <b class="pull-right">{{__('levels.phone')}} : {{$sale->user->phone}}</b><br>
                            <b class="pull-right">{{__('sale.paid_by')}} : {{__('sale.cash')}}/{{__('sale.credit') }}</b><br>
                        </address>
                    </div>
                </div>
                <div class="clear-both-css"></div>
                <table class="table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th class="text-center pos-print-th50" >{{__('sale.description')}}</th>
                        <th class="text-center pos-print-th10" >{{__('sale.unit')}}</th>
                        <th class="text-center pos-print-th10" >{{__('sale.quantity')}}</th>
                        <th class="text-center pos-print-th24" >{{__('sale.price')}}</th>
                        <th class="text-center pos-print-th20" >{{__('sale.tax')}}</th>
                        <th class="text-center pos-print-th26" >{{__('sale.subtotal')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!blank($sale->items))
                        <?php $subtotal = 0; $totalsubtotal = 0; $i=1 ?>
                        <?php $subtotal = 0; $totalsubtotal = 0; $i=1; foreach ($sale->items as $item) { $subtotal = ($item->unit_price+ $item->tax_amount) * $item->quantity; $totalsubtotal += $subtotal; ?>
                    <tr>
                        <td>
                            @if(optional($item->product)->type ==10)
                                {{optional($item->product)->barcode.'-'.$item->product_item->id}}-{{optional($item->product)->name }} ({{$item->product_item->name}})
                            @else
                                {{optional($item->product)->barcode}}-{{optional($item->product)->name}}
                            @endif
                        </td>
                        <td class="text-center"> {{optional($item->product->unit)->name}}</td>
                        <td class="text-center"> {{number_format($item->quantity,2)}}</td>
                        <td class="text-right"> {{currencyFormat($item->unit_price)}}</td>
                        <td class="text-right"> {{currencyFormat($item->tax_amount)}}</td>
                        <td class="text-right">{{currencyFormat($subtotal)}}</td>
                    </tr>
                    <?php $i++; } ?>
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="text-left" colspan="3">{{__('sale.total_order_tax')}}</th>
                        <th colspan="3" class="text-right">{{currencyFormat($sale->tax_amount)}}</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="3">{{__('sale.total_amount')}}</th>
                        <th colspan="3" class="text-right">{{currencyFormat($totalsubtotal+$sale->tax_amount)}}</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="3">{{__('sale.credit_amount')}}</th>
                        <th colspan="3" class="text-right">{{currencyFormat($sale->paid_credit_amount)}}</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="3">{{__('sale.cash_amount')}}</th>
                        <th colspan="3" class="text-right">{{currencyFormat($sale->paid_cash_amount)}}</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="3">{{__('sale.paid_amount')}}</th>
                        <th colspan="3" class="text-right">{{currencyFormat($sale->paid_amount)}}</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="3">{{__('sale.change_amount')}}</th>
                        <th colspan="3" class="text-right">{{currencyFormat($sale->paid_amount - ($totalsubtotal+$sale->tax_amount))}}</th>
                    </tr>

                    </tfoot>
                </table>
                <table class="table table-striped table-condensed pos-margin-top">
                    <tbody><tr><td class="text-right">{{__('sale.paid_by')}} :</td><td>{{__('sale.cash')}}/{{ __('sale.credit') }}</td><td class="text-right">{{__('sale.amount')}} :</td><td>{{currencyFormat($totalsubtotal+$sale->tax_amount)}}</td></tr></tbody></table>
                <div class="well well-sm pos-margin-top">
                    <div class="text-center">{{setting('site_name')}}</div>
                </div>
            </div>
            <div class="clear-both-css"></div>
        </div>

        <!-- start -->
        <div id="buttons" class="no-print pos-print-no-css">
            <hr class="mb-2">
            <span class=" col-xs-12">
                <button onclick="window.print();" class="btn  btn-primary">{{__('levels.print')}}</button>
            </span>
            <span class="pull-left col-xs-12">
                <a class="btn  btn-success" target="_blank" href="https://api.whatsapp.com/send?phone={{$sale->user->phone}}?text={{$sale->generateSaleMsg}}" id="whatsapp">{{__('sale.whatsApp')}}</a>
            </span>
            <span class="col-xs-12">
                <a class="btn  btn-warning" href="{{route('admin.pos')}}">{{__('sale.back_to_pos')}}</a>
             </span>
            <div class="clear-both-css"></div>
        </div>
        <!-- end -->
    </div>
</div>
<!-- start -->
<script src="{{ asset('assets/modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#print').on("click", function() {
            e.preventDefault();
            var link = $(this).attr('href');
            $.get(link);
            return false;
        });
    });
</script>

</body>
</html>
