<?php
class BD
{
    public static $instancia = null;
    public static function crearIntacia()
    {
        if (!isset(self::$instancia)) {
            $opciones[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instancia = new PDO('mysql:host=localhost;dbname=gestion_tareas;port=8080', 'root', '', $opciones);
            //echo "Conectado a la base de datos";
        }
        return self::$instancia;
    }
}
?>
