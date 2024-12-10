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
    public function insertarArbol($data)
{
    $builder = $this->db->table('arboles');
    return $builder->insert($data); // Inserta los datos proporcionados
}
    
    public function getEspecieIdByNombre($nombre)
    {
        $builder = $this->db->table('especies');
        $builder->select('id');
        $builder->where('nombre_comercial', $nombre);
        $query = $builder->get();
    
        if ($query->getNumRows() > 0) {
            return $query->getRow()->id;
        }
    
        return false;
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
}
