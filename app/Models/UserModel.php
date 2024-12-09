<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Definimos las propiedades básicas del modelo
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'correo', 'contrasena', 'rol', 'telefono', 'direccion', 'pais'];
    protected $useTimestamps = true;

    
    // Función para validar las credenciales del usuario
    public function validateCredentials($correo, $contrasena)
    {
        // Buscamos el usuario por correo
        $user = $this->where('correo', $correo)->first();

        // Si el usuario existe y la contraseña es correcta, lo devolvemos
        return ($user && password_verify($contrasena, $user['contrasena'])) ? $user : null;
    }

    public function logout()
{
    session()->destroy(); // Esto elimina todos los datos de la sesión
    return redirect()->to('/login');
}

    // Función para obtener estadísticas del administrador
    public function getAdminStats()
    {
        // Obtiene el número de 'Amigos' registrados
        $amigos = $this->db->table('usuarios')
            ->where('rol', 'Amigo') // Asumiendo que los usuarios con rol 'Amigo' son los registrados como usuarios
            ->countAllResults();

        // Obtiene el número de árboles disponibles
        $disponibles = $this->db->table('arboles')
            ->where('estado', 'Disponible')
            ->countAllResults();

        // Obtiene el número de árboles vendidos
        $vendidos = $this->db->table('arboles')
            ->where('estado', 'Vendido')
            ->countAllResults();

        // Devolvemos las estadísticas como un arreglo
        return [
            'amigos' => $amigos,
            'disponibles' => $disponibles,
            'vendidos' => $vendidos,
        ];
    }

    // Función para obtener todos los árboles
    public function getAllTrees()
    {
        return $this->db->table('arboles')
            ->join('especies', 'especies.id = arboles.especie_id')
            ->select('arboles.*, especies.nombre_comercial')
            ->get()->getResultArray();
    }

    // Función para obtener un árbol por su ID
    public function getTreeById($arbol_id)
    {
        return $this->db->table('arboles')
            ->where('id', $arbol_id)
            ->get()->getRowArray();
    }

    // Función para insertar un árbol
    public function insertTree($data)
    {
        $this->db->table('arboles')->insert($data);
    }

    // Función para actualizar un árbol
    public function updateTree($arbol_id, $data)
    {
        $this->db->table('arboles')
            ->where('id', $arbol_id)
            ->update($data);
    }

    // Función para eliminar un árbol
    public function deleteTree($arbol_id)
    {
        $this->db->table('arboles')
            ->where('id', $arbol_id)
            ->delete();
    }

    // Función para obtener todas las especies
    public function getAllSpecies()
    {
        return $this->db->table('especies')->get()->getResultArray();
    }
}