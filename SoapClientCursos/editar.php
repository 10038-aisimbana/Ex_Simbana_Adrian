<?php

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID del curso no especificado.");
}

$cursoID = intval($_GET['id']);
$error = "";
$success = "";

try {

    $wsdl = "http://localhost:54821/Service.svc?wsdl";
    $client = new SoapClient($wsdl);

    $response = $client->RetrieveById(["id" => $cursoID]);

    /*echo '<pre>';
print_r($response);
echo '</pre>';
exit;*/

if (isset($response->RetrieveByIdResult)) {
    $curso = $response->RetrieveByIdResult;
} else {
    die("No se pudo cargar el curso.");
}


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'] ?? "";
        $descripcion = $_POST['descripcion'] ?? "";
        $creditos = $_POST['creditos'] ?? "";


        if (empty($nombre) || empty($creditos)) {
            $error = "El nombre y los créditos son obligatorios.";
        } else {

            $updateResponse = $client->UpdateCurso([
                "curso" => [
                    "CursoID" => $cursoID,
                    "Nombre" => $nombre,
                    "Descripcion" => $descripcion,
                    "Creditos" => intval($creditos)
                ]
            ]);

            if ($updateResponse->UpdateCursoResult) {
                $success = "Curso actualizado exitosamente.";

                $curso->Nombre = $nombre;
                $curso->Descripcion = $descripcion;
                $curso->Creditos = intval($creditos);

                header("Location: index.php");
                exit;
                
            } else {
                $error = "No se pudo actualizar el curso.";
            }
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
    <title>Editar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Curso</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"> <?= htmlspecialchars($error) ?> </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"> <?= htmlspecialchars($success) ?> </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($curso->Nombre ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion"><?= htmlspecialchars($curso->Descripcion ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="creditos" class="form-label">Créditos</label>
            <input type="number" class="form-control" id="creditos" name="creditos" value="<?= htmlspecialchars($curso->Creditos ?? '') ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
