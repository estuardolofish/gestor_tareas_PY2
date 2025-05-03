<?php
session_start();
if (!isset($_SESSION['nombre'])) {
 header('Location: ../index.php');
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Gestión De Tareas</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>

<body class="bg-dark text-white">
    <!--barra de navegacion-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="index.php">Inicio</a>
            <a class="nav-item nav-link active" href="vista_tareas.php">Gestión de Tareas</a>
        </div>
        <div class="navbar-nav ms-auto">
            <a class="nav-item nav-link" href="cerrar.php">Cerrar Sesión</a>
        </div>
    </div>
</nav>


