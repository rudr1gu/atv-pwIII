<?php

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            padding: 20px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Olá, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bem-vindo ao nosso site.</h1>
                </div>
                <p><a href="reset-password.php" class="btn btn-warning">Redefinir sua senha</a></p>
                <p><a href="logoff.php" class="btn btn-danger">Sair da sua conta</a></p>
            </div>
        </div>
    </div>
</body>
</html>