<?php
/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/11/2016
 * Time: 2:25 PM
 */
include_once('Conexao.php');
class Crud{
    protected $tabelas;
    protected $campos;
    protected $dados;
    protected $tabelas_verif_nomes;
    protected $camp_verif_nomes;
    protected $camp_tbl_pesquisa;
    protected $valor_pesquisa;
    protected $campo_like;

    public function setTabelas($tbl){
        $this->tabelas = $tbl;
    }
    public function setCampos($campo){
        $this->campos = $campo;
    }
    public function setCamposTblPesquisa($c_tbl_pesquisa){
        $this->camp_tbl_pesquisa = $c_tbl_pesquisa;
    }
    public function setDados($dado){
        $this->dados = $dado;
    }
    public function setValor_pesquisa($valor_pes){
        $this->valor_pesquisa = $valor_pes;
    }

    public function listar(){
        $pdo = conectarPdo();

            $listar = $pdo->query("SELECT * FROM $this->tabelas");
            $listar->execute();
            if($listar->rowCount() > 0){
                return $listar->fetchALL(PDO::FETCH_OBJ);
            }
            else{
                throw new Exception ("Sem Registos!");
            }
    }

    public function listarComId(){
        $pdo = conectarPdo();

            $listar = $pdo->query("SELECT * FROM $this->tabelas WHERE $this->camp_tbl_pesquisa = $this->valor_pesquisa");
            $listar->execute();
            if($listar->rowCount() > 0){
                return $listar->fetch(PDO::FETCH_OBJ);;
            }
            else{
                throw new exception ("Sem Registos!");
            }
    }

    public function numeroDeRegistos_permanente_r_a_pc($tabela, $condicao_on, $clausula_where){
        $pdo = conectarPdo();

        try{
            $pesquisa = $pdo->prepare("SELECT * FROM $tabela ON $condicao_on WHERE $clausula_where");
            $pesquisa->execute();

            if($pesquisa->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function mostra_permanente_r_a_pc($tabela, $condicao_on, $clausula_where){
        $pdo = conectarPdo();

        try{
            $pesquisa = $pdo->prepare("SELECT * FROM $tabela ON $condicao_on WHERE $clausula_where");
            $pesquisa->execute();

            if($pesquisa->rowCount() > 0){
                return $pesquisa->fetchALL(PDO::FETCH_OBJ);
            }
            else{
                throw new exception ("Sem Dados para exibir");
            }
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function verificaExistencia(){
        $pdo = conectarPdo();

        $verifica = $pdo->prepare("SELECT * FROM $this->tabelas WHERE $this->campos");
        $verifica->execute();
        if($verifica->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function inserir(){
        $pdo = conectarPdo();

        try{
            $inserir = $pdo->prepare("INSERT INTO $this->tabelas ($this->campos) VALUES($this->dados)");
            $inserir->execute();

            if($inserir->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }

        }catch(PDOException $e){
            echo "Erro: ". $e->getMessage();
        }

    }

    public function alterar(){
        $pdo = conectarPdo();

        try{
            $alterar = $pdo->prepare("UPDATE $this->tabelas SET $this->campos WHERE $this->camp_tbl_pesquisa = $this->valor_pesquisa");
            $alterar->execute();

            if($alterar->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }

        }catch(PDOException $e){
            echo "Erro: ". $e->getMessage();
        }

    }

    public function apagar(){

        $pdo = conectarPdo();

        try{
            $excluir = $pdo->prepare("DELETE FROM $this->tabelas WHERE $this->camp_tbl_pesquisa = $this->valor_pesquisa");
            $excluir->execute();

            if($excluir->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }
            /* SEM NECESSIDADE DO ELSE PORQ EH GERADO O ERRO MYSQL 2300 QUE NAO PERMITE PEGAR O CONTEUDO DENTRO DO ELSE*/
        }catch(PDOException $e){
            if ($e->getCode() == 23000) {
                //$e->getMessage();
                return false;
            }
        }
    }

}
function logar($usuario, $senha){
    $pdo = conectarPdo();


    $logar_Ad = $pdo->prepare("SELECT * FROM tbl_usuario_sistema WHERE us_usuario =:usuario AND us_senha =:senha AND us_tipo = :tipo");
    $logar_Ad->bindValue(":usuario", $usuario);
    $logar_Ad->bindValue(":senha", $senha);
    $logar_Ad->bindValue(":tipo", 1);
    $logar_Ad->execute();

    if($logar_Ad->rowCount() > 0){
        $dados = $logar_Ad->fetch(PDO::FETCH_OBJ);
        $_SESSION['usuario'] = true;
        $_SESSION['us_usuario'] = $dados->us_usuario;
        $_SESSION['us_codigo'] = $dados->us_codigo;
        header('Location: includes/administrador.php');

    }
    else{
        $logar_Op = $pdo->prepare("SELECT * FROM tbl_usuario_sistema WHERE us_usuario =:usuario AND us_senha =:senha AND us_tipo = :tipo");
        $logar_Op->bindValue(":usuario", $usuario);
        $logar_Op->bindValue(":senha", $senha);
        $logar_Op->bindValue(":tipo", 2);
        $logar_Op->execute();

        if($logar_Op->rowCount() > 0){
            $dados = $logar_Op->fetch(PDO::FETCH_OBJ);
            $_SESSION['usuario'] = true;
            $_SESSION['us_usuario'] = $dados->us_usuario;
            header('Location: includes/operador.php');
        }
        else{
            throw new Exception ('Dados incorretos!');
            //throw new exception ("Usuario nao existente!");
        }
    }

}

function logOut($sessao){
    if(isset($sessao)){
        unset($_SESSION[$sessao]);
        session_destroy();
        header('Location: ../index.php');
    }
}

