
<!--/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/22/2016
 * Time: 1:02 AM
 */-->
<script>
$(document).ready(function() {
    $('#mostrar').DataTable( {
            "pagingType": "full_numbers",
            "dom": 'rtpl'
        } );
    } );

oTable = $('#mostrar').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
$('#pesq').keyup(function(){
    oTable.search($(this).val()).draw() ;
})

</script>
<?php
$serial_antivirus = "";
$serial_pc = "";
$usuario_pc = "";
$data_vencimento = "";
$responsavel_registo = "";
$ultima_actualizacao = "";
    if(isset($_GET['ac'])){
        if($_GET['ac'] == "detalhes"){
            $id = $_GET['id'];
            try{
                $detalhes = new Crud();
                $detalhes->setTabelas("tbl_antivirus_pc LEFT JOIN tbl_usuario_computador ON apc_serial_pc = uc_serial LEFT JOIN tbl_usuario_sistema ON apc_responsavel_registo = us_codigo");
                $detalhes->setCamposTblPesquisa("apc_codigo");
                $detalhes->setValor_pesquisa("'$id'");
                $dados = $detalhes->listarComId();

                $serial_antivirus = $dados->apc_serial_antiv;
                $serial_pc = $dados->apc_serial_pc;
                $usuario_pc = $dados->uc_nome;
                $data_vencimento = $dados->apc_data_vencimento;
                $responsavel_registo = $dados->us_nome." ".$dados->us_apelido;
                $ultima_actualizacao = $dados->apc_ultima_actualizacao;

            }catch (Exception $e){
                $excecao = $e->getMessage();
            }
        }
    }
?>
<fieldset class="fieldset">
    <legend> <h2 class="txt_azul"><i class="fi-info"> Informações sobre o registo </i> </h2></legend>
            <label>
                <h6 class="txt_azul"> Serial do Antivírus: </h6>
                <div class="small-12" style="background-color: whitesmoke; color: darkslategray">
                    <?php echo $serial_antivirus; ?>
                </div>
            </label>
            <label>
                <h6 class="txt_azul"> Serail do Computador:</h6>
                <div class="small-12" style="background-color: whitesmoke; color: darkslategray">
                    <?php echo $serial_pc; ?>
                </div>
            </label>
            <label>
                <h6 class="txt_azul">Usuário do PC onde fez-se o uso da Licença do Antivírus:</h6>
                <div class="small-12" style="background-color: whitesmoke; color: darkslategray">
                    <?php echo $usuario_pc; ?>
                </div>
            </label>
            <label>
                <h6 class="txt_azul"> Data de vencimento da Licença do Antivírus;</h6>
                <div class="small-12" style="background-color: whitesmoke; color: darkslategray">
                    <?php echo $data_vencimento; ?>
                </div>
            </label>
            <label>
                <h6 class="txt_azul"> Responsável pelo registo no sistema:</h6>
                <div class="small-12" style="background-color: whitesmoke; color: darkslategray">
                    <?php echo $responsavel_registo; ?>
                </div>
            </label>
            <label>
                <h6 class="txt_azul"> Ultima atualização em:</h6>
                <div class="small-12" style="background-color: whitesmoke; color: darkslategray">
                    <?php echo $ultima_actualizacao; ?>
                </div>
            </label>
			<a href="../includes/administrador.php?link=1" class="secondary button"><i class="fi-arrow-left"></i> Voltar</a>
        </div>
</fieldset>