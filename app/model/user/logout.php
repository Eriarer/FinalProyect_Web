<?php
session_unset();
//eliminar los datos de la sesion
session_destroy();
session_write_close();
//borrar las cookies
setcookie("name", '', time() - 3600, "/");
setcookie('email', '', time() - 3600, '/');
setcookie('password', '', time() - 3600, '/');
echo "success";
