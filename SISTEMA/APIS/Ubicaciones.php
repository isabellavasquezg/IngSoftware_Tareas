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
        $sqlUbicaciones = mysqli_query($conexionBD,"SELECT * FROM ubicaciones WHERE id=".$_GET["consultar"]);
        if(mysqli_num_rows($sqlUbicaciones) > 0){
            $ubicacion = mysqli_fetch_all($sqlUbicaciones,MYSQLI_ASSOC);
            echo json_encode($ubicacion); 
            exit();
        } else{  echo json_encode(["success"=>0]); }
}

/* Consulta UN registro de una UBICACIÓN de la tabla ubicaciones teniendo como criterio de búsqueda 
   la variable 'CodigoAsignado' que viene en el $_GET["consultar"] 
   */

/* Borra un registro de una UBICACIÓN de la tabla ubicaciones, teniendo como criterio de búsqueda 
   la variable 'id' que viene en el $_GET["borrar"] 
   */
if (isset($_GET['borrar'])) {
    $id = mysqli_real_escape_string($conexionBD, $_GET['borrar']);

    // 🎯 PASO 1: Contar cuántos equipos usan esta ubicación
    $sql_count = "SELECT COUNT(*) AS total_equipos FROM equipos_medicos WHERE codigoUbicacion = '$id'";
    $resultado_count = mysqli_query($conexionBD, $sql_count);
    $fila_count = mysqli_fetch_assoc($resultado_count);
    $total_equipos = $fila_count['total_equipos'];
    
    // Si no hay equipos asociados, procedemos con el DELETE
    if ($total_equipos == 0) {
        $resultado = mysqli_query($conexionBD, "DELETE FROM ubicaciones WHERE codigoAsignado = '$id'");
        
        if ($resultado) {
            echo json_encode(["success" => 1, "message" => "Ubicación eliminada correctamente."]);
        } else {
            // Este caso debería ser raro si el conteo fue 0
            echo json_encode(["success" => 0, "error" => "Error desconocido al intentar eliminar la ubicación."]);
        }

    } else {
        // 🎯 PASO 2: Error de restricción con la cuenta exacta
        echo json_encode([
            "success" => 0, 
            "error" => "No se puede eliminar esta ubicación. Hay **{$total_equipos}** equipo(s) asociado(s) que deben reasignarse o eliminarse primero."
        ]);
    }
    exit();
}

/* Inserta un registro de una ubicación de la tabla Ubicaciones. La información es recibida en método POST */
if (isset($_GET["insertar"])) {
    $data = json_decode(file_get_contents("php://input"));
    
    $codigoAsignado = mysqli_real_escape_string($conexionBD, $data->codigoAsignado ?? "");
    $nombre = mysqli_real_escape_string($conexionBD, $data->nombre ?? "");
    $ubicacion = mysqli_real_escape_string($conexionBD, $data->ubicacion ?? "");
    $telefono = mysqli_real_escape_string($conexionBD, $data->telefono ?? "");

    if ($codigoAsignado !== "" && $nombre !== "" && $ubicacion !== "" && $telefono !== "") {
        $sql = mysqli_query(
            $conexionBD,
            "INSERT INTO ubicaciones(codigoAsignado, nombre, ubicacion, telefono) 
             VALUES('$codigoAsignado','$nombre','$ubicacion','$telefono')"
        );

        if ($sql) {
            echo json_encode(["success" => 1, "message" => "Registro insertado correctamente."]);
        } else {
            $error_numero = mysqli_errno($conexionBD);

            // 🎯 Manejo del error de clave UNICA duplicada (Código 1062)
            if ($error_numero === 1062) {
                echo json_encode([
                    "success" => 0,
                    "error" => "El código asignado **{$codigoAsignado}** ya existe. Por favor, use otro código."
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
        echo json_encode(["success" => 0, "error" => "Datos incompletos"]);
    }
    exit();
}


/* Actualiza todos los campos de la tabla ubiaciones, teniendo como criterio de búsqueda 
   la variable 'id' que viene en el $_GET["actualizar"]
   */
if(isset($_GET["actualizar"])){ 
    $data = json_decode(file_get_contents("php://input"));
    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $codigoAsignado=$data->codigoAsignado;
    $nombre=$data->nombre;
    $ubicacion=$data->ubicacion; 
    $telefono=$data->telefono; 
	$sqlUbicaciones = mysqli_query($conexionBD,"UPDATE ubicaciones SET  codigoAsignado='$codigoAsignado',nombre='$nombre',ubicacion='$ubicacion', telefono='$telefono' WHERE id='$id'");
	echo json_encode(["success"=>1]);
	exit();   
}

/*
	Muestra todos los registros almacenados en la tabla ubucaciones, usando la URL raíz.
*/
$sqlubicaciones_ = mysqli_query($conexionBD,"SELECT * FROM ubicaciones ");
if(mysqli_num_rows($sqlubicaciones_) > 0){
    $ubicaciones_ = mysqli_fetch_all($sqlubicaciones_,MYSQLI_ASSOC);
    echo json_encode($ubicaciones_);
}
else{ echo json_encode([["success"=>0]]); }
