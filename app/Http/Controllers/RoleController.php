<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    const PERMISSIONS = [
        'create' => 'Agregar roles',
        'show'   => 'Visualizar roles',
        'edit'   => 'Editar roles',
        'delete' => 'Eliminar roles',
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:' . self::PERMISSIONS['create'])->only(['create', 'store']);
        $this->middleware('permission:' . self::PERMISSIONS['show'])->only(['index', 'show']);
        $this->middleware('permission:' . self::PERMISSIONS['edit'])->only(['edit', 'update']);
        $this->middleware('permission:' . self::PERMISSIONS['delete'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('role.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles'
        ]);
        if (Role::create([
            'name' => $request->name,
        ])) {
            $msg = 'Role Added';
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if ($role = Role::findOrFail($id)) {
                // admin role has everything
                if ($role->name === 'Admin') {
                    $role->syncPermissions(Permission::all());
                    return redirect()->route('role.index');
                }
                $permissions = $request->get('permissions', []);
                $role->syncPermissions($permissions);
                $msg = $role->name . ' ha sido actualizado correctamente.';
            } else {
                $msg = 'Error al actualizar el rol ' . $id . '.';
                return redirect()->back()->with('error', $msg);
            }
            DB::commit();
            return redirect()->route('role.index')->with('success', $msg);
        } catch (\Throwable $th) {
            $msg = 'Error al actualizar el rol ' . $id . '.';
            DB::rollBack();
            return redirect()
                ->route('user.create')
                ->withInput($request->all())->with('error', $msg);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            Role::where('id', $id)->delete();
            DB::commit();
            return back()->with('success', 'El rol se borró correctamente.');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return back()->with('error', 'Error al borrar el rol');
        }
    }
}
