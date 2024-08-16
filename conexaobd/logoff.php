<?php

session_start();

//remove asn variáveis de sessão
$_SESSION = array();

//destrói a sessão
session_destroy();

//redireciona para a página de login
header("location: login.php");
exit;