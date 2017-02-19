
<!--/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/21/2016
 * Time: 3:52 PM
 */-->
<?php

$acao = "";
$limpar = "";
$cancelar = "";
$us_nome = "";
$us_apelido ="";
$us_cargo = "";
$us_tipo = "";
$us_usuario = "";
$us_senha = "";

// PREENCHER OS VALUES DO FORM PARA AC=ALTERAR
$nome = "";
$apelido = "";
$cargo = "";
$tipo = "";
$usuario = "";
$senha = "";

if(isset($_GET['ac'])){

    if($_GET['ac'] == ""){
        $acao = "Salvar";
        $limpar = "Limpar";
        $cancelar = "Cancelar";
        if(isset($_POST['Salvar'])){
            $us_nome = $_POST['us_nome'];
            $us_apelido = $_POST['us_apelido'];
            $us_cargo = $_POST['us_cargo'];
            $us_tipo = $_POST['us_tipo'];
            $us_usuario = $_POST['us_usuario'];
            $us_senha = $_POST['us_senha'];

            $salvar = new Crud();
            $salvar->setTabelas("tbl_usuario_sistema");
            $salvar->setCampos("us_nome, us_apelido, us_cargo, us_tipo, us_usuario, us_senha");
            $salvar->setDados("'$us_nome', '$us_apelido', '$us_cargo', '$us_tipo', '$us_usuario', '$us_senha'");

            $verifica = new Crud();
            $verifica->setTabelas("tbl_usuario_sistema");
            $verifica->setCampos("us_nome = '$us_nome' AND us_apelido = '$us_apelido' AND us_cargo = '$us_cargo' AND us_tipo = '$us_tipo'");

            if(!$verifica->verificaExistencia()){
                try{
                    if($salvar->inserir()){
                        header("Location: ../includes/administrador.php?link=9");
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
            $apagar = new Crud();
            $apagar->setTabelas("tbl_usuario_sistema");
            $apagar->setCamposTblPesquisa("us_codigo");
            $apagar->setValor_pesquisa("'$id'");
            $dados = $apagar->listarComId();

            $nome = $dados->us_nome;
            $apelido = $dados->us_apelido;
            $cargo = $dados->us_cargo;
            $tipo = $dados->us_tipo;
            $usuario = $dados->us_usuario;
            $senha = $dados->us_senha;
            echo $us_cargo;
        }catch (Exception $e){
            $excecao = $e->getMessage();
        }

        if(isset($_POST['Alterar'])){
            $us_nome = $_POST['us_nome'];
            $us_apelido = $_POST['us_apelido'];
            $us_cargo = $_POST['us_cargo'];
            $us_tipo = $_POST['us_tipo'];
            $us_usuario = $_POST['us_usuario'];
            $us_senha = $_POST['us_senha'];

            $alterar = new Crud();
            $alterar->setTabelas("tbl_usuario_sistema");
            $alterar->setCampos("us_nome = '$us_nome',
                                              us_apelido = '$us_apelido',
                                              us_cargo = '$us_cargo',
                                              us_tipo = '$us_tipo',
                                              us_usuario = '$us_usuario',
                                              us_senha = '$us_senha'");
            $alterar->setCamposTblPesquisa("us_codigo");
            $alterar->setValor_pesquisa("'$id'");

            try{
                if($alterar->alterar()){
                    header("Location: ../includes/administrador.php?link=9");
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
            $apagar = new Crud();
            $apagar->setTabelas("tbl_usuario_sistema");
            $apagar->setCamposTblPesquisa("us_codigo");
            $apagar->setValor_pesquisa("'$id'");
            $dados = $apagar->listarComId();

            $nome = $dados->us_nome;
            $apelido = $dados->us_apelido;
            $cargo = $dados->us_cargo;
            $tipo = $dados->us_tipo;
            $usuario = $dados->us_usuario;
            $senha = $dados->us_senha;
        }catch (Exception $e){
            $excecao = $e->getMessage();
        }

        if(isset($_POST['Apagar'])){
            $apagar = new Crud();
            $apagar->setTabelas("tbl_usuario_sistema");
            $apagar->setCamposTblPesquisa("us_codigo");
            $apagar->setValor_pesquisa("'$id'");
            if($apagar->apagar()){
                header("Location: ../includes/administrador.php?link=9");
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
    <legend><h5 class="txt_azul"><i class="fi-torso"></i> Usuário de Sistema </h5> </legend>
    <form action="" method="post">
        <div class="row">
            <div class="small-12 medium-6 columns">
                <label for="ant_marca">Nome
                    <input type="text" name="us_nome" value="<?php echo $nome; ?>" placeholder="Nome" required><span class="form-error">Campo Obrigatório!</span>
                </label>
                <label for="ant_marca">Apelido
                    <input type="text" name="us_apelido" value="<?php echo $apelido; ?>" placeholder="Apelido" required><span class="form-error">Campo Obrigatório!</span>
                </label>
                <label for="us_cargo">Cargo
                    <select name="us_cargo" required>
                        <option value="">Selecione o Cargo</option>
                        <?php
                        try {
                            $obj_cargo = new Crud();
                            $obj_cargo->setTabelas('tbl_cargos');
                            $dados_cargo = $obj_cargo->listar();
                            $lista_cargo = new ArrayIterator($dados_cargo);

                            while ($lista_cargo->valid()) {
                                ?>
                                <option
                                    value="<?php echo $lista_cargo->current()->carg_codigo; ?>" <?php if ($lista_cargo->current()->carg_codigo == $cargo) echo 'selected'; ?> > <?php echo $lista_cargo->current()->carg_nome; ?></option>
                                <?php
                                $lista_cargo->next();
                            }
                        }catch(Exception $e){
                            $excecao = $e->getMessage();
                        }?>
                    </select><small class="form-error">Campo Obrigatorio</small>
                </label>
                <label for="us_tipo"> Selecione o Tipo Usuário
                    <select name="us_tipo" required>
                        <option value="">Selecione o Cargo</option>
                        <?php
                        try {
                            $obj_tipo_usuario = new Crud();
                            $obj_tipo_usuario->setTabelas('tbl_tipo_usuario');
                            $dados_tipo_usuario = $obj_tipo_usuario->listar();
                            $lista_tipo_usuario = new ArrayIterator($dados_tipo_usuario);

                            while ($lista_tipo_usuario->valid()) {
                                ?>
                                <option
                                    value="<?php echo $lista_tipo_usuario->current()->tpu_codigo; ?>" <?php if ($lista_tipo_usuario->current()->tpu_codigo == $tipo) echo 'selected'; ?> > <?php echo $lista_tipo_usuario->current()->tpu_nome; ?></option>
                                <?php
                                $lista_tipo_usuario->next();
                            }
                        }catch(Exception $e){
                            $excecao = $e->getMessage();
                        }?>
                    </select><small class="form-error">Campo Obrigatorio</small>
                </label>
            </div>
            <div class="small-12 medium-6 columns">
                <fieldset class="fieldset">
                    <legend><h6 class="txt_azul">Dados de Usuário</h6></legend>
                        <label for="us_usuario">Nome de Usuário
                            <input type="text" name="us_usuario" value="<?php echo $usuario; ?>" placeholder="Nome de Usuário" required><span class="form-error">Campo Obrigatório!</span>
                        </label>
                        <label for="us_senha">Senha
                            <input type="text" name="us_senha" value="<?php echo $senha; ?>" placeholder="Senha" required><span class="form-error">Campo Obrigatório!</span>
                        </label>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="small-12 medium-6 columns">
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
                <?php echo ($cancelar != "") ? '<a href="administrador.php?link=9" class="alert button"><i class="fi-x"></i> Cancelar </a>' : "";?>
            </div>
        </div>
    </form>
</fieldset>