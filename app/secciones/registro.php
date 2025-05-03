<?php
include_once '../configuracion/bd.php';
$conexionBD = BD::crearIntacia();

if (isset($_POST['btnRegistro'])) {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($nombre != '' && $correo != '' && $password != '') {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Encriptar la contraseña

        $sql = "INSERT INTO usuario (nombre, correo, password) VALUES (:nombre, :correo, :password)";
        $consulta = $conexionBD->prepare($sql);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':correo', $correo);
        $consulta->bindParam(':password', $passwordHash);
        $consulta->execute();
        echo "Usuario registrado con éxito";

        header('Location: ../index.php'); // Redirige al login después de registrarse
        exit();
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
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

    <div class="container">
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-6">
                <br>
                <form action="" method="post">

                    <div class="card bg-dark text-white">
                        <div class="card-header">
                            Registro de Usuarios
                        </div>
                        <div class="card-body ">
                            <div class="mb-3">
                                <label for="" class="form-label">Nombre Completo</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="nombre"
                                    id="usuario"
                                    aria-describedby="helpId"
                                    placeholder="Usuario">

                                <small id="helpId" class="form-text  text-white">Escriba su nombre completo</small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Ingrese su Correo</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    name="correo"
                                    id="correo"
                                    aria-describedby="helpId"
                                    placeholder="correo electronico">
                                <small id="helpId" class="form-text text-white">Escriba su correo</small>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Contraseña</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    id="password"
                                    aria-describedby="helpId"
                                    placeholder="Contraseña">
                                <small id="helpId" class="form-text text-white">Escriba su congraseña</small>
                            </div>


                            <div>
                                <button
                                    type="submit"
                                    class="btn btn-dark"
                                    name="btnRegistro"
                                    value="registrar"
                                    id="btnRegistro">Registrarse
                                </button>


                                <a href="../index.php">
                                    <button type="button" class="btn btn-secondary">Cancelar</button>
                                </a>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <header>
        <!-- place navbar here -->
    </header>
    <main></main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>