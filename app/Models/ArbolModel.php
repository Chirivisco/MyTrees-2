<?php

namespace App\Models;
use CodeIgniter\Model;

class ArbolModel extends Model
{
    protected $table = 'arboles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['especie_id', 'ubicacion_geografica', 'estado', 'precio', 'foto'];

    // Obtener todos los árboles disponibles
    public function getArboles()
    {
        // Obtener todos los árboles con estado 'Disponible'
        return $this->where('estado', 'Disponible')
                    ->findAll(); // Devuelve todos los registros que coinciden con la condición
    }

    // Insertar un árbol en la base de datos
    public function insertarArbol($data)
{
    // Intenta insertar los datos en la base de datos
    if ($this->db->table('arboles')->insert($data)) {
        return true;
    } else {
        // Devuelve el error si algo falla
        return $this->db->error();
    }
}
  

    // Obtener todas las especies disponibles
    public function getEspecies()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('especies');
        $builder->select('id, nombre_comercial');
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getEspecieIdByNombre($nombre) {
        // Buscar la especie por nombre
        $this->db->select('id');
        $this->db->from('especies');
        $this->db->where('nombre', $nombre);
        $query = $this->db->get();

        // Si se encuentra la especie, devolver el ID
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        }

        // Si no se encuentra la especie, devolver falso
        return false;
    }
}