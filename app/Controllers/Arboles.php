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
    public function insertarArbol()
{
    // Verificar si el método es POST
    if ($this->request->getMethod() == 'POST') {
        // Mostrar un mensaje de depuración
        log_message('debug', 'Formulario enviado por POST');

        // Obtener los datos del formulario
        $nombre = $this->request->getPost('nombre');
        $especie = $this->request->getPost('especie');
        $precio = $this->request->getPost('precio');
        $estado = $this->request->getPost('estado');

        // Depuración adicional
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
        var_dump($data);
        exit;

        // Verificar si se cargó una foto
        if ($this->request->getFile('foto')->isValid()) {
            $foto = $this->request->getFile('foto');
            $newName = time() . '_' . $foto->getName();
            $foto->move(WRITEPATH . 'uploads/images', $newName);
            $data['foto'] = $newName;
        }

        // Llamar al modelo para insertar el árbol en la base de datos
        // Llamar al modelo para insertar el árbol en la base de datos
if ($this->arbolModel->insertarArbol($data)) {
    // Si el árbol se inserta correctamente
    $mensaje = "Árbol insertado exitosamente.";
    return view('mensaje_view', compact('mensaje'));
} else {
    // Si hubo un error al insertar el árbol
    $mensaje = "Hubo un error al insertar el árbol. Error: " . $this->arbolModel->db->error();
    return view('mensaje_view', compact('mensaje'));
}
}}     
}