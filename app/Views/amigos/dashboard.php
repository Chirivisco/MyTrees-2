<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Amigo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <header class="bg-primary text-white text-center py-3">
            <h1>Bienvenido, Amigo</h1>
        </header>
        
        <div class="text-center mt-5">
            <h2>Árboles Disponibles</h2>

            <!-- Tabla de Árboles Disponibles -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Especie</th>
                        <th>Ubicación</th>
                        <th>Precio</th>
                        <th>Foto</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($arboles)): ?>
                        <?php foreach ($arboles as $arbol): ?>
                            <tr>
                                <td><?= esc($arbol['especie_id']); ?></td>
                                <td><?= esc($arbol['ubicacion_geografica']); ?></td>
                                <td><?= esc($arbol['precio']); ?> USD</td>
                                <td>
                                    <?php if (!empty($arbol['foto'])): ?>
                                        <img src="<?= base_url('uploads/images/' . esc($arbol['foto'])) ?>" alt="Foto del árbol" width="100">
                                    <?php else: ?>
                                        <img src="default.jpg" alt="Foto no disponible" width="100">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('compra/arbol/' . $arbol['id']) ?>" class="btn btn-success">Comprar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No available trees at the moment.</p>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
