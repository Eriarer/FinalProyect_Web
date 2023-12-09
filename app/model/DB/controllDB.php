<?php
/*
Estructura de la tabla productos:

Field	            Type	        Null	Key  Default	Extra
prod_id	          int(6)	      NO	  PRI	 auto_increment
categoria	        varchar(255)	YES			
prod_name	        varchar(255)	NO			
prod_description	text	        YES			
prod_imgPath	    varchar(255)	NO			
prod_stock	      int(11)	      NO			
prod_precio	      float	        NO			
prod_descuento	  float	        NO	
*/
class dataBase
{
  private $connexion;
  private $host;
  private $user;
  private $pass;
  private $db;
  private $config;

  //En PHP solo se permite un constructor por clase
  public function __construct($credentials, $config)
  {
    $this->host = $credentials['host'];
    $this->user = $credentials['user'];
    $this->pass = $credentials['pass'];
    $this->db = $credentials['db'];
    $this->config = $config;
    $this->connexion = new mysqli($this->host, $this->user, $this->pass, $this->db);
    if ($this->connexion->connect_error) {
      die('Error de conexión: ' . $this->connexion->connect_error);
    }
  }

  public function __destruct()
  {
    $this->connexion->close();
  }
  /*
  █▀▀ ▄▀▄ █▀ ▀█▀ █ █ █▀▄ ▄▀▄ █▀
  █▀  █▀█ █▄  █  █▄█ █▀▄ █▀█ ▄█
  */
  public function altaFactura($email, $productos, $fecha, $iva, $gastos_envio, $pais, $direccion, $metodo_pago)
  {
    // Verificar que existen parámetros
    if ($email == null || $productos == null || $iva == null || $gastos_envio == null || $pais == null || $direccion == null || $metodo_pago == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // conseguir el id del usuario
    $user = $this->getUserByEmail($email);
    if ($user == null) return false;
    $user_id = $user['usr_id'];

    // el folio tiene detalles productos  en una tabla detalles_factura, la cual tiene como llave foranea
    $folio = $this->getFolio();
    // la tabla cuenta con folio_factura, usr_id, fecha_factura, iva, subtotal, gastos_envio, total, pais, direccion, metodo_pago
    $subtotal = 0;
    $total = 0;
    foreach ($productos as $producto) {
      $subtotal += $producto['cantidad'] * $producto['precio'];
      $total += $producto['cantidad'] * ($producto['precio'] * (1 - ($producto['descuento'] / 100)));
      // agregar el producto a la tabla detalles_factura
      $this->detalles_factura($folio, $producto);
    }
    $total = ($total * (1 + ($iva / 100))) + $gastos_envio;
    if (!strtotime($fecha)) {
      //convertir la fecha a formato YYYY-MM-DD
      $fecha = date("Y-m-d", strtotime($fecha));
      if (!strtotime($fecha)) {
        throw new Exception("La fecha no tiene un formato válido.");
      }
    }
    // preparar la sentencia para evitar <--inyección sql-->
    $sql = "INSERT INTO facturas (folio_factura, usr_id, fecha_factura, iva, subtotal, gastos_envio, total, pais, direccion, metodo_pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->connexion->prepare($sql);
    // Vincular parámetros a la sentencia preparada como cadenas fecha es un tip
    $stmt->bind_param("sisddddsss", $folio, $user_id, $fecha, $iva, $subtotal, $gastos_envio, $total, $pais, $direccion, $metodo_pago);

    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function getFolio()
  {
    //el folio se genera dependiendo del ultimo folio agregado a la base de datos
    // este folio es un string el cual va incrementando 1 en 1
    // empieza en 000000 y termina en ZZZZZZ
    // ejemplo: 000000, 000001 ... 000009, 00000A ... 00000Z, 000010
    $sql = "SELECT folio_factura FROM facturas ORDER BY folio_factura DESC";
    $result = $this->connexion->query($sql);
    $last = $result->fetch_assoc();
    if ($last == null) {
      return "000000";
    } else {
      $last = $last['folio_factura'];
    }
    // incrementar el folio
    $last = base_convert($last, 36, 10);
    $last++;
    $last = base_convert($last, 10, 36);
    // agregar ceros a la izquierda
    $last = str_pad($last, 6, "0", STR_PAD_LEFT);
    // retornar el folio
    return $last;
  }

  // el producto es un vector con una lista de vectores que contienen los datos
  public function detalles_factura($folio, $productos)
  {
    if ($folio == null || $productos == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }
    $prod_id = $productos['prod_id'];
    $cantidad = $productos['cantidad'];
    $precio = $productos['precio'];
    $descuento = $productos['descuento'];
    //deshabilitar la restriccion de llave foranea
    $sql = "SET FOREIGN_KEY_CHECKS=0";
    $this->connexion->query($sql);

    // la tabla detalles facctura contiene:
    // folio_factura, prod_id, cantidad, precio, descuento
    // preparar la sentencia para evitar <--inyección sql-->
    $sql = "INSERT INTO detalles_factura (folio_factura, prod_id, cantidad, precio, descuento) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->connexion->prepare($sql);
    // Vincular parámetros a la sentencia preparada como cadenas
    // folio string, prod_id int, cantidad int, precio float, descuento float
    $stmt->bind_param("siidd", $folio, $prod_id, $cantidad, $precio, $descuento);

    $result = $stmt->execute();

    $stmt->close();
    //habilitar la restriccion de llave foranea
    $sql = "SET FOREIGN_KEY_CHECKS=1";
    $this->connexion->query($sql);
    return $result;
  }

  //retorna la factura con el folio y todos sus detalles
  public function getFactura($folio)
  {
    if ($folio == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }
    // preparar la sentencia para evitar <--inyección sql-->
    $sql = "SELECT * FROM facturas WHERE folio_factura = ?";
    $stmt = $this->connexion->prepare($sql);
    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("s", $folio);

    $result = $stmt->execute();
    if (!$result) {
      return false;
    }
    $factura = $stmt->get_result();
    $factura = $factura->fetch_assoc();

    $stmt->close();

    // conseguir los detalles de la factura
    $sql = "SELECT * FROM detalles_factura WHERE folio_factura = ?";
    $stmt = $this->connexion->prepare($sql);
    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("s", $folio);
    $result = $stmt->execute();

    if (!$result) {
      return false;
    }

    $factura['detalles'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $json = json_encode($factura);
    return $json;
  }

  // devuelve las facturas en un periodo de tiempo
  public function getFacturas($fecha_inicio, $fecha_fin)
  {
    if ($fecha_inicio == null || $fecha_fin == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }
    // la fecha debe tener formato YYYY-MM-DD, asi que hay que convertirla
    $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio));
    $fecha_fin = date("Y-m-d", strtotime($fecha_fin));
    // la fecha de inicio debe ser menor a la fecha de fin
    if ($fecha_inicio > $fecha_fin) {
      throw new Exception("La fecha de inicio debe ser menor a la fecha de fin.");
    }
    //retornar las facturas de forma ordenada de la mas antigua a la mas reciente
    // preparar la sentencia para evitar <--inyección sql-->
    $sql = "SELECT * FROM facturas WHERE fecha_factura BETWEEN ? AND ? ORDER BY fecha_factura ASC";
    $stmt = $this->connexion->prepare($sql);
    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);

    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    //generar un array asociativo
    $array = [];
    while ($row = $result->fetch_assoc()) {
      // conseguir los detalles de la factura
      $sql = "SELECT * FROM detalles_factura WHERE folio_factura = ?";
      $stmt = $this->connexion->prepare($sql);
      // Vincular parámetros a la sentencia preparada como cadenas
      $stmt->bind_param("s", $row['folio_factura']);
      $stmt->execute();
      $row['detalles'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      $array[] = $row;
    }
    $json = json_encode($array);
    return $json;
  }

  public function getLastFacturaFromEmail($email)
  {
    if ($email == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }
    // conseguir el id del usuario
    $user = $this->getUserByEmail($email);
    if ($user == null) return false;
    $user_id = $user['usr_id'];
    // preparar la sentencia para evitar <--inyección sql-->
    $sql = "SELECT * FROM facturas WHERE usr_id = ? ORDER BY fecha_factura DESC LIMIT 1";
    $stmt = $this->connexion->prepare($sql);
    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("i", $user_id);

    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $json = json_encode($result->fetch_all(MYSQLI_ASSOC));
    return $json;
  }
  /*
  █▀ ▄▀▄ █▀▄ █▀▄ █ ▀█▀ █▀█
  █▄ █▀█ █▀▄ █▀▄ █  █  █▄█
  */
  /* Función para insertar productos en la tabla de carrito del usuario. forma de la tabla:
  Carrito:
  usr_id  prod_id  cantidad
  */
  // Agregando un producto nuevo al carrito
  public function insertarCarrito($usr_id, $prod_id, $cantidad)
  {
    // Verificar que existen parámetros
    if ($usr_id == null || $prod_id == null || $cantidad == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // Preparar la sentencia para evitar la <--inyección SQL-->
    $sql = "INSERT INTO carrito (usr_id, prod_id, cantidad) 
              VALUES (?, ?, ?)";
    // Preparar la sentencia
    $stmt = $this->connexion->prepare($sql);

    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("iii", $usr_id, $prod_id, $cantidad);

    // Ejecutar la sentencia
    $stmt->execute();

    // Obtener el número de filas afectadas por la última consulta
    $affected_rows = $stmt->affected_rows;
    if ($affected_rows > 0) {
      return $this->obtenerTotalProductos($usr_id);
    } else {
      return false;
    }
  }

  // Función para eliminar un producto del carrito
  public function eliminarCarrito($usr_id, $prod_id)
  {
    // Verificar que existen parámetros
    if ($usr_id == null || $prod_id == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // Desactivar restricciones de clave externa
    $sql_disable_fk = "SET foreign_key_checks = 0";
    $this->connexion->query($sql_disable_fk);

    // Preparar la sentencia para evitar la <--inyección SQL-->
    $sql = "DELETE FROM carrito WHERE usr_id = ? AND prod_id = ?";
    $stmt = $this->connexion->prepare($sql);

    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("ii", $usr_id, $prod_id);
    // Ejecutar la sentencia
    $success = $stmt->execute();
    // Cerrar la sentencia
    $stmt->close();

    // Reactivar restricciones de clave externa
    $sql_enable_fk = "SET foreign_key_checks = 1";
    $this->connexion->query($sql_enable_fk);
    $this->connexion->close();

    if ($success) {
      return $this->obtenerTotalProductos($usr_id);
    } else {
      return false;
    }
  }

  // Función para aumentar en 1 la cantidad de un producto en el carrito
  public function aumentarCantidad($usr_id, $prod_id)
  {
    // Verificar que existen parámetros
    if ($usr_id == null || $prod_id == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }
    //Busca si el producto ya se encuentra en el carrito, si esta, aumenta la cantidad en 1, sino lo agrega al carrito
    $sql = "SELECT * FROM carrito WHERE usr_id = ? AND prod_id = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("ii", $usr_id, $prod_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    if ($producto) {
      $cantidad = $producto['cantidad'] + 1;
      // Preparar la sentencia para evitar la <--inyección SQL-->
      $sql = "UPDATE carrito SET cantidad = ? WHERE usr_id = ? AND prod_id = ?";
      $stmt = $this->connexion->prepare($sql);
      $stmt->bind_param("iii", $cantidad, $usr_id, $prod_id);
      $stmt->execute();
    } else {
      $this->insertarCarrito($usr_id, $prod_id, 1);
    }
    return $this->obtenerTotalProductos($usr_id);
  }

  // Función para disminuir en 1 la cantidad de un producto en el carrito
  public function disminuirCantidad($usr_id, $prod_id)
  {
    // Verificar que existen parámetros
    if ($usr_id == null || $prod_id == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    //Verificar que la cantidad del producto sea mayor a 1
    if ($this->obtenerTotalProductos($usr_id) > 0) {
      //Busca si el producto ya esta en el carrito, si esta, disminuye en 1
      $sql = "SELECT * FROM carrito WHERE usr_id = ? AND prod_id = ?";
      $stmt = $this->connexion->prepare($sql);
      $stmt->bind_param("ii", $usr_id, $prod_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $producto = $result->fetch_assoc();
      if ($producto) {
        $cantidad = $producto['cantidad'] - 1;
        // Preparar la sentencia para evitar la <--inyección SQL-->
        $sql = "UPDATE carrito SET cantidad = ? WHERE usr_id = ? AND prod_id = ?";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bind_param("iii", $cantidad, $usr_id, $prod_id);
        $stmt->execute();
      }
    }
    return $this->obtenerTotalProductos($usr_id);
  }

  // Función para obtener los productos del carrito con su cantidad
  public function obtenerCarrito($usr_id)
  {
    // Verificar que existen parámetros
    if ($usr_id == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    $sql = "SELECT carrito.prod_id, carrito.cantidad, productos.prod_name, productos.prod_description, productos.prod_imgPath, productos.prod_stock, productos.prod_precio, productos.prod_descuento
            FROM carrito
            INNER JOIN productos ON carrito.prod_id = productos.prod_id
            WHERE carrito.usr_id = ? GROUP BY carrito.prod_id";

    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("i", $usr_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $json = json_encode($result->fetch_all(MYSQLI_ASSOC));
    return $json;
  }

  public function updateCantidad($cantidad, $prod_id, $usr_id)
  {
    // Verificar que existen parámetros
    if ($usr_id == null || $prod_id == null || $cantidad == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // Preparar la sentencia para evitar la <--inyección SQL-->
    $sql = "UPDATE carrito SET cantidad = ? WHERE usr_id = ? AND prod_id = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("iii", $cantidad, $usr_id, $prod_id);
    $stmt->execute();
    $stmt->close();
    return $this->obtenerTotalProductos($usr_id);
  }

  //función para obtener el stock de un producto
  public function getStock($prod_id)
  {
    // Verificar que existen parámetros
    if ($prod_id == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // Preparar la sentencia para evitar la <--inyección SQL-->
    $sql = "SELECT prod_stock FROM productos WHERE prod_id = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("i", $prod_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    //guardando el resultado como número
    $result = $result->fetch_assoc();
    $result = $result['prod_stock'];
    return $result;
  }

  //Obtener el total de productos en el carrito
  public function obtenerTotalProductos($usr_id)
  {
    // Verificar que existen parámetros
    if ($usr_id == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // Preparar la sentencia para evitar la <--inyección SQL-->
    $sql = "SELECT SUM(cantidad) FROM carrito WHERE usr_id = ?";
    // Preparar la sentencia
    $stmt = $this->connexion->prepare($sql);

    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("i", $usr_id);

    // Ejecutar la sentencia
    $stmt->execute();

    // Obtener el número de filas afectadas por la última consulta
    $result = $stmt->get_result();
    $result = ($result->fetch_assoc());
    //obtener solo el número
    $result = $result['SUM(cantidad)'];
    return $result;
  }

  /*
  █▀▄ █▀▄ █▀█ █▀▄ █ █ █▀ ▀█▀ █▀█ █▀
  █▀  █▀▄ █▄█ █▄▀ █▄█ █▄  █  █▄█ ▄█
  */
  public function altaProducto($categoria, $prod_name, $prod_description, $prod_imgPath, $prod_stock, $prod_precio, $prod_descuento)
  {
    // Verificar que existen parámetros
    if ($categoria == null || $prod_name == null || $prod_description == null || $prod_imgPath == null || $prod_stock == null || $prod_precio == null || $prod_descuento == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // Preparar la sentencia para evitar la inyección SQL
    $sql = "INSERT INTO productos (categoria, prod_name, prod_description, prod_imgPath, prod_stock, prod_precio, prod_descuento) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    // Preparar la sentencia
    $stmt = $this->connexion->prepare($sql);

    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("ssssiii", $categoria, $prod_name, $prod_description, $prod_imgPath, $prod_stock, $prod_precio, $prod_descuento);

    // Ejecutar la sentencia
    $stmt->execute();

    // Obtener el número de filas afectadas por la última consulta
    $affected_rows = $stmt->affected_rows;

    $stmt->close();

    return $affected_rows > 0;
  }

  public function bajaProducto($id)
  {
    // verificar que existen parámetros
    if ($id == null) {
      return false;
    }
    // conseguir la ruta de la imagen
    $sql = "SELECT prod_imgPath FROM productos WHERE prod_id = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    // eliminar la imagen del servidor
    $result = $stmt->get_result();
    $imgPath = $result->fetch_assoc();
    $imgPath = $imgPath['prod_imgPath'];
    // verificar que la imagen existe
    if (file_exists($imgPath)) {
      unlink($imgPath); // eliminar la imagen
    }

    // PREPARAR LA SENTENCIA PARA EVITAR <--INYECCIÓN SQL-->
    //Da de baja al producto con el id recibido
    $sql = "DELETE FROM productos WHERE prod_id = ?";

    $stmt = $this->connexion->prepare($sql);

    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("i", $id);

    // Ejecutar la sentencia
    $success = $stmt->execute();

    // Cerrar la sentencia
    $stmt->close();

    return $success;
  }

  public function modifyProduct($id, $categoria, $prod_name, $prod_description, $prod_imgPath, $prod_stock, $prod_precio, $prod_descuento)
  {
    // verificar que id no sea nulo
    if ($id == null) {
      return false;
    }
    // Obtener los datos del producto
    $result = $this->getProduct($id);
    $producto = json_decode($result, true);

    // Verificar si se encontró el producto
    if ($producto) {
      $categoria = $categoria == null ? $producto['categoria'] : $categoria;
      $prod_name = $prod_name == null ? $producto['prod_name'] : $prod_name;
      $prod_description = $prod_description == null ? $producto['prod_description'] : $prod_description;
      $prod_imgPath = $prod_imgPath == null ? $producto['prod_imgPath'] : $prod_imgPath;
      $prod_stock = $prod_stock == null ? $producto['prod_stock'] : $prod_stock;
      $prod_precio = $prod_precio == null ? $producto['prod_precio'] : $prod_precio;
      $prod_descuento = $prod_descuento == null ? $producto['prod_descuento'] : $prod_descuento;
    } else {
      return false;
    }

    // PREPARAR LA SENTENCIA PARA EVITAR <--INYECCIÓN SQL-->
    //Modifica el producto con los datos recibidos
    $sql = "UPDATE productos SET categoria = ?, prod_name = ?, prod_description = ?, prod_imgPath = ?, prod_stock = ?, prod_precio = ?, prod_descuento = ? WHERE prod_id = ?";
    $stmt = $this->connexion->prepare($sql);
    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("ssssiiii", $categoria, $prod_name, $prod_description, $prod_imgPath, $prod_stock, $prod_precio, $prod_descuento, $id);
    // Ejecutar la sentencia
    $result = $stmt->execute();

    // Cerrar la sentencia
    $stmt->close();

    return $result;
  }

  public function getProduct($id)
  {
    // verificar que existen parámetros
    if ($id == null) {
      return false;
    }
    //Devuelve el producto con el id recibido
    $sql = "SELECT * FROM productos WHERE prod_id = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    //crear un array asociativo
    $result = $stmt->get_result();

    $stmt->close();
    $json = json_encode($result->fetch_assoc());
    return $json;
  }

  public function getAllProducts()
  {
    //Devuelve todos los productos
    $sql = "SELECT * FROM productos";
    $stmt = $this->connexion->prepare($sql);
    $stmt->execute();
    //crear un array asociativo
    $result = $stmt->get_result();

    $json = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $json = json_encode($json);
    return $json;
  }

  public function queryProducts($categoria, $price_min, $price_max, $stock_min, $stock_max, $discount_min, $discount_max)
  {
    // Los parametros son opcionales, si todos son null, devuelve todos los productos
    if ($categoria == null && $price_min == null && $price_max == null && $stock_min == null && $stock_max == null && $discount_min == null && $discount_max == null) {
      return $this->getAllProducts();
    }

    // preparar la sentencia para evitar <--inyección sql-->
    //Devuelve los productos que cumplan con los parámetros recibidos
    $sql = "SELECT * FROM productos WHERE ";
    $sql .= $categoria == null ? "" : "categoria = ? AND ";
    $sql .= $price_min == null ? "" : "prod_precio >= ? AND ";
    $sql .= $price_max == null ? "" : "prod_precio <= ? AND ";
    $sql .= $stock_min == null ? "" : "prod_stock >= ? AND ";
    $sql .= $stock_max == null ? "" : "prod_stock <= ? AND ";
    $sql .= $discount_min == null ? "" : "prod_descuento >= ? AND ";
    $sql .= $discount_max == null ? "" : "prod_descuento <= ? AND ";
    $sql = substr($sql, 0, -4); // Elimina el último AND
    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("sds", $categoria, $price_min, $price_max, $stock_min, $stock_max, $discount_min, $discount_max);
    // Ejecutar la sentencia
    $stmt->execute();
    //crear un array asociativo
    $result = $stmt->get_result();

    $stmt->close();
    $json = json_encode($result->fetch_all(MYSQLI_ASSOC));
    return $json;
  }

  public function getLastProductId()
  {
    $sql = "SELECT MAX(prod_id) AS last_id FROM productos";
    $result = $this->connexion->query($sql);

    if ($result) {
      $last = $result->fetch_assoc();
      return $last['last_id'];
    } else {
      // Manejar el error si la consulta no es exitosa
      return null;
    }
  }

  /*
  █ █ █▀ █ █ ▄▀▄ █▀▄ ▀█▀ █▀█ █▀
  █▄█ ▄█ █▄█ █▀█ █▀▄ ▄█▄ █▄█ ▄█
  */

  public function altaUsuario($usr_email, $usr_name, $usr_account, $usr_pwd, $usr_admin, $pregunta, $respuesta)
  {
    // Verificar que existen parámetros
    $usr_admin = 0;
    if ($usr_email == null || $usr_name == null || $usr_account == null || $usr_pwd == null || $usr_admin === null || $pregunta == null || $respuesta == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // Preparar la sentencia para evitar la <--inyección SQL-->
    $sql = "INSERT INTO usuarios (usr_email, usr_name, usr_account, usr_pwd, usr_admin) 
              VALUES (?, ?, ?, ?, ?)";
    // Preparar la sentencia
    $stmt = $this->connexion->prepare($sql);

    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("ssssi", $usr_email, $usr_name, $usr_account, $usr_pwd, $usr_admin);

    // Ejecutar la sentencia
    $stmt->execute();

    $stmt->close();

    // Obtener el id de usuario recien creado
    $usr_id = $this->getLasUsrId();
    if ($usr_id == 0) {
      return false;
    }

    // Crear la pregunta de seguridad
    return $this->altaPreguntaSeguridad($usr_id, $pregunta, $respuesta);
  }

  public function altaPreguntaSeguridad($user_id, $pregunta, $respuesta)
  {
    // Verificar que existen parámetros
    if ($user_id == null || $pregunta == null || $respuesta == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // Preparar la sentencia para evitar la <--inyección SQL-->
    $sql = "INSERT INTO preguntas_seguridad (usr_id, pregunta, respuesta) 
              VALUES (?, ?, ?)";
    // Preparar la sentencia
    $stmt = $this->connexion->prepare($sql);

    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("iss", $user_id, $pregunta, $respuesta);

    // Ejecutar la sentencia
    $stmt->execute();

    // Obtener el número de filas afectadas por la última consulta
    $affected_rows = $stmt->affected_rows;

    $stmt->close();
    return $affected_rows > 0;
  }

  public function getLasUsrId()
  {
    //Devuelve el id del último usuario creado
    $sql = "SELECT usr_id FROM usuarios ORDER BY usr_id DESC";
    $result = $this->connexion->query($sql);
    $last = $result->fetch_assoc();
    if ($last == null) {
      return 0;
    } else {
      $last = $last['usr_id'];
    }
    // retornar el id
    return $last;
  }

  public function getID($email)
  {
    //Devuelve el id del usuario con el email recibido
    $sql = "SELECT usr_id FROM usuarios WHERE usr_email = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $id = $result->fetch_assoc();
    return $id['usr_id'];
  }

  public function emailExist($email)
  {
    // Verificar que existen parámetros
    if ($email == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // Preparar la sentencia para evitar la <--inyección SQL-->
    $sql = "SELECT usr_email FROM usuarios WHERE usr_email = ?";
    // Preparar la sentencia
    $stmt = $this->connexion->prepare($sql);

    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("s", $email);

    // Ejecutar la sentencia
    $stmt->execute();

    // Obtener el número de filas afectadas por la última consulta
    $result = $stmt->get_result();
    $stmt->close();
    return $result->num_rows > 0;
  }

  public function getUserByEmail($email)
  {
    // Verificar que existen parámetros
    if ($email == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // Preparar la sentencia para evitar la <--inyección SQL-->
    $sql = "SELECT * FROM usuarios WHERE usr_email = ?";
    // Preparar la sentencia
    $stmt = $this->connexion->prepare($sql);

    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("s", $email);

    // Ejecutar la sentencia
    $stmt->execute();

    // Obtener el número de filas afectadas por la última consulta
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
  }

  public function login($email, $password)
  {
    // Verificar que existen parámetros
    if ($email == null || $password == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    //obtener el usuario con el email recibido
    $user = $this->getUserByEmail($email);
    if ($user == null) {
      return 2;
    }

    //comparar que la contraseña encriptada por BCRYPT sea igual a la contraseña recibida
    if (password_verify($password, $user['usr_pwd']) || $password == $user['usr_pwd']) {
      //verificar que el usuario tenga menos de 3 intentos fallidos
      if ($user['usr_attempt'] < 3) {
        //resetear el contador de intentos fallidos
        $sql = "UPDATE usuarios SET usr_attempt = 0 WHERE usr_id = ?";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bind_param("i", $user['usr_id']);
        return 0; // login exitoso
      } else {
        return 1; // usuario bloqueado
      }
    } else {
      //incrementar el contador de intentos fallidos
      if ($user['usr_attempt'] >= 3) {
        return 1; // usuario bloqueado
      }
      $attempt = $user['usr_attempt'] + 1;
      $sql = "UPDATE usuarios SET usr_attempt = ? WHERE usr_id = ?";
      $stmt = $this->connexion->prepare($sql);
      $stmt->bind_param("ii", $attempt, $user['usr_id']);
      $stmt->execute();

      //obtener el usuario
      $user = $this->getUserByEmail($email);
      $stmt->close();
      if ($user['usr_attempt'] >= 3) {
        return 1; // bloquear usuario
      } else {
        return 2; // contraseña incorrecta
      }
    }
  }

  public function unblock($email)
  {
    // Verificar que existen parámetros
    if ($email == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    //resetear el contador de intentos fallidos
    $sql = "UPDATE usuarios SET usr_attempt = 0 WHERE usr_email = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function getSecurityQuestion($email)
  {
    if ($email == null) {
      return false;
    }
    $result = $this->getUserByEmail($email);
    if ($result == null) {
      return "error";
    }
    $user_id = $result['usr_id'];
    //Obtener la pregunta de seguridad de la tabla de preguntas_seguridad
    $sql = "SELECT pregunta FROM preguntas_seguridad WHERE usr_id = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $json = json_encode($result->fetch_assoc());
    return $json;
  }

  public function verifySecurityAnswer($email, $respuesta)
  {
    if ($email == null || $respuesta == null) {
      return false;
    }
    $result = $this->getUserByEmail($email);
    if ($result == null) {
      return false;
    }
    $user_id = $result['usr_id'];
    //Obtener la respuesta de seguridad de la tabla de preguntas_seguridad
    $sql = "SELECT respuesta FROM preguntas_seguridad WHERE usr_id = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $result = $result->fetch_assoc();
    if ($result['respuesta'] == $respuesta) {
      return true;
    } else {
      return false;
    }
  }

  public function updatePassword($email, $password)
  {
    if ($email == null || $password == null) {
      return false;
    }
    //Actualizar la contraseña del usuario
    $sql = "UPDATE usuarios SET usr_pwd = ? WHERE usr_email = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("ss", $password, $email);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function validAdmin($correo) //Para verificar que el usuario sea un administrador
  {
    if (isset($correo)) {
      $user = $this->getUserByEmail($correo);
      if ($user['usr_admin'] == 1) {
        return true;
      }
    }
    return false;
  }
}
