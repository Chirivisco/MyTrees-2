<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\ArbolModel;

class AdminController extends Controller
{
    public function dashboard()
{
    // Verificar si el usuario está autenticado
    $user_id = session()->get('id'); // Obtener el ID del usuario desde la sesión


    // Obtener información del usuario desde el modelo, si es necesario
    $userModel = new UserModel();
    $user = $userModel->find($user_id);

    // Obtener estadísticas del administrador, si es necesario
    $stats = $userModel->getAdminStats();

    $arbolModel = new ArbolModel();
        
        // Obtener todos los árboles disponibles
    $arboles = $arbolModel->getArboles();
    $especies = $arbolModel ->getEspecies();

    // Pasar los datos a la vista
    return view('admin/dashboard', ['stats' => $stats, 'arboles' => $arboles, 'especies'=> $especies]);
}

}

