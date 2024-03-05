@extends('adminlte::page')
@section('title', 'Roles')
@section('content_header')
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-fw fa-lock"></i> Editar rol</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                {!! Form::model($role, ['method' => 'PUT', 'route' => ['role.update', $role->id], 'class' => 'm-b']) !!}
                <div class="card-header">
                    <h3 class="card-title">{{ 'Permisos ' . $role->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('role.index') }}" class="btn btn-sm btn-dark">Regresar</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($permissions as $perm)
                            <?php
                            $per_found = null;
                            if (isset($role)) {
                                $per_found = $role->hasPermissionTo($perm->name);
                            }
                            
                            if (isset($user)) {
                                $per_found = $user->hasDirectPermission($perm->name);
                            }
                            ?>
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <label class="{{ str_contains($perm->name, 'delete') ? 'text-danger' : '' }}">
                                        {!! Form::checkbox('permissions[]', $perm->name, $per_found, isset($options) ? $options : []) !!} {{ $perm->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    {!! Form::submit('Asignar permisos', ['class' => 'btn btn-sm btn-primary float-end float-right']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
