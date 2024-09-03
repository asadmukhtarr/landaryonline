@extends('layouts.header')
@section('title','Permissions')
@section('content')
<form action="{{ route('permission.granted',$role->id) }}" method="post">
    @csrf
    <div class="card">
        <div class="card-header">
            <i class="fa fa-list"></i> Permissions <span class="badge badge-success float-right"> {{ $role->title }} </span>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($permissions as $permission)
                    <li class="list-group-item"> 
                        @php 
                        $grant_permission = App\Models\grantpermission::where('role_id',$role->id)->where('permission_id',$permission->id)->first();
                        @endphp
                        @if(!$grant_permission)
                        <input type="checkbox" name="permission_granted[]" value="{{ $permission->id }}" /> 
                        @else 
                        <input type="checkbox" name="permission_granted[]" value="{{ $permission->id }}" checked/> 
                        @endif
                        {{ $permission->title }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger btn-sm float-right"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
</form>
@endsection