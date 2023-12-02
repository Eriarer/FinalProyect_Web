<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <link rel="stylesheet" href="../css/Tiendaestilos.css">
    <title>Document</title>
</head>
<?php include_once("navbar.php") ?>

<body>
    <br>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="../../media/images/fondoNavidad.png" alt="First slide" width="auto" height="500">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../../media/images/fondoHalloween.png" alt="Second slide" width="auto" height="500">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../../media/images/fondoCumple.png" alt="Third slide" width="auto" height="500">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../../media/images/fondoGradua.png" alt="Fourth slide" width="auto" height="500">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a><br>
    </div>
    <!-- fin carrusel -->
    <div class="bienvenida">
        <h3> ¡Bienvenidos a FluffyHugs! <img src="../../media/images/bienvenido.png" height="50"></h3>
        <p>Explora un mundo donde la ternura y la imaginación se encuentran. En FluffyHugs, creemos que cada peluche es más que un juguete; es un compañero de aventuras y un amigo fiel. Nuestra colección de peluches suaves y acogedores está diseñada para llevar alegría a corazones de todas las edades. Desde los clásicos ositos de peluche hasta criaturas fantásticas, cada uno de nuestros peluches tiene su propia personalidad y historia que contar.</p>
        <p style="text-align: center;"><b>¡Explora nuestra tienda y descubre tu próximo compañero de abrazos!</b></p>
    </div>
    <h3 class="Categorias">CATEGORIAS</h3>
    <div class="images-row">
        <div class="image-row-top">
            <div class="container1">
                <img src="../../media/images/Festividades.png" alt="portadaOcasiones" class="image1">
                <div class="overlay1">
                    <div class="text1">Por Ocasiones</div>
                </div>
            </div>

            <div class="container2">
                <img src="../../media/images/Especiales.png" alt="portadaEspaciales" class="image2">
                <div class="overlay2">
                    <div class="text2">Especiales</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categorias destacadas -->
    <div class="destacados">
        <h3 id="titulo_des">LO MAS DESTACADO</h3>
        <div class="conteiner_des">
            <!-- -------card 1------- -->
            <article class="card_des">
              <img src="../../media/images/productos/Pirata.png" alt="" class="image"> 
              <section class="body_des">
                <h3 class="tit_des">Ake Pirata</h3>
                 <p class="texto">Compañero de aventuras <br>
                    <sub><b>1</b></sub>
                 </p>
              </section> 
            </article>
            <!-- --------card 2-------- -->
            <article class="card_des">
              <img src="../../media/images/productos/monoNiev.png" alt="" class="image"> 
              <section class="body_des">
                <h3 class="tit_des">Copito</h3>
                 <p class="texto">Perfecto para tus Navidades <br>
                    <sub><b>2</b></sub>
                 </p>
                </section>
            </article>
            <!-- -----------card 3------------------ -->
            <article class="card_des">
              <img src="../../media/images/productos/florC.png" alt="" class="image"> 
              <section class="body_des">
                <h3 class="tit_des">Xochitl</h3>
                 <p class="texto">Nuestros recuerdos iluminan los caminos del alma <br>
                    <sub><b>3</b></sub>
                 </p>
                </section>
            </article>
            <!-- -----------card 4------------------ -->
            <article class="card_des">
              <img src="../../media/images/productos/DinoGlobos.png" alt="" class="image"> 
              <section class="body_des">
                <h3 class="tit_des">Bob Stegosaurus</h3>
                 <p class="texto">Tu amigo favorito de la prehistoria <br>
                    <sub><b>4</b></sub>
                 </p>
                </section>
            </article>
            <!-- -----------card 5------------------ -->
            <article class="card_des">
              <img src="../../media/images/productos/Elefante.png" alt="" class="image"> 
              <section class="body_des">
                <h3 class="tit_des">Valentina Elefantina</h3>
                 <p class="texto">En cada abrazo, un corazón elefante de amor. <br>
                    <sub><b>5</b></sub>
                 </p>
                </section>
            </article>
        
        </div>
    </div>
    <hr><br>
    <!-- Informacion extra -->
    <div class="container mt-4 cajasInfo">
        <div class="row text-center">
            <!-- Caja de "Sitio mayorista" -->
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart icon-box"></i>
                        <h5 class="card-title">Sitio mayorista</h5>
                        <p class="card-text">Compra mínima $1,000 MXN (más gastos de envío)</p>
                    </div>
                </div>
            </div>

            <!-- Caja de "Envíos gratis" -->
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="fas fa-truck icon-box"></i>
                        <h5 class="card-title">Envíos gratis*</h5>
                        <p class="card-text">En compras mayores a $3,499 MXN</p>
                    </div>
                </div>
            </div>

            <!-- Caja de "Compra segura" -->
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="fas fa-lock icon-box"></i>
                        <h5 class="card-title">Compra segura</h5>
                        <p class="card-text">Seremos tus proveedores de confianza</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="fas fa-percent icon-box"></i>
                        <h5 class="card-title">Descuentos</h5>
                        <p class="card-text">En productos seleccionados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
<!-- -------------------------metodos de pago--------- -->
    <h3 class="Pagos">METODOS DE PAGO</h3><br>
        <div class="metodosdepago">
          <div class="metodo">
            <img class="Metodopago" src="../../media/images/tarjetaCD.png" alt="tarjetas">
            <div class="text_pago">
              <p>Credito/debito</p>  
            </div>
          </div>
          <div class="metodo">
            <img class="Metodopago" src="../../media/images/efectivo2.png" alt="efectivo">
             <div class="text_pago">
                <p>Efectivo</p>
             </div>
          </div>
          <div>
            <img class="Metodopago" src="../../media/images/tarjetaRegalo.png" alt="tarjetaRegalo">
            <div class="text_pago">
                <p>Tarjeta de regalo</p>
            </div>
          </div>
          <div>
            <img class="Metodopago" src="../../media/images/oxxo.png" alt="oxxo"> 
            <div class="text_pago">
              <p>Tiendas Oxxo</p>
            </div>
          </div>
           
           
        </div>
    
    <br>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php include_once("footer.php") ?>
</body>
</html>