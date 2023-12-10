<?php
include_once __DIR__ . '/../app/model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../app/model/routes_files.php';
include_once __DIR__ . '/../app/model/DB/controllDB.php';

$db = new dataBase($credentials, $CONFIG);

$result = $db->getFactura('000009');

$result = json_decode($result, true);

echo '<table>';
echo '<tr>';
echo '<th>Folio</th>';
echo '<th>Fecha</th>';
echo '<th>IVA</th>';
echo '<th>Subtotal</th>';
echo '<th>Gastos de envio</th>';
echo '<th>Total</th>';
echo '<th>Pais</th>';
echo '<th>Direccion</th>';
echo '<th>Metodo de pago</th>';
echo '</tr>';
echo '<tr>';
echo '<td>' . $result['folio_factura'] . '</td>';
echo '<td>' . $result['fecha_factura'] . '</td>';
echo '<td>' . $result['iva'] . '</td>';
echo '<td>' . $result['subtotal'] . '</td>';
echo '<td>' . $result['gastos_envio'] . '</td>';
echo '<td>' . $result['total'] . '</td>';
echo '<td>' . $result['pais'] . '</td>';
echo '<td>' . $result['direccion'] . '</td>';
echo '<td>' . $result['metodo_pago'] . '</td>';
echo '</tr>';
echo '</table>';

echo '<br><br>';

echo '<table>';
echo '<tr>';
echo '<th>Producto_ID</th>';
echo '<th>Producto</th>';
echo '<th>Cantidad</th>';
echo '<th>Precio</th>';
echo '<th>Descuento</th>';
echo '<th>Categoria</th>';
echo '<th>Imagen</th>';
echo '</tr>';
foreach ($result['detalles'] as $producto) {
  echo '<tr>';
  echo '<td>' . $producto['prod_id'] . '</td>';
  echo '<td>' . $producto['prod_name'] . '</td>';
  echo '<td>' . $producto['cantidad'] . '</td>';
  echo '<td>' . $producto['precio'] . '</td>';
  echo '<td>' . $producto['descuento'] . '</td>';
  echo '<td>' . $producto['categoria'] . '</td>';
  echo '<td>' . $producto['prod_imgPath'] . '</td>';
  echo '</tr>';
}
echo '</table>';
?>

<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th,
  td {
    text-align: left;
    padding: 8px;
  }

  tr {
    background-color: #cccccc;
  }

  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
</style>