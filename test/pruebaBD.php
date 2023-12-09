<?php
include_once __DIR__ . '/../app/model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../app/model/routes_files.php';
include_once __DIR__ . '/../app/model/DB/controllDB.php';
// Establecer la conexión a la base de datos
$conn = new mysqli($credentials['host'], $credentials['user'], $credentials['pass'], $credentials['db']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Función para generar facturas aleatorias
function generarFacturasAleatorias($conn, $credentials, $CONFIG) {
    $usuarios = obtenerUsuariosAleatorios($conn);
    $productos = obtenerProductosAleatorios($conn);

    for ($i = 0; $i < 50; $i++) {
        $email = $usuarios[array_rand($usuarios)]['usr_email'];
        $fecha = generarFechaAleatoria();
        $iva = rand(5, 20); // IVA aleatorio entre 5% y 20%
        $gastosEnvio = rand(0, 50); // Gastos de envío aleatorios entre $0 y $50

        $numProductos = rand(1, 5); // Número aleatorio de productos en la factura
        $productosFactura = obtenerProductosAleatorios($conn, $numProductos);

        $factura = new dataBase($credentials, $CONFIG);
        $factura->altaFactura($email, $productosFactura, $fecha, $iva, $gastosEnvio);
    }
}

// Función para obtener usuarios aleatorios
function obtenerUsuariosAleatorios($conn) {
    $usuarios = [];
    $sql = "SELECT * FROM usuarios";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    return $usuarios;
}

// Función para obtener productos aleatorios
function obtenerProductosAleatorios($conn, $cantidad = 1) {
    $productos = [];
    $resultado = [];
    $sql = "SELECT * FROM productos ORDER BY RAND() LIMIT $cantidad";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $resultado[] = $row;
    }
    // asegurar que el vector de prodcutos tenga los siguietens cambpos
    // prod_id
    // cantidad
    // precio
    // descuento

    foreach ($resultado as $key => $value) {
        $productos[$key]['prod_id'] = $value['prod_id'];
        $productos[$key]['cantidad'] = rand(1, 5);
        $productos[$key]['precio'] = $value['prod_precio'];
        $productos[$key]['descuento'] = rand(0, 50);
    }
    return $productos;
}

// Función para generar una fecha aleatoria en diciembre de 2023
function generarFechaAleatoria() {
    $fechaInicio = strtotime('2023-12-01');
    $fechaFin = strtotime('2023-12-31');
    $fechaAleatoria = rand($fechaInicio, $fechaFin);
    // la fecha debe tener formato YYYY-MM-DD, asi que hay que convertirla
    $fechaFormateada = date('Y-m-d', $fechaAleatoria);
    //asegurar de que sea una fecha válida
    if (!strtotime($fechaFormateada)) {
        echo "Fecha inválida";
        exit;
    }
    return $fechaFormateada;
}


// Llamada a la función para generar facturas aleatorias
generarFacturasAleatorias($conn, $credentials, $CONFIG);

echo "<h1>Facturas generadas</h1>";
// Cerrar la conexión
$conn->close();
