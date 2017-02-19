<!DOCTYPE HTML>
<!--
    /**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/11/2016
 * Time: 2:23 PM
 */
 -->
<script type="text/javascript" src="../public/js/jquery-2.1.0.js"></script>
<script type="text/javascript">
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#pega_prazo").change(function(){
            var prazo = $(".pega_value:selected").text();
            var mostrar_permanente = $("#MostraPesq").text();

            if(	prazo == ""){
                $("#MostraPesq").html("Escolha o prazo");
            }
            else{
                $.get("../listas/li_pesquisa_prazos.php", {prazo_post: prazo}, function(data){
                    $("#MostraPesq").html(data);
                });
                /* console.log(data); */
                /* 				var db_data = jQuery.parseJSON(data);
                 */				//$("#MostraPesq").html(prestacoes_id);
                //console.log(prestacoes_id);

            }
            $("#pega_prazo").attr('selectedIndex', '-1').children("option:selected").removeAttr("selected");
        });
    });

    $(document).ready(function(){
        var mostrar_permanente = $("#MostraPesq").val();
        if(mostrar_permanente==""){

            $.get("../listas/li_mostrar_permanente.php", function(data){
                $("#MostraPesq").html(data);
            });
        }

    });
    function listar_todos(){
        $.get("../listas/li_mostrar_permanente.php", function(data){
            $("#MostraPesq").html(data);
        });
    }
    function listar_dentro_prazo(){
        $.get("../listas/li_mostrar_dentro_prazo.php", function(data){
            $("#MostraPesq").html(data);
        });
    }

</script>

    <div class="small-12 medium-6 columns ">
        <div class="top-bar-left">
            <ul class="menu">
                <li><a href="../includes/administrador.php?link=2&ac=" class="button"><i class="fi-plus"></i> Novo Registo </a> </li>
                <li><a href="#" class="button expanded" onclick="listar_dentro_prazo()"><i class="fi-list"></i> Listar Dentro do prazo</a></li>
                <li><a href="#" class="button expanded" onclick="listar_todos()"><i class="fi-list"></i> Listar Todos</a></li>
            </ul>
        </div>

    </div>
    <div class="small-12 medium-3 columns">

        <?php
        $dias_remanesc = new Crud();
        $dias_remanesc->setTabelas("tbl_dias_remanescentes");
        try{

            $dados_dias_remanesc = $dias_remanesc->listar();
            $lista_dias_remanesc = new ArrayIterator($dados_dias_remanesc);?>
            <select id="pega_prazo">
                <option> Selecione o prazo </option>
                <?php while($lista_dias_remanesc->valid()){?>
                    <option  class="pega_value" value="<?php echo $lista_dias_remanesc->current()->dr_codigo?>"> <?php echo $lista_dias_remanesc->current()->dr_nome; ?> </option>
                    <?php $lista_dias_remanesc->next();}?>
            </select>
            <?php
        }catch(Exception $e){
                $mensagem = $e->getMessage();
        } ?>
    </div>
    <div class="small-12 medium-3 columns">
        <div><input type="text" id="pesq" placeholder="Pesquisa..."></div>
    </div>
<div class="row">
    <div class="small-12 medium-12 large-12 columns" id="MostraPesq"></div>
</div>


