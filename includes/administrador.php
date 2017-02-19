<!DOCTYPE html>
<!--
/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/9/2016
 * Time: 9:12 AM
 */
-->
<?php
session_start();
include_once("../Classes/Crud.php");
if(isset($_SESSION['usuario'])){

?>
<script>
    $(document).foundation();
</script>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CETIC</title>
    <link rel="stylesheet" href="../public/css/foundation.css">
    <link rel="stylesheet" href="../public/css/app.css">
    <link rel="stylesheet" href="../public/css/foundation-icons.css">
    <link rel="stylesheet" href="../public/css/dataTables.foundation.min.css"/>


    <script src="../public/js/vendor/jquery.js"></script>
    <script src="../public/js/vendor/what-input.js"></script>
    <script src="../public/js/vendor/foundation.js"></script>
    <script src="../public/js/app.js"></script>
    <script src="../public/js/jquery.dataTables.min.js"></script>
    <script src="../public/js/dataTables.foundation.min.js"></script>


</head>
<body>

    <header class="header_principal">
        <img src="../public/img/logo.png"/>
    </header>
    <?php include_once("nav.php"); ?>
    <?php include_once("corpo_administracao.php"); ?>

</body>

<script src="../public/js/vendor/jquery.js"></script>
<script src="../public/js/vendor/what-input.js"></script>
<script src="../public/js/vendor/foundation.js"></script>
<script src="../public/js/app.js"></script>
<script src="../public/js/jquery.dataTables.min.js"></script>
<script src="../public/js/dataTables.foundation.min.js"></script>

<?php
}
else {
    $mensagem = "Não tem permissão a esta página!  <a href='../index.php'>Voltar</a>";

    if (isset($mensagem)) {
        echo '<div class="success callout" data-closable>
          <p>' . $mensagem . '</p>
          <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
            <span aria-hidden="true">&times;</span>
          </button>';

        echo '</div>';
    }
}
?>
</html>
