<?php
/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/11/2016
 * Time: 2:23 PM
 */
include('Conexao.php');
class Pesquisa{
    protected $tabelas;
    protected $tabelas1;
    protected $campos;
    protected $dados;
    protected $camp_tbl_pesquisa;
    protected $campo_like;
    protected $campo_like1;
    protected $campo_like2;
    protected $campo_like3;
    protected $valor_pesquisa;
    protected $campo_ordenacao;
    protected $situacao_excluir;
    protected $offset;
    protected $rows;

    public function setTabelas($tbl){
        $this->tabelas = $tbl;
    }
    public function setTabelas1($tbl1){
        $this->tabelas1 = $tbl1;
    }
    public function setCampos($campo){
        $this->campos = $campo;
    }
    public function setDados($dado){
        $this->dados = $dado;
    }
    public function setCampos_tbl_pesquisa($camp_pes){
        $this->camp_tbl_pesquisa = $camp_pes;
    }
    public function setValor_pesquisa($valor_pes){
        $this->valor_pesquisa = $valor_pes;
    }
    public function setCampoLike($campo_li){
        $this->campo_like = $campo_li;
    }
    public function setCampoLike1($campo_li1){
        $this->campo_like1 = $campo_li1;
    }
    public function setCampoLike2($campo_li2){
        $this->campo_like2 = $campo_li2;
    }
    public function setCampoLike3($campo_li3){
        $this->campo_like3 = $campo_li3;
    }
    public function setCampoOrdenacao($campo_ord){
        $this->campo_ordenacao = $campo_ord;
    }

    public function pesquisa(){
        $pdo = conectarPdo();

        try{
            $pesquisa = $pdo->prepare("select * from $this->tabelas ON $this->camp_tbl_pesquisa AND ($this->campo_like LIKE $this->valor_pesquisa OR $this->campo_like1 LIKE $this->valor_pesquisa OR $this->campo_like2 LIKE $this->valor_pesquisa OR $this->campo_like2 LIKE $this->valor_pesquisa OR $this->campo_like3 LIKE $this->valor_pesquisa) ORDER BY $this->campo_ordenacao ASC");
            $pesquisa->execute();

            if($pesquisa->rowCount() > 0){
                return $pesquisa->fetchALL(PDO::FETCH_OBJ);
            }
            else{
                return false;
            }
        }catch(PDOException $e){
            //$e->getMessage();
        }
    }

    public function pesquisa_bairro(){
        $pdo = conectarPdo();

        try{
            $pesquisa = $pdo->prepare("select * from $this->tabelas WHERE $this->camp_tbl_pesquisa LIKE $this->campo_like ORDER BY $this->campo_ordenacao");
            $pesquisa->execute();

            if($pesquisa->rowCount() > 0){
                return $pesquisa->fetchALL(PDO::FETCH_OBJ);
            }
            else{
                return false;
            }
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    public function numeroDeRegistos_bairro(){
        $pdo = conectarPdo();

        try{
            $pesquisa = $pdo->prepare("select * from $this->tabelas WHERE $this->camp_tbl_pesquisa LIKE $this->campo_like");
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


    public function numeroDeRegistos(){
        $pdo = conectarPdo();

        try{
            $pesquisa = $pdo->prepare("select * from $this->tabelas ON $this->camp_tbl_pesquisa AND ($this->campo_like LIKE $this->valor_pesquisa OR $this->campo_like1 LIKE $this->valor_pesquisa OR $this->campo_like2 LIKE $this->valor_pesquisa OR $this->campo_like3 LIKE $this->valor_pesquisa) ORDER BY $this->campo_ordenacao");
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

    public function numeroDeRegistos_dias_restantes($dias_restantes, $tabela, $condicao_on, $clausula_where){
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



    public function pesquisa_dias_restantes($dias_restantes, $tabela, $condicao_on, $clausula_where){
        $pdo = conectarPdo();

        try{
            $pesquisa = $pdo->prepare("SELECT * FROM $tabela ON $condicao_on WHERE $clausula_where");
            $pesquisa->execute();

            if($pesquisa->rowCount() > 0){
                return $pesquisa->fetchALL(PDO::FETCH_OBJ);
            }
            else{
                throw new exception ("Sem registos!");
            }
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

}


?>