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
public function dashboard()
    {
        // Obtener los árboles disponibles
        $arboles = $this->arbolModel->getArboles();

        var_dump($arboles);
        return view('dashboard_amigo', ['arboles' => $arboles]);
    }

public function insertarArbol()
{
    // Verificar si el método es POST
    if ($this->request->getMethod() == 'POST') {
        // Obtener los datos del formulario
        $especie = $this->request->getPost('especie'); // Aquí se obtiene el nombre de la especie
        $ubicacion = $this->request->getPost('ubicacion'); // Ubicación geográfica
        $estado = $this->request->getPost('estado'); // Estado
        $precio = $this->request->getPost('precio'); // Precio

        // Verificar si las variables son null y asignar un valor por defecto si es necesario
        $especie = trim($especie ?? '');  // Si $especie es null, asigna una cadena vacía
        $ubicacion = trim($ubicacion ?? '');  // Lo mismo para $ubicacion
        $estado = trim($estado ?? '');  // Y para $estado
        $precio = trim($precio ?? '');  // Y para $precio

        // Validar que todos los campos requeridos están completos
        if (empty($especie) || empty($ubicacion) || empty($precio) || empty($estado)) {
            $mensaje = "Todos los campos son obligatorios.";
            log_message('debug', "Validación fallida: Especie: $especie, Ubicación: $ubicacion, Precio: $precio, Estado: $estado");
            
            // Pasar el mensaje y los datos a la vista
            return view('mensaje_view', ['mensaje' => $mensaje, 'datos' => compact('especie', 'ubicacion', 'precio', 'estado')]);
        }

        // Depuración para verificar los datos recibidos
        log_message('debug', "Especie: $especie, Ubicación: $ubicacion, Precio: $precio, Estado: $estado");

        // Buscar el ID de la especie en la base de datos
        $especie_id = $this->arbolModel->getEspecieIdByNombre($especie);

        // Verificar si se encontró la especie
        if (!$especie_id) {
            $mensaje = "Especie no encontrada.";
            return view('mensaje_view', ['mensaje' => $mensaje, 'datos' => compact('especie', 'ubicacion', 'precio', 'estado')]);
        }

        // Preparar los datos para insertar
        $data = [
            'especie_id' => $especie_id,
            'ubicacion_geografica' => $ubicacion,
            'estado' => $estado,
            'precio' => $precio
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
                return view('mensaje_view', ['mensaje' => $mensaje, 'datos' => compact('especie', 'ubicacion', 'precio', 'estado')]);
            }
        }

        // Realizar la inserción en la base de datos
        if ($this->arbolModel->insertarArbol($data)) {
            $mensaje = "Árbol agregado correctamente.";
            return view('mensaje_view', ['mensaje' => $mensaje]);
        } else {
            $mensaje = "Error al agregar el árbol.";
            return view('mensaje_view', ['mensaje' => $mensaje]);
        }
    }
}
}
