<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\CorreoElectronico;
use Illuminate\Support\Facades\Mail;

class CorreosController extends Controller
{
    public function enviar(Request $request)
    {
        $request->validate([
            'nombre'=>'min:4|max:120|required',
            'correo'=> 'min:4|max:250|required',
            'comentario' => 'min:4|max:120:required',
        ]);
        $email = new \stdClass(); 
        $email->nombre = $request->nombre;
        $email->comentario = $request->comentario;
        $email->emisor = 'LaraCRUD';
        $email->receptor = $request->nombre;
        $email->correo = $request->correo;

        Mail::to("xxxxxxx@xxxxx.com")->send(new CorreoElectronico($email));
        flash('Correo electrónico de '. $email->nombre.'  enviado con éxito.')->success()->important();
        return view('mails.contacto');
    }

    public function index()
    {
        return view('mails.contacto');
    }
}
