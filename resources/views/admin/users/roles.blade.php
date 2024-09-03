@extends('layouts.header')
@section('title','Roles')
@section('content')
<div class="card">
    <div class="card-header">
        <i class="fa fa-list"></i> Roles
    </div>
    <table class="table table-bordered table-striped table-hover">
        <tr>
            <th>Title</th>
            <th>Action</th>
        </tr>
        <form action="{{ route('role.save') }}" method="post">
            @csrf
            <tr>
                <td>
                    <input type="text" class="form-control" name="title">
                    @error('title')
                    <small><font color="red">{{ $message }}</font></small>
                    @enderror
                </td>
                <td>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-save"></i> Save</button>
                </td>
            </tr>
        </form>
        @foreach($roles as $role)
        <tr>
            <td>{{ $role->title }}</td>
            <td>
                <a href="{{ route('permission.grant',$role->id) }}">
                <button class="btn btn-info btn-sm"><i class="fa fa-key"></i></button>
                </a>
                <a href="{{ route('role.delete',$role->id) }}">
                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection