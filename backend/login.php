<?php
// Configuración inicial
header('Content-Type: application/json');

// Obtener las credenciales del cliente
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si los campos username y password están presentes
if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(["success" => false, "message" => "Credenciales incompletas"]);
    exit;
}

// Cargar los datos de usuarios y tienda
$usuarios = json_decode(file_get_contents('usuarios.json'), true);
$tienda = json_decode(file_get_contents('tienda.json'), true);

// Verificar si los datos de usuarios o tienda no son válidos
if ($usuarios === null || $tienda === null) {
    echo json_encode(["success" => false, "message" => "Error al cargar datos del servidor"]);
    exit;
}

// Validar las credenciales del usuario
$usuario_valido = null;
foreach ($usuarios as $usuario) {
    if ($usuario['username'] === $data['username'] && $usuario['password'] === $data['password']) {
        $usuario_valido = $usuario;
        break;
    }
}

// Si las credenciales son correctas, generar el token
if ($usuario_valido !== null) {
    // Generar un token único (usamos random_bytes() para generar un valor aleatorio)
    $token = bin2hex(random_bytes(16)); // Un token aleatorio de 32 caracteres hexadecimales

    
    // Responder con el token y los datos de la tienda
    echo json_encode([
        "success" => true,
        "token" => $token,
        "store" => $tienda
    ]);
    exit;
}

// Si no se encuentra un usuario válido
echo json_encode(["success" => false, "message" => "Credenciales inválidas"]);
?>
