<?php

namespace App\Controllers;

use App\Models\AmigoModel;

class Prueba extends BaseController
{
    public function index()
    {
        $model = new AmigoModel();

        $data = [
            'nombre'    => 'Juan',
            'apellidos' => 'Pérez',
            'telefono'  => '1234567890',
            'correo'    => 'juan.perez@example.com',
            'direccion' => 'Calle Falsa 123',
            'pais'      => 'Costa Rica',
            'contrasena' => password_hash('password123', PASSWORD_BCRYPT),
            'rol'       => 'amigo',
        ];

        if ($model->insert($data)) {
            echo "Inserción exitosa";
        } else {
            print_r($model->errors());
        }
    }
}
