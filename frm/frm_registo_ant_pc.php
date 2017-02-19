<?php
/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/11/2016
 * Time: 11:57 PM
 */

try{

}catch (Exception $e){
    $excecao = $e->getMessage();
}

$acao = "";
$limpar = "";
$cancelar = "";
$apc_serial_antiv = "";
$apc_mar_antiv = "";
$apc_validade = "";
$apc_serial_pc = "";
$apc_data_registo = "";
$usuario_responsavel = "";



$serial_antiv = "";
$marca_antiv = "";
$validade = "";
$serial_pc = "";
$data_registo = "";

    if(isset($_GET['ac'])){




        if($_GET['ac'] == ""){
            $usuario_responsavel = $_SESSION['us_codigo'];
            $acao = "Salvar";
            $limpar = "Limpar";
            $cancelar = "Cancelar";
            if(isset($_POST['Salvar'])){
                $apc_serial_antiv = $_POST['apc_serial_antiv'];
                $apc_mar_antiv = $_POST['apc_mar_antiv'];
                $apc_validade = $_POST['apc_validade'];
                $apc_serial_pc = $_POST['apc_serial_pc'];
                $apc_data_registo = $_POST['apc_data_registo'];

                $salvar = new Crud();
                $salvar->setTabelas("tbl_antivirus_pc");
                $salvar->setCampos("apc_serial_antiv, apc_serial_pc, apc_data_registo, apc_validade, apc_marca_antiv, apc_responsavel_registo");
                $salvar->setDados("'$apc_serial_antiv', '$apc_serial_pc', '$apc_data_registo', '$apc_validade', '$apc_mar_antiv', '$usuario_responsavel'");

                $verifica = new Crud();
                $verifica->setTabelas("tbl_usuario_computador");
                $verifica->setCampos("uc_serial = '$apc_serial_pc'");

                if($verifica->verificaExistencia()){
                    try{
                        if($salvar->inserir()){
                            $mensagem = "Registado com Sucesso!";

                        }
                        else{
                            $erro = "Não foi possível efectivar o registo!";
                        }
                    }catch (Exception $e){
                        $mensagem = $e->getMessage();
                    }
                }
                else{
                    $erro = "Serial de Computador não registado! <br> Por favor, registe primeiro o usuário e o respectivo serial!
                    <a href='administrador.php?link=5'>Registar Usuário</a> ";
                }
            }
        }
        elseif($_GET['ac'] == "Alterar"){
            $usuario_responsavel = $_SESSION['us_codigo'];
            $acao = "Alterar";
            $limpar = "Limpar";
            $cancelar = "Cancelar";
            $id = $_GET['id'];
            try{
                $campos_editar = new Crud();
                $campos_editar->setTabelas("tbl_antivirus_pc");
                $campos_editar->setCamposTblPesquisa("apc_codigo");
                $campos_editar->setValor_pesquisa("$id");
                $campos_editar->listarComId();

                $serial_antiv = $campos_editar->listarComId()->apc_serial_antiv;
                $marca_antiv = $campos_editar->listarComId()->apc_marca_antiv;
                $validade = $campos_editar->listarComId()->apc_validade;
                $serial_pc = $campos_editar->listarComId()->apc_serial_pc;
                $data_registo = $campos_editar->listarComId()->apc_data_registo;
            }catch (Exception $e){
                $e->getMessage();
            }
            if(isset($_POST['Alterar'])){
                $apc_serial_antiv = $_POST['apc_serial_antiv'];
                $apc_mar_antiv = $_POST['apc_mar_antiv'];
                $apc_validade = $_POST['apc_validade'];
                $apc_serial_pc = $_POST['apc_serial_pc'];
                $apc_data_registo = $_POST['apc_data_registo'];


                $alterar = new Crud();
                $alterar->setTabelas("tbl_antivirus_pc");
                $alterar->setCampos("apc_serial_antiv = '$apc_serial_antiv',
                                     apc_serial_pc = '$apc_serial_pc',
                                     apc_data_registo = '$apc_data_registo',
                                     apc_validade = '$apc_validade',
                                     apc_marca_antiv = '$apc_mar_antiv',
                                     apc_responsavel_registo = '$usuario_responsavel'");
                $alterar->setCamposTblPesquisa("apc_codigo");
                $alterar->setValor_pesquisa("$id");

                try{
                    if($alterar->alterar()){
                        header("Location: ../includes/administrador.php?link=1");
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
            $acao = "Apagar";
            $cancelar = "Cancelar";
            $id = $_GET['id'];



            try{
                $li_apagar = new Crud();
                $li_apagar->setTabelas("tbl_antivirus_pc");
                $li_apagar->setCamposTblPesquisa("apc_codigo");
                $li_apagar->setValor_pesquisa("'$id'");
                $dados = $li_apagar->listarComId();

                $serial_antiv = $dados->apc_serial_antiv;
                $marca_antiv = $dados->apc_marca_antiv;
                $validade = $dados->apc_validade;
                $serial_pc = $dados->apc_serial_pc;
                $data_registo = $dados->apc_data_registo;
            }catch (Exception $e){
                $e->getMessage();
            }

            if(isset($_POST['Apagar'])){
                $apagar = new Crud();
                $apagar->setTabelas("tbl_antivirus_pc");
                $apagar->setCamposTblPesquisa("apc_codigo");
                $apagar->setValor_pesquisa("'$id'");
                if($apagar->apagar()){
                    header("Location: ../includes/administrador.php?link=1");
                }
                else{
                    $erro = "Não foi possível apagar o registo!";
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
    if(isset($erro)){
        echo '<div class="alert callout" data-closable>
          <p>'.$erro.'</p>
          <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
            <span aria-hidden="true">&times;</span>
          </button>';

        echo '</div>';
    }
}
?>
<fieldset class="fieldset">
    <legend><h5 class="txt_azul"><i class="fi-torso"></i> Uso da Licença de Antivírus</h5> </legend>
    <form method="POST" action="" data-abide novalidate>
        <div class="row">
            <div class="small-12 large-6 columns">
                <label>Serial Antivirus
                    <input type="text" name="apc_serial_antiv" value="<?php echo $serial_antiv; ?>" placeholder="Serial de Antivirus: XXXXX-XXXXX-XXXXX-XXXXX" required pattern="[a-zA-Z0-9-]"><span class="form-error">Insira uma Licença Válida!</span>
                </label>
            </div>
            <div class="small-12 large-3 columns">
                <label>Marca Antivirus
                    <select class="select" name="apc_mar_antiv" required>
                        <option value=""> Seleccione uma marca</option>
                        <?php
                        try {
                            $marca = new Crud();
                            $marca->setTabelas('tbl_marca_antiv');
                            $dados = $marca->listar();
                            $lista = new ArrayIterator($dados);
                            while ($lista->valid()) {
                                ?>
                                <option
                                    value="<?php echo $lista->current()->mar_ant_codigo; ?>" <?php if ($lista->current()->mar_ant_codigo == $marca_antiv) echo 'selected'; ?> > <?php echo $lista->current()->mar_ant_nome; ?></option>
                                <?php
                                $lista->next();
                            }
                        }catch(Exception $e){
                            $excecao = $e->getMessage();
                        }?>
                    </select><small class="form-error">Campo Obrigatorio</small>
                </label>
            </div>
            <div class="small-12 large-3 columns">
                    <label> Validade
                        <input type="number" name="apc_validade" value="<?php echo $validade; ?>" placeholder="Dias" required/><span class="form-error">Validade obrigatória</span>
                    </label>
                </div>
        </div>
        <div class="row">
            <div class="small-12 large-6 columns">
                <label>Serial do PC
                    <input type="text" name="apc_serial_pc" value="<?php echo $serial_pc; ?>" placeholder="Serial do PC" required pattern="[a-zA-Z0-9-]"/><span class="form-error">Insira uma Licença Válida!</span>
                </label>
            </div>
            <div class="small-12 large-6 columns">
                <label>Data de Registo
                    <input type="text" name="apc_data_registo" value="<?php echo $data_registo; ?>" placeholder="Data de Registo" required/><span class="form-error">Data obrigatória!</span>
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
                <?php echo ($cancelar != "") ? '<a href="administrador.php?link=1" class="alert button"><i class="fi-x"></i> Cancelar </a>' : "";?>
            </div>
        </div>
    </form>
</fieldset>

