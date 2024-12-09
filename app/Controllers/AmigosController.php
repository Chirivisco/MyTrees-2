<?php

namespace App\Controllers;

class AmigosController extends BaseController
{
    public function dashboard()
    {
        // Comprobamos si el usuario tiene el rol de 'Amigo'
        if (session()->get('rol') !== 'Amigo') {
            // Si no es amigo, redirigimos a la página de login
            return redirect()->to('/login');
        }

        // Si es amigo, mostramos el dashboard
        return view('amigos/dashboard');
    }
}