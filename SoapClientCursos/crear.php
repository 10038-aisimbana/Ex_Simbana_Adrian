<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        $client = new SoapClient('http://localhost:54821/Service.svc?wsdl');


        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $creditos = $_POST['creditos'] ?? 0;

    
        if (empty($nombre) || empty($creditos)) {
            throw new Exception('El nombre y los créditos son obligatorios.');
        }

        $nuevoCurso = [
            'Nombre' => $nombre,
            'Descripcion' => $descripcion,
            'Creditos' => (int)$creditos
        ];

      
        $response = $client->CreateCurso(['curso' => $nuevoCurso]);

    
        if ($response->CreateCursoResult) {

            header('Location: index.php?mensaje=Curso creado exitosamente');
            exit;
        } else {
            throw new Exception('No se pudo crear el curso.');
        }
    } catch (SoapFault $e) {
        $error = 'Error al conectar con el servicio SOAP: ' . $e->getMessage();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Crear Curso</h1>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="crear.php" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            </div>
            <div class="mb-3">
                <label for="creditos" class="form-label">Créditos</label>
                <input type="number" class="form-control" id="creditos" name="creditos" required>
            </div>
            <button type="submit" class="btn btn-success">Crear</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
