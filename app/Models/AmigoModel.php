<?php

namespace App\Models;

use CodeIgniter\Model;

class AmigoModel extends Model {
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'apellidos', 'telefono', 'correo', 'direccion', 'pais', 'contrasena', 'rol'];
    protected $useTimestamps = true;

    // Método personalizado para insertar un nuevo amigo
    public function insertarAmigo($nombre, $apellidos, $telefono, $correo, $direccion, $pais, $contrasena, $rol)
    {
        // Usamos la base de datos directamente para hacer la inserción
        try {
            $query = $this->db->query("INSERT INTO usuarios (nombre, apellidos, telefono, correo, direccion, pais, contrasena, rol) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [
                $nombre, $apellidos, $telefono, $correo, $direccion, $pais, 
                password_hash($contrasena, PASSWORD_DEFAULT), $rol
            ]);
    
            // Verificar si la consulta se ejecutó correctamente
            if ($query) {
                return $this->db->insertID(); // Retorna el ID del nuevo registro insertado
            } else {
                // Si no se insertó, loggeamos el error
                log_message('error', 'Error al insertar amigo: ' . $this->db->error());
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'Excepción al insertar amigo: ' . $e->getMessage());
            return false;
        }
    }
    
}
