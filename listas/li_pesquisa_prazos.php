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
/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/11/2016
 * Time: 2:23 PM
 */
include('../Classes/Classe_pesquisa.php');
include('../Classes/Crud.php');
//recebemos nosso parâmetro vindo do form

if(!empty($_GET['prazo_post'])) {

    $dias_restantes = $_GET['prazo_post'];
    $tabela = "tbl_antivirus_pc INNER JOIN tbl_usuario_computador";
    $condicao_on = "apc_serial_pc = uc_serial";
    $clausula_where = "((apc_validade-DATEDIFF(CURDATE(), apc_data_registo)) > 0 && (apc_validade-DATEDIFF(CURDATE(), apc_data_registo)) < $dias_restantes) ORDER BY apc_data_vencimento ASC";


    ?>

    <h5 class="txt_azul"><i class="fi-results"></i> Serial com menos de <?php echo $dias_restantes; ?>dias </h5>

    <table id="mostrar" class="hover">
        <thead>
        <tr>
            <th>Serial do Antivirus</th>
            <th>Nome do Usuario</th>
            <th>Serial do PC</th>
            <th>Data-Vencimento</th>
            <th>Opcoes</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try {
            $pesquisa_prazo = new Pesquisa();

            if ($pesquisa_prazo->numeroDeRegistos_dias_restantes($dias_restantes, $tabela, $condicao_on, $clausula_where)) {
                $dados = $pesquisa_prazo->pesquisa_dias_restantes($dias_restantes, $tabela, $condicao_on, $clausula_where);
                $lista = new ArrayIterator($dados);
                while ($lista->valid()) { ?>
                    <?php
                    $data_hoje = strtotime(date('y-m-d'));
                    $data_registo = strtotime($lista->current()->apc_data_registo);
                    $validade = $lista->current()->apc_validade;
                    $resultado = $validade-($data_hoje-$data_registo)/86400;
                    ?>
                    <tr <?php
                        $obj_cor = new Crud();
                        $obj_cor->setTabelas("tbl_dias_remanescentes ORDER BY dr_nome ASC");
                        $dados_cor = $obj_cor->listar();
                        $lista_cor = new ArrayIterator($dados_cor);
                        while($lista_cor->valid()){
                            $vector[] = $lista_cor->current()->dr_nome;
                            $lista_cor->next();
                        }
                        for($i=0; $i<count($vector); $i++){
                            if($resultado<0){
                                echo 'style="color:red"';
                            }
                            elseif($resultado<$vector[$i]){
                                echo 'style="color:green"';
                            }

                    }?>>
                        <td><?php echo $lista->current()->apc_serial_antiv; ?></td>
                        <td><?php echo $lista->current()->uc_nome; ?></td>
                        <td><?php echo $lista->current()->uc_serial; ?></td>
                        <td><?php echo $lista->current()->apc_data_vencimento; ?></td>
                        <td>
                            <ul class="menu">
                                <li><a href="../includes/administrador.php?link=11&ac=detalhes&id=<?php echo $lista->current()->apc_codigo; ?>" class="tiny secondary button "><i class="fi-eye"></i> Detalhes </a>
                                </li>
                                <li>
                                    <a href="../includes/administrador.php?link=2&ac=Alterar&id=<?php echo $lista->current()->apc_codigo; ?>"
                                       class="tiny success button "><i class="fi-check"></i> ALterar </a></li>
                                <li><a href="#" class="tiny alert button "><i class="fi-x"></i> Apagar </a></li>
                            </ul>
                        </td>
                    </tr>
                    <?php $lista->next();
                }
            }
        } catch (Exception $e) {
            $mensagem = $e->getMessage();
        } ?>
        </tbody>
    </table>
    <div class="espaco-vertical"></div>
    <div class="row">
        <div class="small-12 columns">
            Legenda:
            <ul class="menu">
                <li>
                    <span class="tiny button" style="background-color: black; color: #fff; margin-top: 0.3875rem">Prazo Maior</span>
                </li>
                <li>
                    <span class="tiny button" style="background-color: green; color: #fff; margin-top: 0.3875rem">Dentro do prazo</span>
                </li>
                <li>
                    <span class="tiny button" style="background-color: red; color: #fff; margin-top: 0.3875rem">Fora do Prazo</span>
                </li>
            </ul>


        </div>
    </div>

    <?php
}
?>