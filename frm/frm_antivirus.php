<!--
/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/14/2016
 * Time: 10:29 PM
 */-->
<?php

$acao = "";
$limpar = "";
$cancelar = "";
$mar_ant_nome = "";

// PREENCHER OS VALUES DO FORM PARA AC=ALTERAR
$nome = "";

if(isset($_GET['ac'])){

    if($_GET['ac'] == ""){
        $acao = "Salvar";
        $limpar = "Limpar";
        $cancelar = "Cancelar";
        if(isset($_POST['Salvar'])){
            $mar_ant_nome = $_POST['mar_ant_nome'];

            $salvar = new Crud();
            $salvar->setTabelas("tbl_marca_antiv");
            $salvar->setCampos("mar_ant_nome");
            $salvar->setDados("'$mar_ant_nome'");

            $verifica = new Crud();
            $verifica->setTabelas("tbl_marca_antiv");
            $verifica->setCampos("mar_ant_nome = '$mar_ant_nome'");

            if(!$verifica->verificaExistencia()){
                try{
                    if($salvar->inserir()){
                        $mensagem = "Registado com Sucesso!";
                        header("Location: ../includes/administrador.php?link=5");
                    }
                    else{
                        $erro = "Não foi possível inserir o registo!";
                    }
                }catch(exception $e){
                    $erro = $e->getMessage();
                }
            }
            else{
                $erro = "O registo já  existe!";
            }
        }

    }
    elseif($_GET['ac'] == "Alterar"){
        $acao = "Alterar";
        $limpar = "Limpar";
        $cancelar = "Cancelar";
        $id = $_GET['id'];

        $campos_editar = new Crud();
        $campos_editar->setTabelas("tbl_marca_antiv");
        $campos_editar->setCamposTblPesquisa("mar_ant_codigo");
        $campos_editar->setValor_pesquisa("'$id'");
        $dados = $campos_editar->listarComId();

        $nome = $dados->mar_ant_nome;

        if(isset($_POST['Alterar'])){
            $mar_ant_nome = $_POST['mar_ant_nome'];

            $alterar = new Crud();
            $alterar->setTabelas("tbl_marca_antiv");
            $alterar->setCampos("mar_ant_nome = '$mar_ant_nome'");
            $alterar->setCamposTblPesquisa("mar_ant_codigo");
            $alterar->setValor_pesquisa("'$id'");

            try{
                if($alterar->alterar()){
                    header("Location: ../includes/administrador.php?link=5");
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
        $campos_apagar = new Crud();
        $campos_apagar->setTabelas("tbl_marca_antiv");
        $campos_apagar->setCamposTblPesquisa("mar_ant_codigo");
        $campos_apagar->setValor_pesquisa("'$id'");
        $dados = $campos_apagar->listarComId();

        $nome = $dados->mar_ant_nome;

        if(isset($_POST['Apagar'])){
            $apagar = new Crud();
            $apagar->setTabelas("tbl_marca_antiv");
            $apagar->setCamposTblPesquisa("mar_ant_codigo");
            $apagar->setValor_pesquisa("'$id'");
            if($apagar->apagar()){
                header("Location: ../includes/administrador.php?link=5");
            }
            else{
                $erro = "<p>Não foi possível apagar o registo!</p><p><strong>Obs: </strong>Registo pode estar associado a licenças de Antivírus</p>";
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
    <legend><h5 class="txt_azul"><i class="fi-shield"></i>Marca de Antivírus </h5> </legend>
    <form action="" method="post">
        <div class="row">
            <div class="small-12 medium-6">
                <label for="ant_marca">Marca
                    <input type="text" name="mar_ant_nome" value="<?php echo $nome; ?>" placeholder="Marca" required><span class="form-error">Campo Obrigatório!</span>
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
                <?php echo ($cancelar != "") ? '<a href="administrador.php?link=5" class="alert button"><i class="fi-x"></i> Cancelar </a>' : "";?>
            </div>
        </div>
    </form>
</fieldset>