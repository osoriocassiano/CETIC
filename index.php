<?php
session_start();
include_once ("Classes/Crud.php");

if(isset($_POST['login'])){
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_MAGIC_QUOTES);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_MAGIC_QUOTES);
    try{
       // $acesso = new Crud();
        logar($usuario, $senha);
    }catch(exception $e){
        $mensagem = $e->getMessage();
    }
}

?>
<!--
* Created by Osorio Malache.
* User: EG-IT
* Date: 12/8/2016
* Time: 7:57 PM
*-->
<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CETIC-Antivirus</title>
    <link rel="stylesheet" href="public/css/foundation.css">
    <link rel="stylesheet" href="public/css/app.css">
</head>
<body style="background-color: #e6e6e6;">
    <header class="header_login">
        <img src="public/img/Logo_CE.png"/>
    </header>
    <div class="row">
        <div style=" background-color: #ffffff;" class="medium-6 medium-centered large-4 large-centered columns">
            <?php
                if(isset($mensagem)){
                    echo '<div class="alert callout" data-closable>
                    <p>'.$mensagem.'</p>
                    <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                    </button>';

                echo '</div>';
            }
            ?>
            <form method="post" action="">
                <div class="row column log-in-form">
                    <h2 class="text-center" style="color: #2199E8"> Acesso ao Sistema </h2>
                    <label> Usuário
                        <input type="text" name="usuario" placeholder="nome de usuário">
                    </label>
                    <label>Senha
                        <input type="password" name="senha" placeholder="senha">
                    </label>
                    <input id="show-password" type="checkbox"><label for="show-password">Mostrar senha</label>
                    <p><input type="submit" name="login" Value="Acesso" class="button expanded"></p>
                </div>
            </form>
        </div>
    </div>

    <script src="public/js/vendor/jquery.js"></script>
    <script src="public/js/vendor/what-input.js"></script>
    <script src="public/js/vendor/foundation.js"></script>
    <script charset="utf-8">
        $(document).foundation();
    </script>
</body>
</html>


