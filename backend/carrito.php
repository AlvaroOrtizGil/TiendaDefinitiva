<?php
header('Content-Type: application/json');

// Leer los datos enviados por el cliente
$data = json_decode(file_get_contents('php://input'), true);

// Validar que se recibieron los datos necesarios
if (!isset($data['token']) || !isset($data['cart'])) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}



// Cargar los datos de la tienda
$tienda = json_decode(file_get_contents('tienda.json'), true);
if (!isset($tienda['productos'])) {
    echo json_encode(["success" => false, "message" => "Error al cargar los productos de la tienda"]);
    exit;
}

// Validar los productos y precios en el carrito
$productos_validos = $tienda['productos'];
foreach ($data['cart'] as $producto_carrito) {
    $producto_encontrado = false;

    foreach ($productos_validos as $producto_servidor) {
        if ($producto_carrito['id'] == $producto_servidor['id']) {
            $producto_encontrado = true;

            // Verificar que los precios coincidan
            if ($producto_carrito['precio'] != $producto_servidor['precio']) {
                echo json_encode(["success" => false, "message" => "Precios manipulados para el producto ID: " . $producto_carrito['id']]);
                exit;
            }
        }
    }

    if (!$producto_encontrado) {
        echo json_encode(["success" => false, "message" => "Producto no válido en el carrito: ID " . $producto_carrito['id']]);
        exit;
    }
}

// Si todo es válido
echo json_encode(["success" => true, "message" => "Compra validada correctamente"]);
?>
