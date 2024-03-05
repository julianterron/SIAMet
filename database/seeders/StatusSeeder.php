<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(['name' => 'Nuevo']);
        Status::create(['name' => 'Asignado']);
        Status::create(['name' => 'En almacen']);
        Status::create(['name' => 'En laboratorio']);
        Status::create(['name' => 'Impreso']);
        Status::create(['name' => 'Pendiente']);
        Status::create(['name' => 'Resuelto']);
        Status::create(['name' => 'Cerrado']);
        Status::create(['name' => 'Cancelado']);

    }
}
