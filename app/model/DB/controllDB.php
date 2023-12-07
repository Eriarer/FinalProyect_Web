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
class dataBase {
  private $connexion;
  private $host;
  private $user;
  private $pass;
  private $db;
  private $config;

  //En PHP solo se permite un constructor por clase
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

  public function __destruct() {
    $this->connexion->close();
  }
  /*
  █▀▀ ▄▀▄ █▀ ▀█▀ █ █ █▀▄ ▄▀▄ █▀
  █▀  █▀█ █▄  █  █▄█ █▀▄ █▀█ ▄█
  */
  public function altaFactura($email, $productos, $fecha, $iva, $gastos_envio) {
    // Verificar que existen parámetros
    if ($email == null || $productos == null || $iva == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    // conseguir el id del usuario
    $user = $this->getUserByEmail($email);
    if ($user == null) return false;
    $user_id = $user['usr_id'];

    // el folio tiene detalles productos  en una tabla detalles_factura, la cual tiene como llave foranea
    $folio = $this->getFolio();
    // la tabla cuenta con folio_factura, usr_id, fecha_factura, iva, subtotal, gastos_envio, total
    $subtotal = 0;
    foreach ($productos as $producto) {
      $subtotal += $producto['cantidad'] * $producto['precio'];
      // agregar el producto a la tabla detalles_factura
      $this->detalles_factura($folio, $producto);
    }
    // TODO: verificar que el iva sea un numero entre 0 y 100
    $total = $subtotal * (1 + $iva / 100) + $gastos_envio;

    // la fecha debe tener formato YYYY-MM-DD, asi que hay que convertirla
    $fecha = date("Y-m-d", strtotime($fecha));
    // preparar la sentencia para evitar <--inyección sql-->
    $sql = "INSERT INTO facturas (folio_factura, usr_id, fecha_factura, iva, subtotal, gastos_envio, total) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->connexion->prepare($sql);
    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("siidddd", $folio, $user_id, $fecha, $iva, $subtotal, $gastos_envio, $total);

    $result = $stmt->execute();
    return $result;
  }

  public function getFolio() {
    //el folio se genera dependiendo del ultimo folio agregado a la base de datos
    // este folio es un string el cual va incrementando 1 en 1
    // empieza en 000000 y termina en ZZZZZZ
    // ejemplo: 000000, 000001 ... 000009, 00000A ... 00000Z, 000010
    $sql = "SELECT folio FROM facturas ORDER BY folio DESC";
    $result = $this->connexion->query($sql);
    $last = $result->fetch_assoc();
    if ($last == null) {
      return "000000";
    } else {
      $last = $last['folio'];
    }
    // incrementar el folio
    $last = base_convert($last, 36, 10);
    $last++;
    $last = base_convert($last, 10, 36);
    // retornar el folio
    return $last;
  }

  // el producto es un vector con una lista de vectores que contienen los datos
  public function detalles_factura($folio, $productos) {
    if ($folio == null || $productos == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }
    $prod_id = $productos['prod_id'];
    $cantidad = $productos['cantidad'];
    $precio = $productos['precio'];
    $descuento = $productos['descuento'];

    // la tabla detalles facctura contiene:
    // folio_factura, prod_id, cantidad, precio, descuento
    // preparar la sentencia para evitar <--inyección sql-->
    $sql = "INSERT INTO detalles_factura (folio_factura, prod_id, cantidad, precio, descuento) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->connexion->prepare($sql);
    // Vincular parámetros a la sentencia preparada como cadenas
    $stmt->bind_param("iiiii", $folio, $prod_id, $cantidad, $precio, $descuento);

    $result = $stmt->execute();

    return $result;
  }

  /*
  █▀▄ █▀▄ █▀█ █▀▄ █ █ █▀ ▀█▀ █▀█ █▀
  █▀  █▀▄ █▄█ █▄▀ █▄█ █▄  █  █▄█ ▄█
  */
  public function altaProducto($categoria, $prod_name, $prod_description, $prod_imgPath, $prod_stock, $prod_precio, $prod_descuento) {
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


    return $affected_rows > 0;
  }

  public function bajaProducto($id) {
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

  public function modifyProduct($id, $categoria, $prod_name, $prod_description, $prod_imgPath, $prod_stock, $prod_precio, $prod_descuento) {
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

  public function getProduct($id) {
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

    $json = $result->fetch_all(MYSQLI_ASSOC);
    $json = json_encode($json);
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

  public function getLastProductId() {
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

  public function altaUsuario($usr_email, $usr_name, $usr_account, $usr_pwd, $usr_admin, $pregunta, $respuesta) {
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

    // Obtener el id de usuario recien creado
    $usr_id = $this->getLasUsrId();
    if ($usr_id == 0) {
      return false;
    }

    // Crear la pregunta de seguridad
    return $this->altaPreguntaSeguridad($usr_id, $pregunta, $respuesta);
  }

  public function altaPreguntaSeguridad($user_id, $pregunta, $respuesta) {
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
    return $affected_rows > 0;
  }

  public function getLasUsrId() {
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

  public function emailExist($email) {
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

    return $result->num_rows > 0;
  }

  public function getUserByEmail($email) {
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

    return $result->fetch_assoc();
  }

  public function login($email, $password) {
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
      if ($user['usr_attempt'] >= 3) {
        return 1; // bloquear usuario
      } else {
        return 2; // contraseña incorrecta
      }
    }
  }

  public function unblock($email) {
    // Verificar que existen parámetros
    if ($email == null) {
      throw new Exception("Todos los campos son obligatorios.");
    }

    //resetear el contador de intentos fallidos
    $sql = "UPDATE usuarios SET usr_attempt = 0 WHERE usr_email = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $result = $stmt->execute();
    return $result;
  }

  public function getSecurityQuestion($email) {
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
    $json = json_encode($result->fetch_assoc());
    return $json;
  }

  public function verifySecurityAnswer($email, $respuesta) {
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
    $result = $result->fetch_assoc();
    if ($result['respuesta'] == $respuesta) {
      return true;
    } else {
      return false;
    }
  }

  public function updatePassword($email, $password) {
    if ($email == null || $password == null) {
      return false;
    }
    //Actualizar la contraseña del usuario
    $sql = "UPDATE usuarios SET usr_pwd = ? WHERE usr_email = ?";
    $stmt = $this->connexion->prepare($sql);
    $stmt->bind_param("ss", $password, $email);
    $result = $stmt->execute();
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
