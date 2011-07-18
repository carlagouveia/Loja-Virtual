<?php

require('./autoloader.php');

$usuarios = new Usuarios();
$usuarios->deslogarUsuario();
die('<meta http-equiv="refresh" content="0;url=index.php">');

?>