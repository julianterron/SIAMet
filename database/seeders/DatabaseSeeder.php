<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Solicitar la actualizacion de la migracion de la base de datos, por default es no
        if ($this->command->confirm('¿Desea actualizar la migración antes de la inserción; se borrarán todos los datos antiguos?')) {
            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");
        }

        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        $this->command->info('Permisos por default agregados.');

        if ($this->command->confirm('¿Crear roles para el usuario, el valor predeterminado es administrador y usuario? [s|N]', true)) {
            $input_roles = $this->command->ask('Introduzca los roles en formato separado por comas.', 'Admin,User');
            $roles_array = explode(',', $input_roles);
            // agregar roles
            foreach ($roles_array as $role) {
                $role = Role::firstOrCreate(['name' => trim($role)]);

                if ($role->name == 'Admin') {
                    // asignar todos los permisos
                    $role->syncPermissions(Permission::all());
                    $this->command->info('Admin granted all the permissions');
                } else {
                    // para otros por defecto solo acceso de lectura
                    $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
                }

                // Crear un usuario para cada rol
                $this->createUser($role);
            }
            $this->command->info('Roles ' . $input_roles . ' agregados correctamente.');
        } else {
            Role::firstOrCreate(['name' => 'User']);
            $this->command->info('Se agregó solo el rol de usuario predeterminado.');
        }
    }
    /**
     * Crear una usuario con un rol dado
     *
     * @param $role
     */
    private function createUser($role)
    {
        //$user = \App\Models\User::factory()->create();
        $user = \App\Models\User::factory()->create([
             'name' => 'Administrador',
             'username' => 'admin',
             'password' => 'admin1234',
             'email' => 'test@example.com',
         ]);
        $user->assignRole($role->name);
        if ($role->name == 'Admin') {
            $this->command->info('Aquí están sus datos de administrador para iniciar sesión:');
            $this->command->warn($user->username);
            $this->command->warn($user->email);
            $this->command->warn('Contraseña es "secret"');
        }
    }
}
