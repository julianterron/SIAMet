<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    const PERMISSIONS = [
        'create' => 'Agregar usuarios',
        'show'   => 'Visualizar usuarios',
        'edit'   => 'Editar usuarios',
        'delete' => 'Eliminar usuarios',
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:' . self::PERMISSIONS['create'])->only(['create', 'store']);
        $this->middleware('permission:' . self::PERMISSIONS['show'])->only(['index', 'show']);
        $this->middleware('permission:' . self::PERMISSIONS['edit'])->only(['edit', 'update']);
        $this->middleware('permission:' . self::PERMISSIONS['delete'])->only(['destroy']);

        $roles = Role::orderBy('id', 'ASC')->get();
        view()->share('roles', $roles);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);
        DB::beginTransaction();
        try {
            if ($user = User::create($request->except('roles', 'permissions'))) {
                $this->syncPermissions($request, $user);
                $msg = 'User has been created.';
            } else {
                $msg = 'Unable to create user.';
            }
            DB::commit();
            return redirect()->route('user.index')->with('success', 'El usuario se guardó correctamente.');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return redirect()
                ->route('user.create')
                ->withInput($request->all())->with('error', 'Error al guardar el usuario');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);
        DB::beginTransaction();
        try {
            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }
            $row = User::find($user->id);
            $row->update($input);
            $row->roles()->sync($request->roles);
            DB::commit();
            return redirect()->route('user.index')->with('success', 'El usuario se actualizó correctamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->route('user.create')
                ->withInput($request->all())->with('error', 'Error al actualizar el usuario');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            User::where('id', $id)->delete();
            DB::commit();
            return back()->with('success', 'El usuario se borró correctamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Error al borrar el usuario');
        }
    }

    private function syncPermissions(Request $request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if (!$user->hasAllRoles($roles)) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);
        return $user;
    }
}
