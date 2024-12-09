<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <!-- Header con opciones de administración -->
        <header class="bg-success text-white text-center py-3">
            <h1>Bienvenido, Administrador</h1>
            <nav>
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#addTreeModal" data-toggle="modal">Agregar Árbol</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#editTreeModal" data-toggle="modal">Editar Árbol</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#deleteTreeModal" data-toggle="modal">Eliminar Árbol</a>
                    </li>
                </ul>
            </nav>
        </header>
        
       <!-- Carrusel de imágenes -->
<div id="carouselArboles" class="carousel slide mb-5" data-ride="carousel" data-interval="4000">
    <div class="carousel-inner">
        <?php if (!empty($arboles)) : ?>
            <?php $isActive = true; // Para activar el primer item ?>
            <?php foreach ($arboles as $arbol) : ?>
                <div class="carousel-item <?= $isActive ? 'active' : '' ?>">
                    <!-- Usamos la URL de la foto desde la base de datos -->
                    <img src="<?= base_url('uploads/images/' . $arbol['foto']) ?>" class="d-block w-100" alt="Imagen de Árbol">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?= $arbol['ubicacion_geografica'] ?></h5>
                        <p>Precio: <?= $arbol['precio'] ?>, Estado: <?= $arbol['estado'] ?></p>
                    </div>
                </div>
                <?php $isActive = false; // Solo el primer item será activo ?>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No hay árboles disponibles.</p>
        <?php endif; ?>
    </div>
    <a class="carousel-control-prev" href="#carouselArboles" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
    </a>
    <a class="carousel-control-next" href="#carouselArboles" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Siguiente</span>
    </a>
</div>


        <!-- Dashboard del Administrador -->

<div class="container mt-5">
    <!-- Bienvenida al usuario -->
   
    <div class="container">
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Amigos Registrados</h5>
                    <p class="card-text display-4"><?= $stats['amigos']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Árboles Disponibles</h5>
                    <p class="card-text display-4"><?= $stats['disponibles']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Árboles Vendidos</h5>
                    <p class="card-text display-4"><?= $stats['vendidos']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

      <!-- Modal para Agregar Árbol -->
<div class="modal fade" id="addTreeModal" tabindex="-1" role="dialog" aria-labelledby="addTreeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTreeModalLabel">Agregar Árbol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar árbol -->
                <form action="<?= site_url('arboles/insertarArbol') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="especie">Especie</label>
                        <select class="form-control" id="especie" name="especie" required>
                            <option value="">Seleccionar Especie</option>
                            <?php foreach ($especies as $especie): ?>
                                <option value="<?= $especie['nombre_comercial'] ?>"><?= $especie['nombre_comercial'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ubicacion">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="">Seleccionar Estado</option>
                            <option value="disponible">Disponible</option>
                            <option value="vendido">Vendido</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" required>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" class="form-control-file" id="foto" name="foto" required>
                    </div>

                    <button type="submit" class="btn btn-success">Agregar Árbol</button>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- Modal para Editar Árbol -->
        <div class="modal fade" id="editTreeModal" tabindex="-1" role="dialog" aria-labelledby="editTreeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTreeModalLabel">Editar Árbol</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario para editar árbol -->
                        <form action="ruta_para_editar_arbol" method="POST">
                            <div class="form-group">
                                <label for="editTreeName">Nombre del Árbol</label>
                                <input type="text" class="form-control" id="editTreeName" name="editTreeName" value="Árbol 1" required>
                            </div>
                            <div class="form-group">
                                <label for="editTreeSpecies">Especie</label>
                                <input type="text" class="form-control" id="editTreeSpecies" name="editTreeSpecies" value="Especie 1" required>
                            </div>
                            <div class="form-group">
                                <label for="editTreePrice">Precio</label>
                                <input type="number" class="form-control" id="editTreePrice" name="editTreePrice" value="100" required>
                            </div>
                            <div class="form-group">
                                <label for="editTreeLocation">Ubicación</label>
                                <input type="text" class="form-control" id="editTreeLocation" name="editTreeLocation" value="Ubicación 1" required>
                            </div>
                            <button type="submit" class="btn btn-warning">Actualizar Árbol</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Eliminar Árbol -->
        <div class="modal fade" id="deleteTreeModal" tabindex="-1" role="dialog" aria-labelledby="deleteTreeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteTreeModalLabel">Eliminar Árbol</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro de que desea eliminar este árbol?</p>
                        <form action="ruta_para_eliminar_arbol" method="POST">
                            <input type="hidden" name="treeId" value="ID_del_Árbol_a_eliminar">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.10/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>