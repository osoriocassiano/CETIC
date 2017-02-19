<!--/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/21/2016
 * Time: 2:21 PM
 */-->
<script>
$(document).ready(function() {
    oTable =$('#mostrar').DataTable( {
            "pagingType": "full_numbers",
            "dom": 'rtpl'
        } );
        $('#pesq').keyup(function(){
            oTable.search($(this).val()).draw() ;
        })
    } );

//pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said


</script>
<?php
include_once("../Classes/Crud.php");





?>

    <div class="small-12 medium-6 columns">
        <a href="../includes/administrador.php?link=8&ac=" class="small button"><i class="fi-calendar"></i> Novo Registo </a>
    </div>
    <div class="small-12 medium-6 columns">
        <div><input type="text" id="pesq" placeholder="Pesquisa..."/></div>
    </div>
<div class="row">
    <div class="small-12 columns">
        <h5 class="txt_azul"><i class="fi-list"> Dias para Verificar os Dias Remanescentes as Licenças </i> </h5>
        <table id="mostrar" class="hover">
            <thead>
            <tr>
                <th>Dias</th>
                <th class="top-bar-right">Opções</th>
            </tr>
            </thead>
            <tbody>
            <?php
            try {
                $dias_prazo = new Crud();
                $dias_prazo->setTabelas("tbl_dias_remanescentes");
                $dados = $dias_prazo->listar();
                $lista = new ArrayIterator($dados);
                while ($lista->valid()) { ?>
                    <tr>
                        <td><?php echo $lista->current()->dr_nome; ?></td>
                        <td>
                            <ul class="menu top-bar-right">
                                <li><a href="#" class="tiny secondary button "><i class="fi-eye"></i> Detalhes </a>
                                </li>
                                <li>
                                    <a href="../includes/administrador.php?link=8&ac=Alterar&id=<?php echo $lista->current()->dr_codigo; ?>"
                                       class="tiny success button "><i class="fi-check"></i> ALterar </a></li>
                                <li>
                                    <a href="../includes/administrador.php?link=8&ac=Apagar&id=<?php echo $lista->current()->dr_codigo; ?>"
                                       class="tiny alert button "><i class="fi-minus"></i> Apagar </a></li>
                            </ul>
                        </td>
                    </tr>
                    <?php $lista->next();
                }
            }catch(Exception $e) {
                $mensagem = $e->getMessage();
            }?>
            </tbody>
        </table>
    </div>
</div>