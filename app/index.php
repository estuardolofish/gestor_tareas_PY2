<?php


include_once 'configuracion/bd.php';
session_start();
$conexionBD = BD::crearIntacia();

//$sentencia = $conexionBD->prepare("SELECT * FROM usuario ");
//$sentencia->execute();
//$listado = $sentencia->fetchAll();
//print_r($listado);



if (isset($_POST['btnLogin'])) {
    $mensaje = "Usuario o contraseña incorrectos";

    $txtnombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $txtpassword = isset($_POST['password']) ? $_POST['password'] : '';
    $captcha = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    // Validar el captcha
    // Aquí deberías implementar la lógica para validar el captcha

    $secret = '6LcXZiorAAAAAKMc-mgAfQOf7qssiJjVGUXEZ-My'; // clave secreta de Google reCAPTCHA
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
    $responseKeys = json_decode($response, true);

    // Verificar si el captcha es válido

    if (intval($responseKeys["success"]) !== 1) {
        $mensaje = "Por favor, verifica que no eres un robot.";
    } else {
        // Verificar usuario y contraseña en la base de datos
        $sentencia = $conexionBD->prepare("SELECT * FROM usuario WHERE nombre = :nombre ");
        $sentencia->bindParam(':nombre', $txtnombre);
        $sentencia->execute();

        // Verificar si existe el usuario
        if ($sentencia->rowCount() > 0) {
            $nombre = $sentencia->fetch(PDO::FETCH_ASSOC);
            if (password_verify($txtpassword, $nombre['password'])) {
                // Si la contraseña es correcta, iniciar sesión


                $codigo2FA = rand(100000, 999999);
                $_SESSION['codigo2FA'] = $codigo2FA;
                $_SESSION['expira2FA'] = time() + 300; // 5 minutos
                $_SESSION['temp_usuario'] = $nombre;
                
                $mensaje = "Tu código de verificación 2FA es: <strong>$codigo2FA</strong>";
                $mostrar2FA = true;
                


                //$_SESSION['nombre'] = $nombre['nombre'];
                //$_SESSION['id'] = $nombre['id'];
                //header('Location: secciones/index.php');
                //exit();
            }
        }
    }
}

if (isset($_POST['btnVerificar2FA'])) {
    $codigoIngresado = $_POST['codigo2FA'] ?? '';
    if (
        isset($_SESSION['codigo2FA']) &&
        $codigoIngresado == $_SESSION['codigo2FA'] &&
        time() < $_SESSION['expira2FA']
    ) {
        //  Autenticación exitosa
        $_SESSION['nombre'] = $_SESSION['temp_usuario']['nombre'];
        $_SESSION['id'] = $_SESSION['temp_usuario']['id'];
        unset($_SESSION['temp_usuario'], $_SESSION['codigo2FA'], $_SESSION['expira2FA']);
        header('Location: secciones/index.php');
        exit();
    } else {
        $mensaje = "Código incorrecto o expirado.";
        $mostrar2FA = true;
    }
}


?>



<!doctype html>
<html lang="en">

<head>
    <title>Inicio de sesión</title>
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
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="bg-dark text-white">
    <div class="container bg-dark text-white">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <br>
                <form action="" method="post">
                    <div class="card bg-dark text-white">
                        <div class="card-header">
                            Inicio de sesión
                        </div>
                        <div class="card-body">
                            <?php if (isset($mensaje)) { ?>
                                <div class="alert alert-dark"" role="alert">
                                    <strong><?php echo $mensaje; ?></strong>
                                </div>
                            <?php } ?>

                            <?php if (!isset($mostrar2FA) || !$mostrar2FA): ?>
                                <!-- FORMULARIO DE USUARIO Y CONTRASEÑA -->
                                <div class="mb-3">
                                    <label for="" class="form-label">Usuario</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="nombre"
                                        id="usuario"
                                        placeholder="Usuario"
                                        required>
                                    <small class="form-text text-white">Escriba su usuario</small>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Contraseña</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        name="password"
                                        id="password"
                                        placeholder="Contraseña"
                                        required>
                                    <small class="form-text text-white">Escriba su contraseña</small>
                                </div>

                                <div class="g-recaptcha" data-sitekey="6LcXZiorAAAAAMM1WWj3sVP_Uq2yEbkMIhHZrpZo"></div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-dark" name="btnLogin">Iniciar sesión</button>
                                    <a href="secciones/registro.php">
                                        <button type="button" class="btn btn-secondary">Registrarse</button>
                                    </a>
                                </div>

                            <?php else: ?>
                                <!-- FORMULARIO 2FA -->
                                <div class="mb-3">
                                    <label for="codigo2FA" class="form-label">Código de verificación (2FA)</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="codigo2FA"
                                        id="codigo2FA"
                                        placeholder="Ingresa el código enviado"
                                        required>
                                    <small class="form-text text-white">Revisa tu correo</small>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success" name="btnVerificar2FA">Verificar</button>
                                </div>
                            <?php endif; ?>
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