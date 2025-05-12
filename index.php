<?php
include('conexao.php');
if(isset($_POST['usuario']) && isset($_POST['senha'])){
    if(strlen(string: $_POST['usuario']) == 0){
        echo "Usuário não informado";
    }else if(strlen(string: $_POST['senha']) == 0){
        echo "Preencha sua senha";
    }else{
        $usuario = $mysqli->real_escape_string(string: $_POST['usuario']);
        $senha = $mysqli->real_escape_string(string: $_POST['senha']);
        $sql_code = "SELECT * FROM usuario WHERE UPPER(nome) = UPPER('$usuario') AND senha = '$senha'";
        $sql_query = $mysqli->query(query: $sql_code) or die('Falha na execução do código SQL: '.$mysqli->error);
        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1){
            $usuario = $sql_query->fetch_assoc();
            if(!isset($_SESSION)){
                session_start();
            }
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            header(header: "Location: paineldeacesso.php");
        }else{
            echo "Falha ao logar! Usuário ou senha incorretos";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AlimentaSE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Insira a localização e o nome da sua imagem aqui, ex.: url("images/sua_imagem.jpg") */
            background-image: url("imagens/fundo_site1.png"); /* Coloque o caminho da sua imagem entre as aspas */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
        }
        .login-container {
            text-align: center;
            z-index: 2;
        }
        .logo {
            font-size: 4em;
            font-weight: bold;
            color: #ff7f2a;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            animation: fadeInLogo 1s ease-in-out;
        }
        @keyframes fadeInLogo {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .tela-login {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px 60px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h1 {
            color: #ff7f2a;
            font-size: 2em;
            margin-bottom: 20px;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.9em;
            margin-bottom: 15px;
            display: none;
        }
        input {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
        }
        input:focus {
            border-color: #ff7f2a;
            box-shadow: 0 0 8px rgba(255, 127, 42, 0.3);
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease;
            margin: 15px 0;
        }
        button:hover {
            background-color: #218838;
            transform: scale(1.02);
        }
        button:active {
            transform: scale(0.98);
        }
        .link-senha {
            margin-top: 10px;
        }
        .link-senha a {
            color: #ff7f2a;
            text-decoration: none;
            font-size: 0.9em;
            transition: color 0.3s ease;
        }
        .link-senha a:hover {
            color: #e66f24;
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .tela-login {
                padding: 30px;
                margin: 10px;
            }
            .logo {
                font-size: 2.5em;
            }
            h1 {
                font-size: 1.5em;
            }
        }
        footer {
    background-color: #ff7f2a;
    color: white;
    padding: 15px 0;
    text-align: center;
    width: 100%;
    /* Remova position: fixed, bottom e left */
    z-index: 1000; /* Mantém o footer acima de outros elementos, se necessário */
        }

        .footer-content p {
            margin: 5px 0;
            font-size: 1em;
        }

        .footer-content p a {
            color: #ffe6cc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-content p a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .footer-content p a i {
            margin-right: 5px;
        }

        body {
            margin: 0; /* Remove margens padrão */
            /* Remova padding-bottom, pois não é necessário sem position: fixed */
        }

        /* Garante que o footer fique no final da página */
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Garante que o body ocupe pelo menos a altura total da janela */
        }

        main {
            flex: 1 0 auto; /* Faz o conteúdo principal ocupar o espaço disponível */
        }

        footer {
            flex-shrink: 0; /* Impede que o footer encolha */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">AlimentaSE</div>
        <div class="tela-login">
            <h1><i class="fas fa-utensils"></i> Login</h1>
            <?php if (isset($_POST['usuario']) && strlen($_POST['usuario']) == 0): ?>
                <div class="error-message" style="display: block;">Usuário não informado</div>
            <?php elseif (isset($_POST['senha']) && strlen($_POST['senha']) == 0): ?>
                <div class="error-message" style="display: block;">Preencha sua senha</div>
            <?php elseif (isset($_POST['usuario']) && isset($_POST['senha'])): ?>
                <div class="error-message" style="display: block;">Falha ao logar! Usuário ou senha incorretos</div>
            <?php endif; ?>
            <form action="" method="POST">
                <input type="text" name="usuario" placeholder="Usuário" autocomplete="off">
                <input type="password" name="senha" placeholder="Senha">
                <button type="submit"><i class="fas fa-sign-in-alt"></i> Entrar</button>
                <div class="link-senha">
                    <a href="esqsenha.php">Esqueci minha senha</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>