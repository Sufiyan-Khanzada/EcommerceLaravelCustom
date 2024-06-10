@extends('myaccount.layout')

@section('myaccount-content')
<div class="container">
    @if(count($data['orderItems']) > 0)
    <div class="col-md-12">
        <style type="text/css">
            .abc > th {
                width: 230px;
                height: 35px;
                background-color:#e2e3e6;
                font-weight: bold;
                text-align: center;
            }
            .abc {
                /*border-bottom: 1px solid black;*/
            }
            .abcd {
                border-bottom: 1px dotted black;
            }
            .abcd > td {
                width: 230px;
                height: 50px;
                background-color:#f6f7fa;
                text-align: center;
            }
            .mytable2 tr > td {
                width: 230px;
                height: 35px;
                background-color:#f6f7fa;
                text-align: center;
            }
            .mytable2 {
                float: right;
            }
        </style>

        <table class="mytable">
            <tr class="abc">
                <th>Product</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Handling Fee</th>
                <th>Tax</th>
            </tr>
            @foreach ($data['orderItems'] as $item)
            <tr class="abcd">
                <td><a href="{{ url('page/single-product/'.$item->product_id) }}">{{ $item->title }}</a></td>
                <td>{{ $item->product_quantity }}</td>
                <td>${{ $item->product_price }}</td>
                <td>${{ $item->handling_fee }}</td>
                <td>${{ $item->tax }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="col-md-12">
        <table class="mytable2">
            <tr>
                <td>Sub Total</td>
                <td>${{ $data['orderItems'][0]->order_subtotal }}</td>
            </tr>
            <tr>
                <td>Shipping Cost</td>
                <td>${{ $data['orderItems'][0]->shipping_cost }}</td>
            </tr>
            <tr>
                <td>Total Tax</td>
                <td>${{ $data['orderItems'][0]->total_tax }}</td>
            </tr>
            <tr>
                <td>Total Handling Fee</td>
                <td>${{ $data['orderItems'][0]->total_handling_fee }}</td>
            </tr>
            <tr>
                <td>Grand-Total</td>
                <td>${{ number_format($data['orderItems'][0]->total_handling_fee + $data['orderItems'][0]->total_tax + $data['orderItems'][0]->order_subtotal + $data['orderItems'][0]->shipping_cost, 2, ".", ",") }}</td>
            </tr>
        </table>
    </div>
    @else
        <p>You have not placed any orders yet</p>
    @endif
</div>
@endsection
