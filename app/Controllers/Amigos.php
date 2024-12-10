<?php

namespace App\Controllers;

use App\Models\AmigoModel;

class Amigos extends \CodeIgniter\Controller
{
    public function registrar()
    {
        log_message('debug', 'El método registrar (el original) ha sido llamado');

        // Log del tipo de solicitud
        log_message('debug', 'Tipo de solicitud recibida: ' . $this->request->getMethod());

        return view('amigos/register'); // Si no es POST, muestra el form
    }

    public function crearAmigo() {
        log_message('debug', 'El método CREAR AMIGO ha sido llamado');

        // Log del tipo de solicitud
        log_message('debug', 'Tipo de solicitud recibida: ' . $this->request->getMethod());

        if ($this->request->getMethod() === 'POST') {
            log_message('debug', 'El formulario ha sido enviado');
            // obtiene los datos del form
            $data = $this->request->getPost([
                'nombre',
                'apellidos',
                'telefono',
                'correo',
                'direccion',
                'pais',
                'contrasena'
            ]);

            $data['rol'] = 'Amigo'; // establece por defecto el rol 'Amigo' al usuairo.

            $model = new AmigoModel();
            if ($model->insertarAmigo(
                $data['nombre'],
                $data['apellidos'],
                $data['telefono'],
                $data['correo'],
                $data['direccion'],
                $data['pais'],
                $data['contrasena'],
                $data['rol']
            )) {
                log_message('debug', 'El amigo ha sido insertado correctamente');
                return redirect()->to('/success'); // Redirigimos al éxito
            }
            log_message('debug', 'Error al registrar el amigo');
            return redirect()->to('/error')->with('error', 'Error al registrar el amigo.'); // Si hay error, redirigimos a la página de error
        }
        log_message('debug', 'No se recibió el método POST');
        log_message('debug', ''); //IMPRIMIR ACÁ El TIPO DE SOLICITUD OBTENIDA O REALIZADA...
        return view('amigos/register'); // Si no es POST, muestra el form
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
