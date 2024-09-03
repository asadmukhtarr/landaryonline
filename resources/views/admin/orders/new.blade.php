@extends('layouts.header')
@section('title','Dashboard')
@section('content')
  <form action="{{ route('save.order') }}" method="post">
    @csrf
    <div class="card mt-1">
        <div class="card-header">
            <i class="fa fa-plus-circle"></i> New Order
        </div>
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>Select Customer</th>
                <td>
                    <select class="form-control" name="customer">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer')
                    <font color="red"><small>{{ $message }}</small></font>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>Order Type</th>
                <td>
                    <select class="form-control" name="type">
                        <option value="">Select Order Type</option>
                        <option value="urgent">Urgent</option>
                        <option value="normal">Normal</option>
                    </select>
                    @error('type')
                    <font color="red"><small>{{ $message }}</small></font>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>Delivery Type</th>
                <td>
                    <select class="form-control" name="delivery_type">
                        <option value="">Select Delivery Type</option>
                        <option value="Delivery">Delivery</option>
                        <option value="Selft">Selft</option>
                    </select>
                    @error('type')
                    <font color="red"><small>{{ $message }}</small></font>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>Department</th>
                <td>
                    <select class="form-control" name="department">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department')
                    <font color="red"><small>{{ $message }}</small></font>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>Expected Delivery Date</th>
                <td>
                    <input type="date" name="ddate" class="form-control">
                    @error('ddate')
                    <font color="red"><small>{{ $message }}</small></font>
                    @enderror
                </td>
            </tr>
        </table>
        <div class="card-footer">
            <button class="btn btn-danger btn-sm float-right"> <i class="fa fa-arrow-right"></i>  Next Step </button>
        </div>
    </div>
</form>
@endsection