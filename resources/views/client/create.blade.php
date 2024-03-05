@extends('adminlte::page')
@section('title', 'Clientes')
@section('content_header')
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-fw fa-address-book"></i> Administracion de clientes</h1>
@stop
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('client.store') }} " method="POST">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Agregar Cliente</h3>
                        <div class="card-tools">
                            <a href="{{ route('client.index') }}" class="btn btn-sm btn-danger">Regresar</a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Campo nombre --}}
                        <x-adminlte-input name="name" label="Nombre" placeholder="Nombre del cliente"
                            label-class="text-black" fgroup-class="col-md-6" value="{{ old('name') }}">
                        </x-adminlte-input>
                        {{-- Campo direccion --}}
                        <x-adminlte-textarea name="address" label="Dirección" fgroup-class="col-md-6" row="3"
                            placeholder="Agregar dirección..." />
                        {{-- Campo telefono --}}
                        <x-adminlte-input name="phone" label="Telefono" placeholder="Telefono" label-class="text-black"
                            fgroup-class="col-md-6" value="{{ old('phone') }}">
                        </x-adminlte-input>
                        {{-- Campo contacto --}}
                        <x-adminlte-input name="contact" label="Contacto" placeholder="Contacto" label-class="text-black"
                            fgroup-class="col-md-6" value="{{ old('contact') }}">
                        </x-adminlte-input>
                        {{-- Campo contacto informe --}}
                        <x-adminlte-input name="contact_inform" label="Contacto Informe" placeholder="Contacto Informe"
                            label-class="text-black" fgroup-class="col-md-6" value="{{ old('contact_inform') }}">
                        </x-adminlte-input>
                        {{-- Campo email --}}
                        <x-adminlte-input type="email" name="email" label="Correo electronico"
                            placeholder="Correo electronico" label-class="text-black" fgroup-class="col-md-6"
                            value="{{ old('email') }}">
                        </x-adminlte-input>
                        {{-- Campo credito --}}
                        <x-adminlte-input name="credit" label="Credito" placeholder="Credito"
                            label-class="text-black" fgroup-class="col-md-6" value="{{ old('credit') }}">
                        </x-adminlte-input>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="submit" class="btn btn-sm btn-primary float-right">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
