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
            <form action="{{ route('user.store') }} " method="POST">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Agregar Usuario</h3>
                        <div class="card-tools">
                            <a href="{{ route('user.index') }}" class="btn btn-sm btn-danger">Regresar</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <x-adminlte-input name="name" label="Nombre" placeholder="Nombre del usuario"
                            label-class="text-black" fgroup-class="col-md-6" value="{{ old('name') }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user text-black"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="username" label="Usuario" placeholder="Usuario de acceso"
                            label-class="text-black" fgroup-class="col-md-6" value="{{ old('username') }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user text-black"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="email" label="Correo electronico" placeholder="Email del usuario"
                            label-class="text-black" fgroup-class="col-md-6" value="{{ old('email') }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope text-black"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        {{-- With prepend slot --}}
                        <x-adminlte-input type="password" name="password" label="Contraseña"
                            placeholder="Contraseña de acceso" label-class="text-black" fgroup-class="col-md-6"
                            value="{{ old('password') }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-key text-black"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @php
                            $config = [
                                'placeholder' => 'Seleccionar rol...',
                                'allowClear' => false,
                            ];
                        @endphp
                        <x-adminlte-select2 id="roles" name="roles[]" label="Rol" label-class="text-black"
                            :config="$config" multiple fgroup-class="col-md-6">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-lock text-black"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-select2>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="submit" class="btn btn-sm btn-primary float-right">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
