<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        // Recibir datos del formulario
        $correo = $this->request->getPost('correo');
        $contrasena = $this->request->getPost('contrasena');
        
        $userModel = new UserModel();
        $user = $userModel->where('correo', $correo)->first();

        if ($user && password_verify($contrasena, $user['contrasena'])) {
            // Iniciar sesión
            session()->set([
                'usuario_id' => $user['id'],
                'rol' => $user['rol'],
                'nombre' => $user['nombre'],
                'correo' => $user['correo'],
            ]);

            // Redirigir según el rol
            if ($user['rol'] == 'Administrador') {
                return redirect()->to('/admin/dashboard');
            } else if ($user['rol'] == 'Amigo') {
                return redirect()->to('/amigos/dashboard');
            }
        } else {
            session()->setFlashdata('error', 'Credenciales incorrectas. Inténtalo de nuevo.');
            return redirect()->to('/login');
        }
    }
}