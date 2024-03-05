<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{

    const PERMISSIONS = [
        'create' => 'Agregar clientes',
        'show'   => 'Visualizar clientes',
        'edit'   => 'Editar clientes',
        'delete' => 'Eliminar clientes',
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
        $clients = Client::all()->sortBy("name");
        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'email' => 'email|unique:clients',
        ]);
        DB::beginTransaction();
        try {
            if ($client = Client::create($request)) {
                $with = 'success';
                $msg = 'El cliente ha sido creado.';
            } else {
                $with = 'error';
                $msg = 'Error al crear el cliente.';
            }
            DB::commit();
            return redirect()->route('user.index')->with($with, $msg);
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
        $client = Client::find($id);
        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $input = $request->all();
            $row = Client::find($client->id);
            $row->update($input);
            DB::commit();
            return redirect()->route('client.index')->with('success', 'El cliente se actualizó correctamente.');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return redirect()
                ->route('client.edit')
                ->withInput($request->all())->with('error', 'Error al actualizar el cliente');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            Client::where('id', $id)->delete();
            DB::commit();
            return back()->with('success', 'El cliente se borró correctamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Error al borrar el cliente');
        }
    }
}
