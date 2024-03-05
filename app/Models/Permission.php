<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use HasFactory;

    public static function defaultPermissions()
    {
        return [
            // Permisos de usuarios
            'Visualizar usuarios',
            'Agregar usuarios',
            'Editar usuarios',
            'Eliminar usuarios',
            // Permisos de roles
            'Visualizar roles',
            'Agregar roles',
            'Editar roles',
            'Eliminar roles',
            // Permisos de clientes
            'Visualizar clientes',
            'Agregar clientes',
            'Editar clientes',
            'Eliminar clientes',            
        ];
    }
}
