<?php
// ---- SOLUCIÓN A LOS ERRORES 500 Y DE JSON ----
// Es CRÍTICO que MySQL esté corriendo para evitar el error fatal 500.
ini_set('display_errors', 0); 
ini_set('display_startup_errors', 0); 
error_reporting(E_ALL); 
// ------------------------------------------------

/* SCRIPT DE AUTENTICACIÓN PARA VUEJS (USANDO HASH SHA256)
*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/* Conecta con la base de datos en el servidor local */
$servidor = "localhost"; 
$usuario_db = "root"; 
$passwd_db = ""; 
$nombreBaseDatos = "sgt";

// 1. INTENTO DE CONEXIÓN (se usa @ para suprimir errores fatales si MySQL no está activo)
$conexionBD = @new mysqli($servidor, $usuario_db, $passwd_db, $nombreBaseDatos);

// Manejar peticiones OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// 2. VERIFICACIÓN ROBUSTA DE CONEXIÓN
// Si la conexión falla, se devuelve un error 500 en JSON, no en HTML.
if ($conexionBD->connect_error) { 
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error de servidor: No se pudo conectar a la base de datos."]);
    exit();
}

// ----------------------------------------------------
// LÓGICA DE AUTENTICACIÓN
// ----------------------------------------------------

$data = json_decode(file_get_contents("php://input"), true);

// 3. VALIDACIÓN DE ENTRADA (esperando 'usuario' y 'contraseña' con 'ñ')
if (!isset($data['usuario']) || !isset($data['contraseña'])) { 
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Datos de login incompletos."]);
    exit();
}

$user = mysqli_real_escape_string($conexionBD, $data['usuario'] ?? ''); 
$pass = $data['contraseña'] ?? ''; 

// 4. CONSULTA: Seleccionar la columna 'contraseña' para la comparación
$sql = "SELECT contraseña FROM usuarios WHERE usuario = '$user' LIMIT 1";

$resultado = mysqli_query($conexionBD, $sql);

if ($resultado && mysqli_num_rows($resultado) == 1) {
    $row = mysqli_fetch_assoc($resultado);
    
    // 5. OBTENER VALOR: De la columna 'contraseña'
    $stored_hash = $row['contraseña']; 

    // 6. HASHING y COMPARACIÓN
    $input_hash = hash('sha256', $pass); 

    if ($input_hash === $stored_hash) {
        // AUTENTICACIÓN EXITOSA
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Acceso concedido"]);
    } else {
        // CONTRASEÑA INCORRECTA
        http_response_code(401);
        echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrectos."]);
    }
} else {
    // USUARIO NO ENCONTRADO
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrectos."]);
}

mysqli_close($conexionBD);
