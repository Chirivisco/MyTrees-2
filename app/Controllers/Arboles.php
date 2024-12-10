<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ArbolModel;
use CodeIgniter\Files\File;

class Arboles extends Controller
{
    // Cargar el modelo en el constructor
    protected $arbolModel;

    public function __construct()
    {
        $this->arbolModel = new ArbolModel();
    }

    // Método para insertar un árbol
    public function getEspecieIdByNombre($nombre)
{
    // Access the query builder for the 'especies' table
    $builder = $this->db->table('especies');
    $builder->select('id');
    $builder->where('nombre_comercial', $nombre);
    $query = $builder->get();

    // Check if a result is found
    if ($query->getNumRows() > 0) {
        return $query->getRow()->id;
    }

    // Return false if no result is found
    return false;
}

public function insertarArbol()
{
    // Verificar si el método es POST
    if ($this->request->getMethod() == 'POST') {
        // Obtener los datos del formulario
        $nombre = $this->request->getPost('nombre');
        $especie = $this->request->getPost('especie');
        $precio = $this->request->getPost('precio');
        $estado = $this->request->getPost('estado');

        // Validar que todos los campos requeridos están completos
        if (empty(trim($nombre)) || empty(trim($especie)) || empty(trim($precio)) || empty(trim($estado))) {
            $mensaje = "Todos los campos son obligatorios.";
            log_message('debug', "Validación fallida: Nombre: $nombre, Especie: $especie, Precio: $precio, Estado: $estado");
            return view('mensaje_view', compact('mensaje'));
        }        

        // Depuración para verificar los datos recibidos
        log_message('debug', "Nombre: $nombre, Especie: $especie, Precio: $precio, Estado: $estado");

        // Buscar el ID de la especie en la base de datos
        $especie_id = $this->arbolModel->getEspecieIdByNombre($especie);

        // Verificar si se encontró la especie
        if (!$especie_id) {
            $mensaje = "Especie no encontrada.";
            return view('mensaje_view', compact('mensaje'));
        }

        // Preparar los datos para insertar
        $data = [
            'nombre' => $nombre,
            'especie_id' => $especie_id,
            'precio' => $precio,
            'estado' => $estado
        ];

        log_message('debug', 'Datos preparados para inserción: ' . print_r($data, true));

        // Verificar si se cargó una foto
        if ($this->request->getFile('foto')->isValid() && !$this->request->getFile('foto')->hasMoved()) {
            try {
                $foto = $this->request->getFile('foto');
                $newName = time() . '_' . $foto->getName();
                $foto->move(WRITEPATH . 'uploads/images', $newName);
                $data['foto'] = $newName;
            } catch (\Exception $e) {
                $mensaje = "Hubo un error al cargar la foto: " . $e->getMessage();
                return view('mensaje_view', compact('mensaje'));
            }
        }

        // Llamar al modelo para insertar el árbol en la base de datos
        if ($this->arbolModel->insertarArbol($data)) {
            // Si el árbol se inserta correctamente
            $mensaje = "Árbol insertado exitosamente.";
            return view('mensaje_view', compact('mensaje'));
        } else {
            // Si hubo un error al insertar el árbol
            $dbError = $this->arbolModel->db->error();
            $mensaje = "Hubo un error al insertar el árbol: " . $dbError['message'];
            return view('mensaje_view', compact('mensaje'));
        }
    }
}    
}
