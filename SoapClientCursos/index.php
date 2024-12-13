<?php

try {
    $client = new SoapClient('http://localhost:54821/Service.svc?wsdl');


    $response = $client->RetrieveAllCursos();


    $cursos = $response->RetrieveAllCursosResult->Cursos ?? [];

} catch (SoapFault $e) {
    
    die("<div style='text-align:center; margin-top:50px; font-family:Arial, sans-serif;'>
            <h1 style='color:red;'>Error de conexión</h1>
            <p>No se pudo conectar con el servicio SOAP. Por favor, verifica que el servicio esté en ejecución y la URL sea correcta.</p>
        </div>");
}

/*echo "<pre>";
print_r($cursos);
echo "</pre>";
die();*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">CURSOS</h1>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <a href="crear.php" class="btn btn-success mb-3">Crear Curso</a>
        <a href="buscar.php" class="btn btn-dark mb-3">Buscar Cursos</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Créditos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cursos)) : ?>
                    <?php foreach ($cursos as $curso) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($curso->CursoID); ?></td>
                            <td><?php echo htmlspecialchars($curso->Nombre); ?></td>
                            <td><?php echo htmlspecialchars($curso->Descripcion); ?></td>
                            <td><?php echo htmlspecialchars($curso->Creditos); ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo htmlspecialchars($curso->CursoID); ?>" class="btn btn-primary btn-sm">Editar</a>
                                <a href="eliminar.php?id=<?php echo htmlspecialchars($curso->CursoID); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este curso?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay cursos disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
