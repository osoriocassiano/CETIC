<?php
/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/11/2016
 * Time: 6:36 PM
 */


$acao = "";
$uc_nome = "";
$uc_apelido = "";
$uc_serial = "";
$uc_data_registo = "";
$limpar = "";
$cancelar = "";

// PREENCHER OS VALUES DO FORM PARA AC=ALTERAR
$nome = "";
$apelido = "";
$serial = "";
$data_registo = "";

if(isset($_GET['ac'])){

    if($_GET['ac'] == ""){
        $acao = "Salvar";
        $limpar = "Limpar";
        $cancelar = "Cancelar";
        if(isset($_POST['Salvar'])){
            $uc_nome = $_POST['uc_nome'];
            $uc_apelido = $_POST['uc_apelido'];
            $uc_serial = $_POST['uc_serial'];
            $uc_data_registo = $_POST['uc_data_registo'];

            $salvar = new Crud();
            $salvar->setTabelas("tbl_usuario_computador");
            $salvar->setCampos("uc_serial, uc_nome, uc_apelido, uc_data_registo");
            $salvar->setDados("'$uc_serial', '$uc_nome', '$uc_apelido', '$uc_data_registo'");

            $verifica = new Crud();
            $verifica->setTabelas("tbl_usuario_computador");
            $verifica->setCampos("uc_serial = '$uc_serial'
                                  AND uc_nome = '$uc_nome'
                                  AND uc_apelido = '$uc_apelido'
                                  AND uc_data_registo = '$uc_data_registo'");

            if(!$verifica->verificaExistencia()){
                try{
                    if($salvar->inserir()){
                        $mensagem = "Registado com Sucesso!";
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

        try{
            $campos_editar = new Crud();
            $campos_editar->setTabelas("tbl_usuario_computador");
            $campos_editar->setCamposTblPesquisa("uc_codigo");
            $campos_editar->setValor_pesquisa("'$id'");
            $dados = $campos_editar->listarComId();

            $nome = $dados->uc_nome;
            $apelido = $dados->uc_apelido;
            $serial = $dados->uc_serial;
            $data_registo = $dados->uc_data_registo;
        }catch (Exception $e){
            $excecao = $e->getMessage();
        }

        if(isset($_POST['Alterar'])){
            $uc_nome = $_POST['uc_nome'];
            $uc_apelido = $_POST['uc_apelido'];
            $uc_serial = $_POST['uc_serial'];
            $uc_data_registo = $_POST['uc_data_registo'];

            $alterar = new Crud();
            $alterar->setTabelas("tbl_usuario_computador");
            $alterar->setCampos("uc_serial = '$uc_serial',
                                     uc_nome = '$uc_nome',
                                     uc_apelido = '$uc_apelido',
                                     uc_data_registo = '$uc_data_registo'");
            $alterar->setCamposTblPesquisa("uc_codigo");
            $alterar->setValor_pesquisa("$id");

            try{
                if($alterar->alterar()){
                    header("Location: ../includes/administrador.php?link=3");
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
            $campos_editar = new Crud();
            $campos_editar->setTabelas("tbl_usuario_computador");
            $campos_editar->setCamposTblPesquisa("uc_codigo");
            $campos_editar->setValor_pesquisa("'$id'");
            $dados = $campos_editar->listarComId();

            $nome = $dados->uc_nome;
            $apelido = $dados->uc_apelido;
            $serial = $dados->uc_serial;
            $data_registo = $dados->uc_data_registo;
        }catch (Exception $e){
            $excecao = $e->getMessage();
        }
        if(isset($_POST['Apagar'])){
            $apagar = new Crud();
            $apagar->setTabelas("tbl_usuario_computador");
            $apagar->setCamposTblPesquisa("uc_codigo");
            $apagar->setValor_pesquisa("'$id'");
            if($apagar->apagar()){
                header("Location: ../includes/administrador.php?link=3");
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
    <legend> <h5 class="txt_azul"><i class="fi-torso"></i>Usuário e Serial de PC</h5> </legend>
    <form method="POST" action="" data-abide novalidate>
        <div class="row">
            <div class="small-12 large-6 columns">
                <label>Nome
                    <input type="text" name="uc_nome" value="<?php echo $nome; ?>" placeholder="Nome" required pattern="[a-zA-Z ]"/><span class="form-error">Apenas letras e espaços são permitidos!</span>
                </label>
            </div>
            <div class="small-12 medium-6 columns">
                <label>Apelido
                    <input type="text" name="uc_apelido" value="<?php echo $apelido; ?>" placeholder="Apelido" pattern="[a-zA-Z ]"/><span class="form-error">Apenas letras e espaços são permitidos!</span>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-12 medium-6 columns">
                <label>Serial do PC
                    <input type="text" name="uc_serial" value="<?php echo $serial; ?>" placeholder="Serial do PC: XXXXX-XXXXX-XXXXX-XXXXX" required pattern="[a-zA-Z0-9-]"/><span class="form-error">Insira uma Licença Válida!</span>
                </label>
            </div>
            <div class="small-12 medium-6 columns">
                <label>Data-Registo
                    <input type="text" name="uc_data_registo" value="<?php echo $data_registo; ?>" placeholder="Ano-Mes-Dia" required/><span class="form-error">Data obrigatória!</span>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-12 columns">
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
                <?php echo ($cancelar != "") ? '<a href="administrador.php?link=3" class="alert button"><i class="fi-x"></i> Cancelar </a>' : "";?>
            </div>
        </div>
    </form>
</fieldset>
