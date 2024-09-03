@extends('layouts.header')
@section('title','Department')
@section('content')
<div class="card">
    <div class="card-header">
        <i class="fa fa-list"></i> Department
    </div>
    <table class="table table-bordered table-hover table-stripped">
        <tr>
            <th>Name</th>
            <th>Orders</th>
            <th>Action</th>
        </tr>
        <form action="{{ route('save.department') }}" method="post">
        @csrf
        <tr>
            <td colspan="2">
                <input type="text" class="form-control" name="name">
                @error('name')
                <font  color="red"><small>{{ $message }}</small></font>
                @enderror
            </td>
            <td>
                <button class="btn btn-danger btn-sm"><i class="fa fa-save"></i></button>
            </td>
        </tr>
        </form>
        @if($departments->count() > 0)
        @foreach($departments as $department)
                <tr>
                    <td>
                        {{ $department->name }}
                        @if($department->status == 0)
                        <span class="badge badge-success float-right">Active</span>
                        @else 
                        <span class="badge badge-danger float-right">Disable</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-danger">{{ $department->orders->count() }}</span>
                    </td>
                    <td>
                        @if($department->status == 0)
                        <a href="{{ route('status.department',$department->id) }}">
                        <button class="btn btn-danger btn-sm">Disable</button>
                        </a>
                        @else 
                        <a href="{{ route('status.department',$department->id) }}">
                            <button class="btn btn-success btn-sm">Enable</button>
                        </a>
                        @endif
                        <a href="{{ route('order.department',$department->id) }}">
                        <button class="btn btn-info btn-sm">Details</button>
                        </a>
                    </td>
                </tr>
        @endforeach
        @else 
                <tr>
                    <td colspan="2" align="center">
                        No Record Found
                    </td>
                </td>
        @endif
    </table> 
</div>
@endsection