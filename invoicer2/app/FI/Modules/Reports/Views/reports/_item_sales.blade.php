@extends('reports.layouts.master')

@section('content')

<h1 style="text-align: center;">{{ trans('fi.item_sales') }}</h1>

@foreach ($results as $key=>$items)
<h4>{{{ $key }}}</h4>
<table class="alternate">

    <thead>
    <tr>
        <th style="width: 50%;">{{ trans('fi.client') }}</th>
        <th style="width: 10%;">{{ trans('fi.invoice') }}</th>
        <th style="width: 10%;">{{ trans('fi.date') }}</th>
        <th class="amount" style="width: 10%;">{{ trans('fi.price') }}</th>
        <th class="amount" style="width: 10%;">{{ trans('fi.quantity') }}</th>
        <th class="amount" style="width: 10%;">{{ trans('fi.total') }}</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($items['items'] as $item)
    <tr>
        <td>{{{ $item['client_name'] }}}</td>
        <td>{{{ $item['invoice_number'] }}}</td>
        <td>{{ $item['date'] }}</td>
        <td class="amount">{{ $item['price'] }}</td>
        <td class="amount">{{ $item['quantity'] }}</td>
        <td class="amount">{{ $item['total'] }}</td>
    </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td class="amount"><strong>{{ trans('fi.total') }}</strong></td>
        <td class="amount"><strong>{{ $items['totals']['quantity'] }}</strong></td>
        <td class="amount"><strong>{{ $items['totals']['total'] }}</strong></td>
    </tr>
    </tbody>

</table>
@endforeach

@stop