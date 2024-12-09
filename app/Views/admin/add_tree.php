<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Árbol</title>
</head>
<body>
    <h1>Agregar un Nuevo Árbol</h1>
    
    <form action="<?= site_url('admin/insert_tree') ?>" method="POST">
        <label for="nombre">Nombre del Árbol:</label>
        <input type="text" name="nombre" required><br>

        <label for="especie_id">Especie:</label>
        <select name="especie_id" required>
            <?php foreach ($especies as $especie): ?>
                <option value="<?= $especie['id'] ?>"><?= $especie['nombre_comercial'] ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="precio">Precio:</label>
        <input type="number" name="precio" required><br>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="Disponible">Disponible</option>
            <option value="Vendido">Vendido</option>
        </select><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>