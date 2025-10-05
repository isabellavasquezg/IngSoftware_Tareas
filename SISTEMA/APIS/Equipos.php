<?php
ini_set('display_errors', 0); 
header('Content-Type: application/json');
/* 
TAKEN FORM: https://github.com/oscaruhp/empleados
AUTHOR: Oscar Uh

MODIFIED AND ADAPTED BY: Angelower Santana-Velásquez

*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/*  Conecta con la base de datos en el servidor local 
	usando las credenciales de usuario y contraseña */
$servidor = "localhost"; 
$usuario = "root"; 
$passwd = ""; 
$nombreBaseDatos = "sgt";
$conexionBD = new mysqli($servidor, $usuario, $passwd, $nombreBaseDatos);

// Verificar la conexión de inmediato
if ($conexionBD->connect_error) {
    // Si la conexión falla, devuelve un JSON de error de servidor
    header('Content-Type: application/json');
    echo json_encode(["success" => 0, "error" => "Fallo en la conexión con la base de datos: " . $conexionBD->connect_error]);
    exit(); // 👈 Termina el script aquí para evitar el error 500
}

// Get : obtener información, post: insertar datos , put:actualizaciones , delete:borrar.
/* Consulta UN registro de una UBICACIÓN de la tabla ubicaciones teniendo como criterio de búsqueda 
   la variable 'id' que viene en el $_GET["consultar"] 
   */
if (isset($_GET["consultar"])){
        $sqlEquipos = mysqli_query($conexionBD,"SELECT * FROM equipos_medicos WHERE id=".$_GET["consultar"]);
        if(mysqli_num_rows($sqlEquipos) > 0){
            $equipos = mysqli_fetch_all($sqlEquipos,MYSQLI_ASSOC);
            echo json_encode($equipos); 
            exit();
        } else{  echo json_encode(["success"=>0]); }
}

/* Consulta UN registro de una UBICACIÓN de la tabla ubicaciones teniendo como criterio de búsqueda 
   la variable 'CodigoAsignado' que viene en el $_GET["consultar"] 
   */

/* Borra un registro de una UBICACIÓN de la tabla ubicaciones, teniendo como criterio de búsqueda 
   la variable 'id' que viene en el $_GET["borrar"] 
   */
if (isset($_GET["borrar"])) {
    header('Content-Type: application/json; charset=utf-8'); // 👈 fuerza JSON
    $id = intval($_GET["borrar"]);
    $sqlEquipos = mysqli_query($conexionBD, "DELETE FROM equipos_medicos WHERE id=$id");
    if ($sqlEquipos) {
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0]);
    }
    exit();
}
/* Inserta un registro de una ubicación de la tabla Ubicaciones. La información es recibida en método POST */
if (isset($_GET["insertar"])) {
    $data = json_decode(file_get_contents("php://input"));

    // Aplicar seguridad contra inyección SQL
    $numeroActivo      = mysqli_real_escape_string($conexionBD, (isset($data->numeroActivo) ? $data->numeroActivo : ""));
    $marca             = mysqli_real_escape_string($conexionBD, (isset($data->marca) ? $data->marca : ""));
    $modelo            = mysqli_real_escape_string($conexionBD, (isset($data->modelo) ? $data->modelo : ""));
    $codigoUbicacion   = mysqli_real_escape_string($conexionBD, (isset($data->codigoUbicacion) ? $data->codigoUbicacion : ""));
    $codigoResponsable = mysqli_real_escape_string($conexionBD, (isset($data->codigoResponsable) ? $data->codigoResponsable : ""));

    if ($numeroActivo !== "" && $marca !== "" && $modelo !== "" && $codigoUbicacion !== "" && $codigoResponsable !== "") {
        
        $sql = mysqli_query(
            $conexionBD,
            "INSERT INTO equipos_medicos(numeroActivo, marca, modelo, codigoUbicacion, codigoResponsable) 
             VALUES('$numeroActivo','$marca','$modelo','$codigoUbicacion','$codigoResponsable')"
        );

        if ($sql) {
            // Éxito
            echo json_encode(["success" => 1, "message" => "Equipo insertado correctamente."]);
        } else {
            // Error de la base de datos
            $error_numero = mysqli_errno($conexionBD);

            // Manejo del error de clave UNICA duplicada (Código 1062 para MySQL)
            if ($error_numero === 1062) {
                echo json_encode([
                    "success" => 0,
                    "error" => "El número de activo **{$numeroActivo}** ya existe. Por favor, verifique el código."
                ]);
            } else {
                // Otro error de BD
                echo json_encode([
                    "success" => 0,
                    "error" => "Error de la base de datos: " . mysqli_error($conexionBD)
                ]);
            }
        }
    } else {
        // Datos incompletos
        echo json_encode(["success" => 0, "error" => "Error: Faltan datos obligatorios para el equipo."]);
    }
    exit();
}

/* Actualizar un registro existente */
if(isset($_GET["actualizar"])){ 
    $data = json_decode(file_get_contents("php://input"));
    $id = isset($data->id) ? $data->id : $_GET["actualizar"];

    $numeroActivo      = $data->numeroActivo;
    $marca             = $data->marca;
    $modelo            = $data->modelo; 
    $codigoUbicacion   = $data->codigoUbicacion;
    $codigoResponsable = $data->codigoResponsable;

    $sql = mysqli_query(
        $conexionBD,
        "UPDATE equipos_medicos 
         SET numeroActivo='$numeroActivo', marca='$marca', modelo='$modelo', 
             codigoUbicacion='$codigoUbicacion', codigoResponsable='$codigoResponsable' 
         WHERE id='$id'"
    );

    if($sql){
        echo json_encode(["success"=>1]);
    } else {
        echo json_encode(["success"=>0, "error"=>mysqli_error($conexionBD)]);
    }
    exit();
}

$sql_query = "
    SELECT
        e.*,  -- Selecciona todas las columnas de la tabla equipos_medicos (e)
        u.nombre as nombre_ubicacion,
        u.ubicacion,
        r.nombre,
        r.apellido,
        r.cargo
    FROM
        equipos_medicos e
    JOIN
        ubicaciones u ON e.codigoUbicacion = u.codigoAsignado
    JOIN
        responsables r ON e.codigoResponsable = r.codigoAsignado;
";

$sql = mysqli_query($conexionBD, $sql_query);

if (mysqli_num_rows($sql) > 0) {
    // 1. Obtener los resultados de la consulta
    $activos_con_joins = mysqli_fetch_all($sql, MYSQLI_ASSOC);
    
    // 2. Procesar los resultados para concatenar los strings como quieres
    $activos_procesados = array_map(function($equipo) {
        
        // Crear el string de Ubicación
        $equipo['ubicacion_completa'] = $equipo['nombre_ubicacion'] . ': ' . $equipo['ubicacion'];
        
        // Crear el string del Responsable
        $equipo['responsable_completo'] = $equipo['cargo'] . ': '.$equipo['nombre'] . ' ' . $equipo['apellido'];
        
        // Opcional: Eliminar las columnas que no quieres que se vean en el frontend (solo quieres las completas)
        unset($equipo['codigoUbicacion']);
        unset($equipo['codigoResponsable']);
        unset($equipo['nombre_ubicacion']);
        unset($equipo['ubicacion']);
        unset($equipo['nombre']);
        unset($equipo['apellido']);
        unset($equipo['cargo']);
        
        return $equipo;
    }, $activos_con_joins);

    echo json_encode($activos_procesados);
    
} else { 
    echo json_encode([["success" => 0]]); 
}

// ... (Cierre de la conexión, etc.)
?>