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

    $deleteResponse = $client->DeleteCurso(["id" => $cursoID]);

    if ($deleteResponse->DeleteCursoResult) {
        $success = "Curso eliminado exitosamente.";
    } else {
        $error = "No se pudo eliminar el curso.";
    }
} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}

if ($success) {
    header("Location: index.php");
    exit; 
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Eliminar Curso</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"> <?= htmlspecialchars($error) ?> </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"> <?= htmlspecialchars($success) ?> </div>
    <?php endif; ?>

    <a href="index.php" class="btn btn-primary">Volver a la lista</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
