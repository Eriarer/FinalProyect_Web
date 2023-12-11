<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pedido</title>
    <!-- Boostrap v4.6.2 -->
    <link rel="stylesheet" 	href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 	integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"	crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous" ></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/FormularioPago.css">
</head>

<body>
    <?php require_once 'navbar.php'; ?>
    <div class="container my-4">
        <h2>¿Dónde quieres que se envíe tu pedido?</h2>
        <form action="actionFormulario.php" method="post">
            <label for="nombre-completo">Nombre completo</label>
            <input type="text" id="nombre-completo" name="nombre-completo" required>

            <label for="email">Dirección de email</label>
            <input type="email" id="email" name="email" required>

            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="ciudad">Ciudad</label>
            <input type="text" id="ciudad" name="ciudad" required>

            <label for="codigo-postal">Código postal</label>
            <input type="text" id="codigo-postal" name="codigo-postal" required>

            <label for="pais">País</label>
            <select id="pais" name="pais" required>
                <option value="">Selecciona un país</option>
                <option value="MX">México</option>
                <option value="EU">Estados Unidos</option>
            </select>

            <label for="pais">Metodo de pago</label>
            <select id="MetodoP" name="MetodoP" required>
                <option value=""></option>
                <option value="Pago en OXXO">Pago en OXXO</option>
                <option value="Pago con tarjeta">Pago con tarjeta</option>
                <option value="Deposito en banco">Deposito en banco</option>
            </select>

            <label for="telefono">Número telefónico</label>
            <input type="tel" id="telefono" name="telefono" required>

            <input type="submit" value="COMPRAR" class="submit-btn">
        </form>
    </div>
    <?php require_once 'footer.php'; ?>
</body>

</html>