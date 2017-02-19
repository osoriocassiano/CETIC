<!--/**
 * Created by PhpStorm.
 * User: EG-IT
 * Date: 12/21/2016
 * Time: 10:04 PM
 */-->
<div class="espaco-vertical"></div>
        <div class="small-2 columns">
            <div class="row">
                <div class="small-12 columns ">
                    <ul class="menu vertical">
                        <li><h2><a href="administrador.php?link=1"><button class="button expanded"><i class="fi-annotate"></i> Uso de Licença </button> </a> </h2></li>
                        <li><h2><a href="administrador.php?link=3"><button class="button expanded"><i class="fi-torsos"></i> Usuários </button> </a> </h2></li>
                        <li><h2><a href="administrador.php?link=5"><button class="button expanded"><i class="fi-shield"></i> Antivírus </button> </a> </h2></li>
                        <li><h2><a href="administrador.php?link=7"><button class="button expanded"><i class="fi-shield"></i> Prazos </button> </a> </h2></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="small-10 columns">
            <?php
                $pag[1] = ('../listas/li_registo_ant_pc.php');
                $pag[2] = ('../frm/frm_registo_ant_pc.php');
                $pag[3] = ('../listas/li_usuarios_pc.php');
                $pag[4] = ('../frm/frm_registo_pc.php');
                $pag[5] = ('../listas/li_antivirus.php');
                $pag[6] = ('../frm/frm_antivirus.php');
                $pag[7] = ('../listas/li_prazos.php');
                $pag[8] = ('../frm/frm_prazos.php');
                $pag[9] = ('../listas/li_usuario_sistema.php');
                $pag[10] = ('../frm/frm_usuario_sistema.php');
                $pag[11] = ('../listas/li_detalhes_registo_ant_pc.php');


                if(isset($_GET['link'])){
                    $link = $_GET['link'];
                }
                else{
                    $link = 1;
                }

                try{
                    include_once($pag[$link]);
                }catch (Exception $e){
                    echo $e->getMessage();
                }

            ?>

</div>