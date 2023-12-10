<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pedido</title>
    <link rel="stylesheet" href="../css/FormularioPago.css">
</head>

<body>
    <a href="../../../index.php">
        <img src="../../media/images/LogoSF.png" id="imgLogo">
    </a>
    <div class="form-container">
        <h2>¿Dónde quieres que se envíe tu pedido?</h2>
        <form action="Ticket.php" method="post">
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
                <option value="Mexico">México</option>
                <option value="Estados Unidos">Estados Unidos</option>
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

            <input type="submit" value="Enviar Pedido" class="submit-btn">
        </form>
    </div>
</body>

</html>