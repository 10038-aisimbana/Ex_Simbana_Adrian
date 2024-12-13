<?php

$nombre = $_GET['nombre'] ?? '';
$cursos = [];
$error = "";

try {
    $wsdl = "http://localhost:54821/Service.svc?wsdl";
    $client = new SoapClient($wsdl);

    if (!empty($nombre)) {
        //echo "Nombre enviado al servicio SOAP: " . htmlspecialchars($nombre);  
        try {
            $response = $client->FilterCursos(["name" => $nombre]);

            echo '<pre>';
            print_r($response);
            echo '</pre>';
            
            if (isset($response->FilterCursosResult->Cursos) && is_array($response->FilterCursosResult->Cursos)) {
                $cursos = $response->FilterCursosResult->Cursos;
            } else {
                $error = "No se encontraron cursos con ese nombre.";
            }
        } catch (Exception $e) {
            $error = "Error al hacer la solicitud SOAP: " . $e->getMessage();
        }
    }
} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Buscar Cursos</h2>

    <form method="GET" action="">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del curso</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" placeholder="Ingrese el nombre del curso">
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button><br><br>
    </form>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-3"> <?= htmlspecialchars($error) ?> </div>
    <?php endif; ?>

    <?php if (!empty($cursos)): ?>
        <h3 class="mt-3">Cursos encontrados:</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Curso ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Créditos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cursos as $curso): ?>
                    <tr>
                        <td><?= htmlspecialchars($curso->CursoID ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($curso->Nombre ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($curso->Descripcion ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($curso->Creditos ?? 'N/A') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table><br>
    <?php endif; ?>

    <a href="index.php" class="btn btn-dark mb-3">Regresar</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
