<?php
/*
Estructura de la tabla productos:
Field: prod_id - Type: int(6)
Field: prod_name - Type: varchar(255)
Field: prod_description - Type: text
Field: prod_imgPath - Type: varchar(255)
Field: prod_stock - Type: int(11)
Field: prod_precio - Type: float
Field: prod_descuento - Type: float
*/
class dataBase {

  private $connexion;
  private $host;
  private $user;
  private $pass;
  private $db;
  private $config;

  public function __construct($credentials, $config) {
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

  /*
  █▀▄ █▀▄ █▀█ █▀▄ █ █ █▀ ▀█▀ █▀█ █▀
  █▀  █▀▄ █▄█ █▄▀ █▄█ █▄  █  █▄█ ▄█
  */
  public function altaProducto($categoria, $prod_name, $prod_description, $prod_img, $prod_stock, $prod_precio, $prod_descuento) {
    // verificar que existen parámetros
    if ($categoria == null || $prod_name == null || $prod_description || $prod_img == null || $prod_stock == null || $prod_precio == null || $prod_descuento == null) {
      return false;
    }
    // Guardar la imagen en la carpeta correspondiente
    $target_dir = $this->config['P_products'];
    //pendiende
    //pendiende
    //pendiende
    //pendiende
    //pendiende
    //pendiende

    // PREPARAR LA SENTENCIA PARA EVITAR <--INYECCIÓN SQL-->
    //Da de alta al producto con los datos recibidos
    $sql = "INSERT INTO productos (categoria, pord_name, prod_description, prod_imgPath, prod_stock, prod_precio, prod_descuento) 
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $this->connexion->prepare($sql);

    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("sds", $categoria, $prod_name, $prod_description, $prod_imgPath, $prod_stock, $prod_precio, $prod_descuento);

    // Ejecutar la sentencia
    $stmt->execute();

    //cerrar la sentencia
    $stmt->close();

    // Devuelve el número de filas afectadas por la última consulta
    $afected_rows = $stmt->affected_rows;
    return $afected_rows > 0 ? true : false;
  }

  public function bajaProducto($id) {
    // verificar que existen parámetros
    if ($id == null) {
      return false;
    }

    // PREPARAR LA SENTENCIA PARA EVITAR <--INYECCIÓN SQL-->
    //Da de baja al producto con el id recibido
    $sql = "DELETE FROM productos WHERE id = ?";

    $stmt = $this->connexion->prepare($sql);

    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("i", $id);

    // Ejecutar la sentencia
    $stmt->execute();

    //cerrar la sentencia
    $stmt->close();

    // Devuelve el número de filas afectadas por la última consulta
    $afected_rows = $stmt->affected_rows;
    return $afected_rows > 0 ? true : false;
  }

  public function modifyProduct($id, $categoria, $prod_name, $prod_description, $prod_imgPath, $prod_stock, $prod_precio, $prod_descuento) {
    // verificar que id no sea nulo
    if ($id == null) {
      return false;
    }
    // Obtener los datos del producto
    $result = $this->getProduct($id);
    $producto = json_decode($result, true);

    // Guardar la imagen en la carpeta correspondiente
    $target_dir = $this->config['P_products'];
    //pendiende
    //pendiende
    //pendiende
    //pendiende
    //pendiende
    //pendiende

    // Verificar si se encontró el producto
    if ($producto) {
      $categoria = $categoria == null ? $producto['categoria'] : $categoria;
      $prod_name = $prod_name == null ? $producto['pord_name'] : $prod_name;
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
    $sql = "UPDATE productos SET categoria = ?, pord_name = ?, prod_description = ?, prod_imgPath = ?, prod_stock = ?, prod_precio = ?, prod_descuento = ? WHERE id = ?";
    $stmt = $this->connexion->prepare($sql);
    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("sds", $categoria, $prod_name, $prod_description, $prod_imgPath, $prod_stock, $prod_precio, $prod_descuento, $id);
    // Ejecutar la sentencia
    $stmt->execute();
    //cerrar la sentencia
    $stmt->close();
    // Devuelve el número de filas afectadas por la última consulta
    $afected_rows = $stmt->affected_rows;
    return $afected_rows > 0 ? true : false;
  }

  public function getProduct($id) {
    // verificar que existen parámetros
    if ($id == null) {
      return false;
    }
    //Devuelve el producto con el id recibido
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    //crear un array asociativo
    $result = $stmt->get_result();
    $json = json_encode($result->fetch_assoc());
    return $json;
  }

  public function getAllProducts() {
    //Devuelve todos los productos
    $sql = "SELECT * FROM productos";
    $stmt = $this->connexion->prepare($sql);
    $stmt->execute();
    //crear un array asociativo
    $result = $stmt->get_result();
    $json = json_encode($result->fetch_all(MYSQLI_ASSOC));
    return $json;
  }

  public function queryProducts($categoria, $price_min, $price_max, $stock_min, $stock_max, $discount_min, $discount_max) {
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
    $json = json_encode($result->fetch_all(MYSQLI_ASSOC));
    return $json;
  }
}
