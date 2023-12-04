<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/FAQsestilos.css">
  <link rel="shortcut icon" href="../../media/imagenes/oso-de-peluche.png" type="image/x-icon">
  <!-- Boostrap v4.6.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/main.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/FAQsestilos.css">
  <link rel="shortcut icon" href="../../media/imagenes/oso-de-peluche.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<?php include_once("navbar.php") ?>

<?php include_once("navbar.php") ?>

<body>
  <header class="headContact">
    <br>
    <h1 id="titulo" class="animate__animated animate__backInLeft">Bienvenidos a Nuestro Espacio de Preguntas Frecuentes <img class="imgPreguntas" src="../../media/images/mujer.png" alt="pregunta"></h1>
    <hr>
  </header>
  <div class="container">
    <div class="introduccion">
      <p>¡Hola a todos los amantes de los peluches y bienvenidos a nuestra sección de Preguntas Frecuentes! Aquí en FluffyHugs, sabemos que los peluches son más que simples juguetes; son compañeros de aventuras, recuerdos de momentos especiales, y a menudo, amigos para toda la vida. Ya seas un coleccionista apasionado, un padre buscando el peluche perfecto para su hijo, o alguien que desea saber más sobre el cuidado y mantenimiento de estos adorables compañeros, estás en el lugar correcto.</p>
    </div>

    <div class="preguntas">
      <div class="accordion accordion-flush" id="accordionFlushExample1">
        <div class="accordion-item">
          <h1 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
              1. ¿Cómo realizo una compra?
            </button>
          </h1>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample1">
            <div class="accordion-body">Puedes realizar una compra visitando nuestra tienda en línea, seleccionando los peluches que te gustan y añadiéndolos a tu carrito de compras. Luego, sigue las instrucciones para el pago y la entrega.</div>
          </div>
        </div>
        <!-- Otros acordeones del primer grupo -->

      </div>
      <div class="accordion accordion-flush" id="accordionFlushExample2">
        <div class="accordion-item">
          <h1 class="accordion-header" id="flush-headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
              2. ¿Hay una cantidad mínima de los pedidos para los envíos?
            </button>
          </h1>
          <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample2">
            <div class="accordion-body">No exigimos una cantidad mínima de pedido. Sin embargo, para pedidos superiores a cierto monto, ofrecemos envío gratuito.</div>
          </div>
        </div>
        <!-- Otros acordeones del segundo grupo -->

      </div>

      <div class="accordion accordion-flush" id="accordionFlushExample3">
        <div class="accordion-item">
          <h1 class="accordion-header" id="flush-headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
              3. ¿Cómo se realizan los envíos?
            </button>
          </h1>
          <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample3">
            <div class="accordion-body">Los envíos se realizan a través de servicios de mensajería confiables. Una vez que hagas tu pedido, te proporcionaremos un número de seguimiento para que puedas rastrear la entrega.</div>
          </div>
        </div>
        <!-- Otros acordeones del tercer grupo -->

      </div>

      <div class="accordion accordion-flush" id="accordionFlushExample4">
        <div class="accordion-item">
          <h1 class="accordion-header" id="flush-headingFour">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
              4.¿Ofrecen opciones de personalización para los peluches?
            </button>
          </h1>
          <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample4">
            <div class="accordion-body">Sí, ofrecemos opciones de personalización. Puedes elegir entre diferentes accesorios y personalizaciones, como nombres bordados o trajes especiales para tus peluches.</div>
          </div>
        </div>
        <!-- Otros acordeones del cuarto grupo -->

      </div>

      <div class="accordion accordion-flush" id="accordionFlushExample5">
        <div class="accordion-item">
          <h1 class="accordion-header" id="flush-headingFive">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
              5. ¿Qué política de devoluciones y rembolsos tienes?
            </button>
          </h1>
          <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample5">
            <div class="accordion-body">Aceptamos devoluciones dentro de los 30 días posteriores a la compra, siempre y cuando los productos estén en su estado original. Ofrecemos reembolsos completos o intercambios por otros artículos.</div>
          </div>
        </div>
        <!-- Otros acordeones del quinto grupo -->

      </div>

      <div class="accordion accordion-flush" id="accordionFlushExample6">
        <div class="accordion-item">
          <h1 class="accordion-header" id="flush-headingSix">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
              6.¿Ofrecen descuento por cantidad o para eventos especiales?
            </button>
          </h1>
          <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample6">
            <div class="accordion-body">Sí, ofrecemos descuentos por compras en grandes cantidades, ideales para eventos especiales como fiestas o celebraciones corporativas.</div>
          </div>
        </div>
        <!-- Otros acordeones del sexto grupo -->

      </div>

      <div class="accordion accordion-flush" id="accordionFlushExample7">
        <div class="accordion-item">
          <h1 class="accordion-header" id="flush-headingSeven">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
              7. Tengo un negocio, ¿cómo puedo hacer compras al mayoreo?
            </button>
          </h1>
          <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample7">
            <div class="accordion-body">Para compras al mayoreo, contáctanos directamente a través de nuestro formulario en línea o llámanos. Ofrecemos precios especiales y condiciones para compras al por mayor.</div>
          </div>
        </div>
        <!-- Otros acordeones del séptimo grupo -->

      </div>
      <!-- Acordeón 8 -->
      <div class="accordion accordion-flush" id="accordionFlushExample8">
        <div class="accordion-item">
          <h1 class="accordion-header" id="flush-headingEight">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEight" aria-expanded="false" aria-controls="flush-collapseEight">
              8.¿Cómo puedo limpiar y cuidar mis peluches?
            </button>
          </h1>
          <div id="flush-collapseEight" class="accordion-collapse collapse" aria-labelledby="flush-headingEight" data-bs-parent="#accordionFlushExample8">
            <div class="accordion-body">Recomendamos limpiar los peluches a mano con un paño suave y agua tibia. Evita el uso de blanqueadores y no los sumerjas completamente en agua. Para secarlos, usa un secador en modo frío o déjalos secar al aire.</div>
          </div>
        </div>
      </div>

      <!-- Acordeón 9 -->
      <div class="accordion accordion-flush" id="accordionFlushExample9">
        <div class="accordion-item">
          <h1 class="accordion-header" id="flush-headingNine">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseNine" aria-expanded="false" aria-controls="flush-collapseNine">
              9.¿Tienen una tienda física o solo venden el linea?
            </button>
          </h1>
          <div id="flush-collapseNine" class="accordion-collapse collapse" aria-labelledby="flush-headingNine" data-bs-parent="#accordionFlushExample9">
            <div class="accordion-body">Además de nuestra tienda en línea, tenemos una tienda física donde puedes ver y comprar nuestra gama de peluches. La dirección y los horarios están disponibles en nuestro sitio web</div>
          </div>
        </div>
      </div>

      <!-- Acordeón 10 -->
      <div class="accordion accordion-flush" id="accordionFlushExample10">
        <div class="accordion-item">
          <h1 class="accordion-header" id="flush-headingTen">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTen" aria-expanded="false" aria-controls="flush-collapseTen">
              10.¿Tienen garantía?
            </button>
          </h1>
          <div id="flush-collapseTen" class="accordion-collapse collapse" aria-labelledby="flush-headingTen" data-bs-parent="#accordionFlushExample10">
            <div class="accordion-body">Todos nuestros peluches vienen con una garantía de satisfacción. Si encuentras algún defecto de fabricación dentro de los primeros 30 días, te ofrecemos un reemplazo o reembolso.</div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <br><br><br>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <?php include_once("footer.php") ?>
  <?php include_once("footer.php") ?>
</body>


</html>