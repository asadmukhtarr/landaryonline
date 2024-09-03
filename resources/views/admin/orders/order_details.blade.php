@extends('layouts.header')
@section('title','Order Details')
@section('content')
    <div class="card mt-1">
        <div class="card-header">
            <i class="fa fa-list"></i> Item List In Order #{{ $order->id }}
            <span class="badge badge-warning float-right">{{ $order->total }} PKR<span>
        </div>
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>Title</th>
                <th>Qty</th>
                <th>Rate Per Unit</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <form action="{{ route('orderdetails.save',$order->id) }}" method="post">
                @csrf
                <tr>
                    <td>
                        <input type="text" class="form-control" name="title">
                        @error('title')
                        <font color="red"><small>{{ $message }}</small></font>
                        @enderror
                    </td>
                    <td>
                        <input type="number" id="qty"  class="form-control" name="qty">
                        @error('qty')
                        <font color="red"><small>{{ $message }}</small></font>
                        @enderror
                    </td>
                    <td>
                        <input type="text" id="ppp" class="form-control" name="ppp">
                        @error('ppp')
                        <font color="red"><small>{{ $message }}</small></font>
                        @enderror
                    </td>
                    <td>
                        <input type="text" id="discount" value="0" class="form-control" name="discount">
                        @error('discount')
                        <font color="red"><small>{{ $message }}</small></font>
                        @enderror
                    </td>
                    <td>
                        <span id="total">0</span>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-plus-circle"></i></button>
                    </td>
                </tr>
            </form>
            @foreach($order->orderdetails as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->discount }}%</td>
                <td>{{ $item->total }}</td>
                <td>
                    <a href="{{ route('item.delete',$item->id) }}">
                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="asbc"></div>
    </div>
    <form action="{{ route('place.order',$order->id) }}" method="post">
        @csrf
        <div class="card mt-3">
            <div class="card-header">
                <i class="fa fa-bus"></i> Place Order
            </div>
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>Total</th>
                    <th>Items</th>
                    <th>Advance</th>
                    <th>Remaing Balance</th>
                </tr>
                <tr>
                    <td id="totalcheck">
                        {{ $order->total }}
                    </td>
                    <td>
                        {{ $order->orderdetails->count() }}
                    </td>
                    <td>
                        <input type="number" class="form-control" value="0" id="advance" name="advance">
                        @error('advance')
                        <font color="red"><small>{{ $message }}</small></font>
                        @enderror
                    </td>
                    <td id="remaining">
                        0
                    </td>
                </tr>
            </table>
            <div class="card-footer">
                <button class="btn btn-danger float-right"> <i class="fa fa-save"></i> Place Order</button>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function(){
            $("#ppp").change(function(){
                var ppp = $(this).val();
                var qty = $("#qty").val();
                if(qty > 0){
                    var total = ppp * qty;
                    $("#total").text(total);
                } else {
                    alert("Please Add Quantity First");
                }
            });

            $("#discount").change(function(){
                var discount = $(this).val();
                var ppp = $("#ppp").val();
                var qty = $("#qty").val();
                var total = $("#total").text();
                if(ppp > 0 && qty > 0){
                    var amount = total / 100;
                    amount = amount * discount;
                    var tot = total - amount;
                    $("#total").text(tot);

                }
            });
            // remianig calculation ..
            var total = $("#totalcheck").text(); // total ..
            var advance = $("#advance").val(); // advance ..
            var remaing = total - advance;
            $("#remaining").text(remaing);
            $("#advance").keyup(function(){
                var adv = $(this).val();
                var total = $("#totalcheck").text(); // total ..
                var rem = total - adv;
                $("#remaining").text(rem);
            });

        });
    </script>
@endsection