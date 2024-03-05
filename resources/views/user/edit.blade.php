@extends('adminlte::page')
@section('title', 'Usuarios')
@section('content_header')
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-fw fa-users"></i> Administracion de usuarios</h1>
@stop
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('content')
    <div class="row">
        <div class="col-12">
            {!! Form::model($user, ['route' => ['user.update', $user], 'method' => 'put']) !!}
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Agregar Usuario</h3>
                    <div class="card-tools">
                        <a href="{{ route('user.index') }}" class="btn btn-sm btn-danger">Regresar</a>
                    </div>
                </div>
                <div class="card-body">
                    <x-adminlte-input name="name" label="Nombre" placeholder="Nombre del usuario"
                        label-class="text-black" fgroup-class="col-md-6" value="{{ $user->name }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-user text-black"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="username" label="Usuario" placeholder="Usuario de acceso"
                        label-class="text-black" fgroup-class="col-md-6" value="{{ $user->username }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-user text-black"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="email" label="Correo electronico" placeholder="Email del usuario"
                        label-class="text-black" fgroup-class="col-md-6" value="{{ $user->email }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-envelope text-black"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    {{-- With prepend slot --}}
                    <x-adminlte-input type="password" name="password" label="Contraseña" placeholder="Contraseña de acceso"
                        label-class="text-black" fgroup-class="col-md-6" value="{{ $user->password }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-key text-black"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <h5 class="border-bottom">Roles</h5>
                    @foreach ($roles as $role)
                        <div class="col-md-3">
                            <div class="checkbox">
                                <label class="{{ str_contains($role->name, 'delete') ? 'text-danger' : '' }}">
                                    {!! Form::checkbox('roles[]', $role->id, $user->hasAnyRole($role->id) ?: false, [
                                        'class' => 'mr-1',
                                    ]) !!}
                                    {{ $role->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    {!! Form::submit('Actualizar', ['class' => 'btn btn-sm btn-primary float-end float-right']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
