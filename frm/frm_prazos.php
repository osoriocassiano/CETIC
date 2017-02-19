
<!--/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/21/2016
 * Time: 2:04 PM
 */-->
<?php

$acao = "";
$limpar = "";
$cancelar = "";
$dias_prazo = "";

// PREENCHER OS VALUES DO FORM PARA AC=ALTERAR
$dias = "";

if(isset($_GET['ac'])){

    if($_GET['ac'] == ""){
        $acao = "Salvar";
        $limpar = "Limpar";
        $cancelar = "Cancelar";
        if(isset($_POST['Salvar'])){
            $dias_prazo = $_POST['dias_prazo'];

            $salvar = new Crud();
            $salvar->setTabelas("tbl_dias_remanescentes");
            $salvar->setCampos("dr_nome");
            $salvar->setDados("'$dias_prazo'");

            $verifica = new Crud();
            $verifica->setTabelas("tbl_dias_remanescentes");
            $verifica->setCampos("dr_nome = '$dias_prazo'");

            if(!$verifica->verificaExistencia()){
                try{
                    if($salvar->inserir()){
                        $mensagem = "Registado com Sucesso!";
                        header("Location: ../includes/administrador.php?link=7");
                    }
                    else{
                        $erro = "Não foi possível inserir o registo!";
                    }
                }catch(exception $e){
                    $erro = $e->getMessage();
                }
            }
            else{
                $erro = "O registo $dias_prazo já  existe!";
            }
        }

    }
    elseif($_GET['ac'] == "Alterar"){
        $acao = "Alterar";
        $limpar = "Limpar";
        $cancelar = "Cancelar";
        $id = $_GET['id'];

        try{
            $campos_editar = new Crud();
            $campos_editar->setTabelas("tbl_dias_remanescentes");
            $campos_editar->setCamposTblPesquisa("dr_codigo");
            $campos_editar->setValor_pesquisa("'$id'");
            $dados = $campos_editar->listarComId();
            $dias = $dados->dr_nome;
        }catch (Exception $e){
            $excecao = $e->getMessage();
        }



        if(isset($_POST['Alterar'])){
            $dias_prazo = $_POST['dias_prazo'];

            $alterar = new Crud();
            $alterar->setTabelas("tbl_dias_remanescentes");
            $alterar->setCampos("dr_nome = '$dias_prazo'");
            $alterar->setCamposTblPesquisa("dr_codigo");
            $alterar->setValor_pesquisa("$id");

            try{
                if($alterar->alterar()){
                    header("Location: ../includes/administrador.php?link=7");
                }
                else{
                    $erro = "Não foi possível actualizar o registo!";
                }
            }catch (Exception $e){
                $erro = $e->getMessage();
            }
        }
    }
    elseif($_GET['ac'] == "Apagar"){
        $id = $_GET['id'];
        $acao = "Apagar";
        $cancelar = "Cancelar";
        try{
            $campos_apagar = new Crud();
            $campos_apagar->setTabelas("tbl_dias_remanescentes");
            $campos_apagar->setCamposTblPesquisa("dr_codigo");
            $campos_apagar->setValor_pesquisa("'$id'");
            $dados = $campos_apagar->listarComId();
            $dias = $dados->dr_nome;
        }catch (Exception $e){
            $excecao = $e->getMessage();
        }



        if(isset($_POST['Apagar'])){
            $apagar = new Crud();
            $apagar->setTabelas("tbl_dias_remanescentes");
            $apagar->setCamposTblPesquisa("dr_codigo");
            $apagar->setValor_pesquisa("'$id'");
            if($apagar->apagar()){
                header("Location: ../includes/administrador.php?link=7");
            }
            else{
                $erro = "<p>Não foi possível apagar o registo!</p><p><strong>Obs: </strong>Registo pode estar associado a outros registos</p>";
            }
        }
    }
}

if(isset($mensagem)){
    echo '<div class="success callout" data-closable>
          <p>'.$mensagem.'</p>
          <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
            <span aria-hidden="true">&times;</span>
          </button>';

    echo '</div>';
}
elseif(isset($erro)){
    echo '<div class="alert callout" data-closable>
          <p>'.$erro.'</p>
          <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
            <span aria-hidden="true">&times;</span>
          </button>';

    echo '</div>';
}
?>
<fieldset class="fieldset">
    <legend><h5 class="txt_azul"><i class="fi-calendar"></i> Dias para Consulta de validade </h5> </legend>
    <form action="" method="post">
        <div class="row">
            <div class="small-12 medium-6">
                <label for="ant_marca">Dias
                    <input type="text" name="dias_prazo" value="<?php echo $dias; ?>" placeholder="Dias" required pattern="[0-9 ]" /><span class="form-error">Campo Obrigatório!</span>
                </label>
            </div>
            <div class="small-12 medium-6">
                <?php
                if($acao=="Salvar"){?>
                    <button class="success button" type="submit" name="<?php echo $acao;?>"><i class="fi-check"></i> <?php echo $acao; ?></button>
                <?php }
                elseif($acao=="Alterar"){?>
                    <button class="success button" type="submit" name="<?php echo $acao; ?>"><i class="fi-check"></i> <?php echo $acao; ?></button>
                <?php }
                elseif($acao=="Apagar"){?>
                    <button class="alert button" type="submit" name="<?php echo $acao; ?>"><i class="fi-minus"></i> <?php echo $acao; ?></button>
                <?php }
                ?>
                <?php echo ($limpar != "") ? '<button class="warning button" type="reset"> <i class="fi-trash"></i>Limpar</button>' : "";?>
                <?php echo ($cancelar != "") ? '<a href="administrador.php?link=7" class="alert button"><i class="fi-x"></i> Cancelar </a>' : "";?>
            </div>
        </div>
    </form>
</fieldset>