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

    // Cerrar la sentencia
    $stmt->close();

    return $affected_rows > 0;
  }

  public function bajaProducto($id)
  {
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

    // Devuelve el número de filas afectadas por la última consulta
    $afected_rows = $stmt->affected_rows;

    //cerrar la sentencia
    $stmt->close();

    return $afected_rows > 0 ? true : false;
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
    // Devuelve el número de filas afectadas por la última consulta
    $afected_rows = $stmt->affected_rows;
    //cerrar la sentencia
    $stmt->close();
    return $afected_rows > 0 ? true : false;
  }

  public function getProduct($id)
  {
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
    $stmt->close();
    $json = json_encode($result->fetch_all(MYSQLI_ASSOC));
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
    //Devuelve el id del último producto creado
    $sql = "SELECT prod_id FROM productos ORDER BY prod_id DESC";
    $result = $this->connexion->query($sql);
    $last = $result->fetch_assoc();
    if ($last == null) {
      return 0;
    }else{
      $last = $last['prod_id'];
    }
    // retornar el id
    return $last;
  }
}
