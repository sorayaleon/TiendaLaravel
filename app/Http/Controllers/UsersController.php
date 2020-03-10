<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $users = User::search($request->name)->orderBy('id', 'ASC')->paginate(2);
        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'min:4|max:120|required',
            'email'=> 'min:4|max:250|required|unique:users',
            'password' => 'min:4|max:120:required',
            'imagen' => 'required'
        ]);
        try{
            $user = new User($request->all());
            $user->password = Hash::make($request->password);
            $user->imagen = $request->file('imagen')->store('storage');
            $user->save();
            flash('Usuario/a '. $user->name.'  creado con éxito.')->success()->important();
            return redirect()->route('users.index');
        }catch(\Exception $e){
            flash('Error al crear el Usuario/a '. $user->name.'.'.$e->getMessage())->error()->important();
            return redirect()->back(); 
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'min:4|max:120|required',
            'email'=> 'min:4|max:250|required',
        ]);
        try{
            $user = User::find($id);
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->tipo= $request->tipo;
            if($request->imagen){
                if(Storage::exists($user->imagen)){
                    Storage::delete($user->imagen);
                }
                $user->imagen = $request->file('imagen')->store('storage');
            }
            $user->save();
            flash('Usuario/a '. $user->name.'  modificado/a con éxito.')->warning()->important();
            return redirect()->route('users.index');
        }catch(\Exception $e){
            flash('Error al modificar el Usuario/a '. $user->name.'.'.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = User::find($id);
            if(Storage::exists($user->imagen)){
                Storage::delete($user->imagen);
            }
            $user->delete();
            flash('Usuario/a '. $user->name.'  eliminado/a con éxito.')->error()->important();
            return redirect()->route('users.index');
        }catch(\Exception $e){
            flash('Error al eliminar Usuario/a '. $user->name.'.'.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Crea una vista en PDF con los datos de los usuarios
     */
    public function pdfAll()
    {
        $users = User::all();
        $pdf = PDF::loadView('pdf.users', compact('users'));
        $fichero = 'usuarios-'.date("YmdHis").'.pdf';
        return $pdf->download($fichero);
    }
    /**
     * Crea una vista en PDF con los datos de un usuario
     */
    public function pdf($id)
    {
        $user = User::find($id);
        $pdf = PDF::loadView('pdf.user', compact('user'));
        $fichero = 'usuario-'.date("YmdHis").'.pdf';
        return $pdf->download($fichero);
    }
}
