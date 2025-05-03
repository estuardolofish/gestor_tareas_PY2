<?php
include('../template/cabecera.php');
include_once '../configuracion/bd.php';

$conexionBD = BD::crearIntacia();
$idUsuario = $_SESSION['id']; // ID del usuario logueado

// Consulta de tareas pendientes del usuario
$sentencia = $conexionBD->prepare("
    SELECT id, titulo, descripcion, fecha_limite
    FROM tarea
    WHERE usuario_id = :usuario_id
    AND estado='Pendiente'
    ORDER BY fecha_limite ASC
");
$sentencia->bindParam(':usuario_id', $idUsuario, PDO::PARAM_INT);
$sentencia->execute();
$tareasPendientes = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="p-5 bg-dark text-white">
    <div class="container">
        <h1 class="display-3">Bienvenid@, <?php echo $_SESSION['nombre']; ?>!</h1>
 
        <hr class="my-2">


        <h2 class="mt-5">📌 Tareas pendientes</h2>

        <?php if (count($tareasPendientes) > 0): ?>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover align-middle mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Fecha límite</th>
                            <th>Dias restantes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tareasPendientes as $index => $tarea): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($tarea['titulo']) ?></td>
                                <td><?= htmlspecialchars($tarea['descripcion']) ?></td>
                                <td><?= date('d/m/Y', strtotime($tarea['fecha_limite'])) ?></td>
                                <td>
                                    <?php
                                        $fechaHoy = new DateTime();
                                        $fechaHoy->setTime(0, 0); // Fuerza el inicio del día
                                        $fechaLimite = new DateTime($tarea['fecha_limite']);
                                        $fechaLimite->setTime(0, 0); // También forzamos aquí

                                        if ($fechaHoy <= $fechaLimite) {
                                            $dias = $fechaHoy->diff($fechaLimite)->days + 1; // Sumamos 1 para incluir la fecha final
                                            echo $dias . ' días restantes';
                                        }
                                    ?>
                                </td>



                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-3">No tienes tareas pendientes 🎉</div>
        <?php endif; ?>

        <p class="lead mt-4">
            <a class="btn btn-secondary btn-lg" href="../secciones/vista_tareas.php" role="button">Ver todas las tareas</a>
        </p>
    </div>
</div>

<?php include('../template/pie.php'); ?>
