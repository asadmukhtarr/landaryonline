@extends('layouts.header')
@section('title','Permissions')
@section('content')
<div class="card">
    <div class="card-header">
        <i class="fa fa-list"></i> Permissions
    </div>
    <table class="table table-bordered table-stripped table-hover">
        <tr>
            <th>Title</th>
            <th>Slug</th>
            <th>Route</th>
            <th>Action</th>
        </tr>
        <form action="{{ route('permission.save')  }}" method="post">
            @csrf
            <tr>
                <td>
                    <input type="text" class="form-control" name="title">
                    @error('title')
                    <small><font color="red">{{ $message }}</font></small>
                    @enderror
                </td>
                <td>
                    <input type="text" class="form-control" name="slug">
                    @error('slug')
                    <small><font color="red">{{ $message }}</font></small>
                    @enderror
                </td>
                <td>
                    <input type="text" class="form-control" name="routename">
                    @error('routename')
                    <small><font color="red">{{ $message }}</font></small>
                    @enderror
                </td>
                <td>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-save"></i></button>
                </td>
            </tr>
        </form>
        @foreach($permissions as $permission)
        <tr>
            <td>{{ $permission->title }}</td>
            <td>{{ $permission->slug }}</td>
            <td>{{ $permission->route_name }}</td>
            <td>
                <a href="{{ route('permission.delete',$permission->id) }}">
                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection