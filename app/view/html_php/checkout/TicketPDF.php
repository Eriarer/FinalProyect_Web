<?php
include_once __DIR__ . '/../../../model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../../model/DB/routes_files.php';
include_once __DIR__ . '/../../../model/DB/controllDB.php';
$db = new dataBase($credentials, $CONFIG);
$folio = '';
$result = [];
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado un valor para el campo de correo electrónico
    if (isset($_POST["folio"])) {
        $folio = $_POST["folio"];

        $db = new dataBase($credentials, $CONFIG);

        $result = $db->getFactura($folio);

        $result = json_decode($result, true);
    } else {
        // cerrar la pagina
        echo "<script>window.close();</script>";
        return;
    }
} else {
    echo "<script>window.close();</script>";
    return;
}

// echo $result['folio_factura'];
// echo $result['fecha_factura'];
// echo $result['iva'];
// echo $result['subtotal'];
// echo $result['gastos_envio'];
// echo $result['total'];
// echo $result['pais'];
// echo $result['direccion'];
// echo $result['metodo_pago'];

// foreach ($result['detalles'] as $producto) {
//     echo $producto['prod_id'];
//     echo $producto['prod_name'];
//     echo $producto['cantidad'];
//     echo $producto['precio'];
//     echo $producto['descuento'];
//     echo  $producto['categoria'];
//     echo $producto['prod_imgPath'];
// }

require('../../lib/fpdf186/fpdf.php'); // Asegurate de que esta ruta sea correcta
class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../../../media/images/LogoSF.png', 180, 5, 20);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(80);
        $this->Cell(30, 10, 'Fluffy Hugs Factura', 0, 0, 'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    function facturaContent($nombreUsuario, $correoUsuario, $direccion, $telefono, $folioFactura, $fechaFactura, $metodoPago, $productos, $subtotal, $gastoEnvio, $totalIva, $total)
    {
        //convertir todos los caracteres a ISO-8859-1 para que se muestren los caracteres especiales
        $nombreUsuario = mb_convert_encoding($nombreUsuario, 'ISO-8859-1', 'UTF-8');
        $correoUsuario = mb_convert_encoding($correoUsuario, 'ISO-8859-1', 'UTF-8');
        $direccion = mb_convert_encoding($direccion, 'ISO-8859-1', 'UTF-8');
        $metodoPago = mb_convert_encoding($metodoPago, 'ISO-8859-1', 'UTF-8');
        $fechaFactura = mb_convert_encoding($fechaFactura, 'ISO-8859-1', 'UTF-8');
        $folioFactura = mb_convert_encoding($folioFactura, 'ISO-8859-1', 'UTF-8');
        $telefono = mb_convert_encoding($telefono, 'ISO-8859-1', 'UTF-8');

        // Establecer el fondo del certificado
        $this->SetFont('Arial', '', 12);

        $this->Cell(0, 10, 'Folio Factura: ' . $folioFactura, 0, 1);
        $this->Cell(0, 10, 'Nombre: ' . $nombreUsuario, 0, 1);
        $this->Cell(0, 10, 'Correo: ' . $correoUsuario, 0, 1);
        $this->Cell(0, 10, 'Telefono: ' . $telefono, 0, 1);
        $this->Cell(0, 10, 'Fecha: ' . $fechaFactura, 0, 1);
        // Hay direcciones que son muy largas y se desbordan, si el tamaño es mayor a 100 caracteres, se divide en dos lineas
        if (strlen($direccion) > 80) {
            // Encuentra la última posición de un espacio dentro de la longitud máxima permitida
            $lastSpacePos = strrpos(substr($direccion, 0, 80), ' ');

            // Dividir la cadena en dos partes en el último espacio encontrado
            if ($lastSpacePos !== false) {
                $direccion1 = substr($direccion, 0, $lastSpacePos);
                $direccion2 = substr($direccion, $lastSpacePos + 1, strlen($direccion));
                $this->Cell(0, 10, 'Direccion: ' . $direccion1, 0, 1);
                $this->Cell(0, 0, $direccion2, 0, 1);
            } else {
                // Si no se encuentra un espacio, simplemente corta en la posición 80
                $direccion1 = substr($direccion, 0, 80);
                $direccion2 = substr($direccion, 80, strlen($direccion));
                $this->Cell(0, 10, 'Direccion: ' . $direccion1, 0, 1);
                $this->Cell(0, 0, $direccion2, 0, 1);
            }
        } else {
            $this->Cell(0, 10, 'Direccion: ' . $direccion, 0, 1);
        }
        $this->Ln(10);
        $this->Cell(0, 10, 'Detalles de la compra', 0, 1);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(95, 10, 'Producto', 1);
        $this->Cell(22, 10, 'Cantidad', 1);
        $this->Cell(35, 10, 'Precio Unitario', 1);
        $this->Cell(35, 10, 'Importe', 1);
        $this->Ln();

        foreach ($productos as $producto) {
            // convertir el nombre del producto a ISO-8859-1 para que se muestren los caracteres especiales
            $producto['prod_name'] = mb_convert_encoding($producto['prod_name'], 'ISO-8859-1', 'UTF-8');
            $this->Cell(95, 10, $producto['prod_name'], 1);
            $this->Cell(22, 10, $producto['cantidad'], 1);
            $this->Cell(35, 10, '$' . number_format($producto['precio'], 2), 1);
            $this->Cell(35, 10, '$' . number_format($producto['precio'] * $producto['cantidad'], 2), 1);
            $this->Ln();
        }

        $this->Ln(10);

        $this->SetFont('Arial', '', 12);
        $this->Cell(60, 10, 'Metodo de Pago: ' . $metodoPago, 0, 1);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(60, 10, 'Subtotal', 1);
        $this->Cell(80, 10, '$' . number_format($subtotal, 2), 1);
        $this->Ln();
        $this->Cell(60, 10, 'Gasto de Envio', 1);
        $this->Cell(80, 10, '$' . number_format($gastoEnvio, 2), 1);
        $this->Ln();
        $this->Cell(60, 10, 'IVA', 1);
        $this->Cell(80, 10, '$' . number_format($totalIva, 2), 1);
        $this->Ln();
        $this->Cell(60, 10, 'Total', 1);
        $this->Cell(80, 10, '$' . number_format($total, 2), 1);
        $this->Ln();
    }

    // Funcion para añadir una linea punteada
    function SetDottedLine($x1, $y1, $x2, $y2, $width = 1, $nb = 50)
    {
        $this->SetLineWidth($width);
        $longitud = sqrt(($x2 - $x1) * ($x2 - $x1) + ($y2 - $y1) * ($y2 - $y1));
        $punto = $longitud / $nb;
        $px = ($x2 - $x1) / $longitud * $punto;
        $py = ($y2 - $y1) / $longitud * $punto;
        for ($i = 0; $i < $nb; $i++) {
            if ($i % 2 === 0) {
                $this->Line($x1 + $px * $i, $y1 + $py * $i, $x1 + $px * ($i + 1), $y1 + $py * ($i + 1));
            }
        }
    }

    function AddInvoiceContent($data)
    {
        // Agregar el logo
        $this->Image('../../../media/images/LogoSF.png', 10, 10, 20);
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 10, 'Fluffy Hugs Factura', 0, 1, 'C');

        // Agregar el resto del contenido de la factura aqui

        // Ejemplo: Agregar el nombre y la direccion del cliente
        $this->SetFont('Arial', '', 12);
        // Resto de los detalles...
    }

    function agregarTexto($pdf, $text, $tamano = 15, $alineacion = 'J', $estilo = '', $fuente = 'times')
    {
        $text = mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8'); //Para admitir caracteres especiales como "ñ" y acentos
        $pdf->SetFont($fuente, $estilo, $tamano);
        $pdf->MultiCell(0, 10, $text, 0, $alineacion);
        $pdf->SetFont($fuente, '', 12); // Restaura la fuente a su valor predeterminado
        $pdf->SetXY(30, 50);
    }
}

// Crear instancia de PDF
$pdf = new PDF();
$pdf->AddPage();

// Obtener los parámetros de la URL
// $nombreUsuario = $_GET['nombre'];
// $correoUsuario = $_GET['email'];
// $direccion = $_GET['direccion'];
// $metodoPago = $_GET['metodoPago'];
// $telefono = $_GET['telefono'];

// Datos de la factura 
// $folioFactura = "123456";
// $fechaFactura = date("Y-m-d");

// Lista de productos comprados (normalmente seria obtenida de una base de datos)
$productos = [
    ['nombre' => 'Producto 1', 'precio' => 200.00, 'cantidad' => 2],
    ['nombre' => 'Producto 2', 'precio' => 150.00, 'cantidad' => 1],
    ['nombre' => 'Producto 3', 'precio' => 300.00, 'cantidad' => 1]
];

// Calcular subtotal, IVA y total
$subtotal = array_sum(array_map(function ($producto) {
    return $producto['precio'] * $producto['cantidad'];
}, $productos));

$iva = 0.16;
$totalIva = $subtotal * $iva;
$gastoEnvio = 50.00;
$total = $subtotal + $totalIva + $gastoEnvio;

// Agregar contenido al PDF
$pdf->facturaContent($result["nombre"], $result["correo"], $result['direccion'], $result["telefono"], $result['folio_factura'], $result['fecha_factura'], $result['metodo_pago'], $result['detalles'], $result['subtotal'], $result['gastos_envio'], $result['iva'], $result['total']);

// $pdf->AddInvoiceContent($data);

// Imprimir la linea punteada
$pdf->SetDottedLine(10, 100, 200, 100);
$title = 'Factura_' . $folio;
$pdf->SetTitle($title);


$pdf->Output();
