@extends('layouts.header')
@section('title','Dashboard')
@section('content')
<div class="card">
    <div class="card-header">
        <i class="fa fa-list"></i> All Orders
    </div>
    <table class="table table-bordered table-hover table-stripped">
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>What's app</th>
            <th>Advance</th>
            <th>Remaining</th>
            <th>Department</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        @if($orders->count() > 0)
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->customer->whatsapp }}</td>
                    <td>{{ $order->advance }} PKR</td>
                    <td>{{ $order->pending }} PKR</td>
                    <td>{{ $order->department->name }}</td>
                    <td align="center">
                        @if($order->status == 1)
                        <span class="badge badge-success float-right">Active</span>
                        @elseif($order->status == 0)
                        <span class="badge badge-info float-right">Draft</span>
                        @elseif($order->status == 2)
                        <span class="badge badge-warning float-right">Proccess</span>
                        @elseif($order->status == 4)
                        <span class="badge badge-secondary float-right">Completed</span>
                        @elseif($order->status == 3)
                        <span class="badge badge-danger float-right">Cancelled</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger" id="delorder" value="{{ $order->id  }}"><i class="fa fa-trash"></i></button>
                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg{{ $order->id }}"><i class="fa fa-check"></i></button>
                        <div class="modal fade" id="modal-lg{{ $order->id }}">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title">
                                            #{{ $order->id }}
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div>
                                        <form action="{{ route('update.order', $order->id) }}" method="get">
                                            @csrf
                                        <table class="table table-bordered table-striped table-hover">
                                            <tr>
                                                <th>
                                                    Customer
                                                </th>
                                                <th>
                                                    What's App
                                                </th>
                                                <th>
                                                    Department
                                                </th>
                                                <th>
                                                    Order Type
                                                </th>
                                                <th>
                                                    Delivery Type
                                                </th>
                                                <th>
                                                    Delivery Date
                                                </th>
                                                <th>Status</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $order->customer->name }}</td>
                                                <td>{{ $order->customer->whatsapp }}</td>
                                                <td>{{ $order->department->name }}</td>
                                                <td>{{ $order->delivery_type }}</td>
                                                <td>{{ $order->order_type }}</td>
                                                <td>{{ $order->edd }}</td>
                                                <td>
                                                @if($order->status == 1)
                                                <span class="badge badge-success float-right">Active</span>
                                                @elseif($order->status == 0)
                                                <span class="badge badge-info float-right">Draft</span>
                                                @elseif($order->status == 2)
                                                <span class="badge badge-warning float-right">Proccess</span>
                                                @elseif($order->status == 4)
                                                <span class="badge badge-secondary float-right">Completed</span>
                                                @elseif($order->status == 3)
                                                <span class="badge badge-danger float-right">Cancelled</span>
                                                @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="7" class="bg-danger">Order Details</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3">Title</th>
                                                <th>Qty</th>
                                                <th>Rate Per Unit</th>
                                                <th>Discount</th>
                                                <th>Total</th>
                                            </tr>
                                            @foreach($order->orderdetails as $item)
                                            <tr>
                                                <td colspan="3">{{ $item->name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->discount }}%</td>
                                                <td>{{ $item->total }}</td>
                                            </tr>
                                            @endforeach
                                            <tr class="bg-warning">
                                                <th>Total</th>
                                                <th>Advance</th>
                                                <th colspan="2">Remaining</th>
                                                <th colspan="2">Status</th>
                                                <th>Action</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $order->total }} PKR</td>
                                                <td>{{ $order->advance }} PKR</td>
                                                <td colspan="2">{{ $order->pending }} PKR</td>
                                                <td colspan="2">
                                                    <select name="status" class="form-control" id="">                                                    
                                                        <option value="0" @if($order->status == 0) selected @endif>Draft</option>
                                                        <option value="1" @if($order->status == 1) selected @endif>Active</option>
                                                        <option value="2" @if($order->status == 2) selected @endif>Proccess</option>
                                                        <option value="3" @if($order->status == 3) selected @endif>Cancelled</option>
                                                        <option value="4" @if($order->status == 4) selected @endif>Completed</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-sm btn-danger">Update</button>
                                                </td>
                                            </tr>
                                        </table>
                                        </form>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                                </div>
                        <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </td>
                </tr>
            @endforeach
        @else 
                <tr>
                    <td colspan="8" align='center'> <i class="fa fa-cart-arrow-down"></i> No Order Yet </td>
                </tr>
        @endif
    </table>
</div>
<script>
    $(document).ready(function(){
        $("#delorder").click(function(){
                var i = $(this).val();
                if(confirm("Are you sure? You want to delete order.") == true){
                    location.replace("http://localhost:8000/orders/delete/"+i);
                }
        });
    });
</script>
@endsection