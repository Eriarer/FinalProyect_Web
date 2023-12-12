<?php
session_start();
$lastUpdateDate = filemtime(__FILE__);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FluffyHugs | Contacto</title>
    <!-- Boostrap v4.6.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- agregando link para darle estilos a la alerta -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/contacto.css">
    <link rel="stylesheet" href="../css/main.css">
    <title>FluffyHugs | Contacto</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/formularios.css">
    <!-- favIcon -->
    <link rel="icon" type="image/x-icon" href="../../media/images/oso-de-peluche.png" />
</head>
<?php
include_once("navbar.php");
include_once __DIR__ . '/../../model/routes_files.php';
?>

<body>
    <div class="container mt-5">
        <div class="card-container">
            <div class="card-body">
                <!-- Formulario de contacto -->
                <h5 class="card-title text-center">Contacto</h5>
                <p>Envianos un mensaje y te responderemos a la brevedad.</p>

                <form id="formContacto" action="" method="">
                    <div class="form-row form-group ">
                        <div class="col">
                            <p><i class="nf nf-oct-person_fill p-2 "></i>Nombre</p>
                            <input type="text" class="form-control " id="exampleInputName1" required>
                        </div>
                        <div class="col">
                            <p><i class="nf nf-md-email p-2"></i>Email</p>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        </div>
                    </div>
                    <div class="form-row form-group">
                        <p><i class="nf nf-md-message_draw p-2"></i>Mensaje</p>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="boton ">Enviar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php include_once("footer.php") ?>
</body>

<script>
    var emailPath = "<?= $CONFIG['P_model'] ?>";
    $(document).ready(function() {
        $('#formContacto').submit(function(e) {
            var name = $('#exampleInputName1').val();
            var email = $('#exampleInputEmail1').val();
            var message = $('#exampleFormControlTextarea1').val();
            e.preventDefault();
            $.ajax({
                url: emailPath + 'mail/contacto/correoContacto.php',
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    message: message
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Mensaje enviado con éxito!',
                        text: 'Responderemos pronto a tu consulta.',
                    });
                }
            });
        });
    });
</script>

</html>