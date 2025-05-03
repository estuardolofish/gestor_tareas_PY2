<?php


include_once '../configuracion/bd.php';
//session_start(); 
$conexionBD= BD::crearIntacia();

$id= isset($_POST['id']) ? $_POST['id'] : '';
$titulo= isset($_POST['titulo']) ? $_POST['titulo'] : '';
$descripcion= isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
$estado= isset($_POST['estado']) ? $_POST['estado'] : '';
$fecha= isset($_POST['fecha']) ? $_POST['fecha'] : '';
$accion= isset($_POST['accion']) ? $_POST['accion'] : '';


//$usuario_id = 1; // o como lo tengas guardado
$usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] : ''; // ✅ usuario logueado


if ($accion!= '') {
    switch ($accion) {
        case 'agregar':
            $sql= "INSERT INTO tarea (id, titulo, descripcion, estado, fecha_limite,usuario_id) VALUES (NULL, :titulo, :descripcion, :estado, :fecha, :usuario_id)";
            $consulta= $conexionBD->prepare($sql);
            $consulta->bindParam(':titulo', $titulo);
            $consulta->bindParam(':descripcion', $descripcion);
            $consulta->bindParam(':estado', $estado);
            $consulta->bindParam(':fecha', $fecha);
            $consulta->bindParam(':usuario_id', $usuario_id);
            $consulta->execute();
            header("Location: vista_tareas.php");
            exit();
            break;
        
        case 'editar':
            $sql= "UPDATE tarea SET titulo=:titulo, descripcion=:descripcion, estado=:estado, fecha_limite=:fecha,usuario_id=:usuario_id WHERE id=:id";
            $consulta= $conexionBD->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->bindParam(':titulo', $titulo);
            $consulta->bindParam(':descripcion', $descripcion);
            $consulta->bindParam(':estado', $estado);
            $consulta->bindParam(':fecha', $fecha);
            $consulta->bindParam(':usuario_id', $usuario_id);

            $consulta->execute();
            break;
        case 'eliminar':
            $sql= "DELETE FROM tarea WHERE id=:id";
            $consulta= $conexionBD->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->execute();
            break;
        
        case 'Seleccionar':
            $sql= "SELECT * FROM tarea WHERE id=:id";
            $consulta= $conexionBD->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->execute();
            $tarea= $consulta->fetch(PDO::FETCH_ASSOC);
            
            $titulo= $tarea['titulo'];
            $descripcion= $tarea['descripcion'];
            $estado= $tarea['estado'];
            $fecha= $tarea['fecha_limite'];
            break;
            

    }
}

// Obtener el id del usuario de la sesión 
$usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
// Obtener las tareas del usuario
// Asegúrate de que el usuario esté autenticado antes de ejecutar esta consulta
$consulta= $conexionBD->prepare("SELECT * FROM tarea WHERE usuario_id = :usuario_id");
$consulta->bindParam(':usuario_id', $usuario_id);
$consulta->execute();
$listaTareas= $consulta->fetchAll();


?>