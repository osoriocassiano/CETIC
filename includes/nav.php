<!--/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/21/2016
 * Time: 9:58 PM
 */-->
<?php
if(isset($_GET['sair'])){
    if($_GET['sair'] == "sair"){
        // $sair = new Crud();
        logOut('usuario');
    }

}
?>

<nav class="top-bar azul">
    <div class="top-bar-title">
            <span data-responsive-toggle="responsive-menu" data-hide-for="medium">
              <button class="menu-icon dark" type="button" data-toggle></button>
            </span>
        <strong>Antivirus</strong>
    </div>
    <div id="responsive-menu">
        <div class="top-bar-right" style="background-color: #fff">
            <span class="transparent li-login" > <?php echo $_SESSION['us_usuario']; ?> </span>
            <span class="transparent li-login" > <a href="?sair=sair" >| Sair <i class="fi-power"></i></a> </span>

        </div>
    </div>
</nav>