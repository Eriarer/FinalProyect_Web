<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boostrap v4.6.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/contacto.css">
    <link rel="stylesheet" href="../css/main.css">
    <!-- Estilos para los icons -->
    <title>Acerca de</title>
</head>
<?php include_once("navbar.php") ?>

<body>
    <div class="container">
        <div class="card-container">
            <div class="formulario card">
                <!-- Formulario de contacto -->
                <h5>Contacto</h5>
                <p>Envianos un mensaje y te responderemos a la brevedad.</p>

                <form id="formContacto" action="" method="">
                    <div class="form-row form-group ">
                        <p><i class="nf nf-oct-person_fill p-2 "></i>Nombre</p>
                        <input type="text" class="form-control " id="exampleInputName1" required>
                    </div>
                    <div class="form-row form-group">
                        <p><i class="nf nf-md-email p-2"></i>Email</p>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                    <div class="form-row form-group">
                        <p><i class="nf nf-md-message_draw p-2"></i>Mensaje</p>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <?php include_once("footer.php") ?>
</body>

</html>