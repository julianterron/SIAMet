@extends('adminlte::page')
@section('title', 'Roles')
@section('content_header')
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-fw fa-users"></i> Administracion de roles</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Roles</h3>
                    @can('Agregar roles')
                        <div class="card-tools">
                            <a href="#" class="btn btn-sm btn-success pull-right" data-toggle="modal"
                                data-target="#addRole"> <i class="glyphicon glyphicon-plus"></i> Nuevo</a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    {{-- Setup data for datatables --}}
                    @php
                        $heads = ['ID', 'Nombre', ['label' => 'Acciones', 'no-export' => true, 'width' => 15]];

                        $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>';
                        $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>';
                        $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button>';
                        $config = [
                            'language' => [
                                'url' => '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-MX.json',
                            ],
                        ];
                    @endphp
                    {{-- Minimal example / fill data using the component slot --}}
                    <x-adminlte-datatable class="table table-striped table-hover" id="table1" :heads="$heads"
                        :config="$config">
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    {{-- {!! $btnDetails !!} --}}
                                    @can('Editar roles')
                                        <a href="{{ route('role.edit', $role) }}"
                                            class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('Eliminar roles')
                                        <form style="display: inline" action="{{ route('role.destroy', $role) }}" method="post"
                                            class="formDelUser">
                                            @csrf
                                            @method('delete')
                                            {!! $btnDelete !!}
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
    @include('shared._addRole')
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('.formDelUser').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Estas seguro?",
                    text: "Se va a eliminar un registro!",
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Si, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            })
        })
    </script>
@stop
