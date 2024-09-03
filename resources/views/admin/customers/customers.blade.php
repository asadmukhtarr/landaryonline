@extends('layouts.header')
@section('title','All Customers')
@section('content')
<div class="card mt-2">
    <div class="card-header">
        <i class="fa fa-users"></i> Customers
    </div>
    <div class="card-body">
    <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>
                #
            </th>
            <th>
                Name
            </th>
            <th>
                Email
            </th>
            <th>
                What's App
            </th>
            <th>
                Address
            </th>
            <th>
                Actions
            </th>
        </tr>
        </thead>
        <form action="{{ route('save.customer') }}" method="post">
            @csrf
            <tr>
                <td colspan="2">
                    <input type="text" name="name" class="form-control">
                    @error('name')
                    <font color="red"><b><small>{{ $message }}</small></b></font>
                    @enderror
                </td>
                <td>
                    <input type="text" name="email" class="form-control">
                    @error('email')
                    <font color="red"><b><small>{{ $message }}</small></b></font>
                    @enderror
                </td>
                <td>
                    <input type="text" name="whatsapp" class="form-control">
                    @error('whatsapp')
                    <font color="red"><b><small>{{ $message }}</small></b></font>
                    @enderror
                </td>
                <td>
                    <input type="text" name="address" class="form-control">
                    @error('address')
                    <font color="red"><b><small>{{ $message }}</small></b></font>
                    @enderror
                </td>
                <td>
                <button class="btn btn-success"><i class="fa fa-save"></i></button>
                </td>
            </tr>
        </form>
    </table>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>
                #
            </th>
            <th>
                Name
            </th>
            <th>
                Email
            </th>
            <th>
                What's App
            </th>
            <th>
                Address
            </th>
            <th>
                Actions
            </th>
        </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>
                        {{ $customer->id }}
                    </td>
                    <td>
                        {{ $customer->name }}
                    </td>
                    <td>
                        {{ $customer->email }}
                    </td>
                    <td>
                        {{ $customer->whatsapp }}
                    </td>
                    <td>
                        {{ $customer->address }}
                    </td>
                    <td>
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-lg{{ $customer->id }}"><i class="fa fa-edit"></i></button>
                        <a href="{{ route('delete.customer',$customer->id) }}">
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </a>
                        <div class="modal fade" id="modal-lg{{ $customer->id }}">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title">{{ $customer->name }} Update</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-striped table-hover">
                                            <tr>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    What's App
                                                </th>
                                                <th>
                                                    Address
                                                </th>
                                                <th>
                                                    Actions
                                                </th>
                                            </tr>
                                            <form action="{{ route('update.customer',$customer->id) }}" method="post">
                                                @csrf
                                                <tr>
                                                    <td>
                                                        <input type="text" name="name" value="{{ $customer->name  }}" class="form-control">
                                                        @error('name')
                                                        <font color="red"><b><small>{{ $message }}</small></b></font>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="email" value="{{ $customer->email  }}" class="form-control">
                                                        @error('email')
                                                        <font color="red"><b><small>{{ $message }}</small></b></font>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="whatsapp" value="{{ $customer->whatsapp  }}" class="form-control">
                                                        @error('whatsapp')
                                                        <font color="red"><b><small>{{ $message }}</small></b></font>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="address" value="{{ $customer->address  }}" class="form-control">
                                                        @error('address')
                                                        <font color="red"><b><small>{{ $message }}</small></b></font>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                    <button class="btn btn-success"><i class="fa fa-save"></i></button>
                                                    </td>
                                                </tr>
                                            </form>
                                        </table>
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
        </tbody>
    </table>
    </div>
</div>
@endsection