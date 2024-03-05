{{-- Custom --}}
<div class="modal fade" id="addRole">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('role.store') }} " method="POST">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar nuevo rol</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-6">
                        <x-adminlte-input igroup-size="sm" name="name" id="name" label="Nombre"
                            value="{{ old('name') }}" />
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <x-adminlte-button theme="danger" class="mr-auto" label="Cancelar" data-dismiss="modal" />
                    <x-adminlte-button type="submit" theme="success" label="Actualizar" />
                </div>
            </div>
        </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal -->
