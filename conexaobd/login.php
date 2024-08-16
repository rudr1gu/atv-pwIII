<?php

session_start();

//verifica se o usuário está logado
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header("Location: welcome.php");
    exit();
}

//inclui o arquivo de configuração
require_once "conexaobd/config.php";

//definindo variáveis e inicializando com valores vazios
$username = $password = "";
$username_err = $password_err = $login_err = "";

//processamento de dados do formulário quando o formulário é submetido
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //verifica se o nome de usuário está vazio
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor, insira o nome de usuário.";
    } else{
        $username = trim($_POST["username"]);
    }

    //verifica se a senha está vazia
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, insira a senha.";
    } else{
        $password = trim($_POST["password"]);
    }

    //validação de credenciais
    if(empty($username_err) && empty($password_err)){
        //prepara a declaração de seleção
        $sql = "SELECT id, username, password FROM users WHERE username = :username";

        if($stmt = $pdo->prepare($sql)){
            //vincula variáveis à declaração preparada como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            //definindo parâmetros
            $param_username = trim($_POST["username"]);

            //tentativa de execução da declaração preparada
            if($stmt->execute()){
                //verifica se o nome de usuário existe, se sim, verifica a senha
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            //senha correta, inicia uma nova sessão
                            session_start();

                            //armazena dados em variáveis de sessão
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            //redireciona o usuário para a página de boas-vindas
                            header("Location: welcome.php");
                        } else{
                            //exibe uma mensagem de erro se a senha não for válida
                            $login_err = "Nome de usuário ou senha inválidos.";
                        }
                    }
                } else{
                    //exibe uma mensagem de erro se o nome de usuário não existir
                    $login_err = "Nome de usuário ou senha inválidos.";
                }
            } else{
                echo "Oops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            //fecha a declaração
            unset($stmt);
        }
    }

    //fecha a conexão
    unset($pdo);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tela de Login</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tela de Login</h2>
        <?php
        if(!empty($login_err)){
            echo '<div style="color:red;text-align:center;font-size:17px;">'.$login_err.'</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVE["PHP_SELF"]); ?>">
            <div class="form-group" action="">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" <?php echo(!empty($username_err)) ? 'is-invalid': ''; ?> value="<?php echo $username ?>" >
                <span <?php echo $username_err ?>></span>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" <?php echo(!empty($password_err)) ? 'is-invalid': ''; ?> value="<?php echo $password ?>" required>
                <span <?php echo $password_err ?>></span>
            </div>
            <div class="form-group">
                <button type="submit">Entrar</button>
            </div>
        </form>
    </div>
</body>
</html>