<?php

namespace App\Controllers;

use App\Models\AmigoModel;

class Amigos extends \CodeIgniter\Controller
{
    public function registrar()
{
    log_message('debug', 'El método registrar ha sido llamado');
    if ($this->request->getMethod() === 'post') {
        log_message('debug', 'El formulario ha sido enviado');
        // Obtenemos los datos del formulario
        $data = $this->request->getPost([
            'nombre', 'apellidos', 'telefono', 'correo', 'direccion', 'pais', 'contrasena'
        ]);

        $data['rol'] = 'Amigo'; // establece por defecto el rol 'Amigo' al usuairo.

        $model = new AmigoModel();
        if ($model->insertarAmigo(
            $data['nombre'], $data['apellidos'], $data['telefono'], $data['correo'], $data['direccion'], $data['pais'], $data['contrasena'], $data['rol']
        )) {
            log_message('debug', 'El amigo ha sido insertado correctamente');
            return redirect()->to('/success'); // Redirigimos al éxito
        }
        log_message('debug', 'Error al registrar el amigo');
        return redirect()->to('/error')->with('error', 'Error al registrar el amigo.'); // Si hay error, redirigimos a la página de error
    }
    log_message('debug', 'No se recibió el método POST');
    return view('amigos/register'); // Si no es POST, mostramos el formulario
}

    public function success()
    {
        echo "Registro exitoso";
    }

    public function login()
    {
        return view('amigos/login');
    }
    
    public function dashboard()
    {
        // Verifica si el usuario está logueado y tiene el rol correcto
        if (!session()->has('usuario_id') || session()->get('rol') !== 'Amigo') {
            return redirect()->to('/login');
        }

        // Aquí puedes cargar la vista de dashboard de "Amigo"
        return view('amigos/dashboard');
    }
}

