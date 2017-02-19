<!---
/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/14/2016
 * Time: 10:43 PM
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

$antivirus = new Crud();
$antivirus->setTabelas("tbl_marca_antiv");



?>

    <div class="small-12 medium-6 columns">
        <a href="../includes/administrador.php?link=6&ac=" class="small button"><i class="fi-plus"></i> Marca Antivírus </a>
    </div>
    <div class="small-12 medium-6 columns">
        <div><input type="text" id="pesq" placeholder="Pesquisa..."/></div>
    </div>
<div class="row">
    <div class="small-12 columns">
        <table id="mostrar" class="hover">
            <thead>
            <tr>
                <th>Marca</th>
                <th class="top-bar-right">Opções</th>
            </tr>
            </thead>
            <tbody>
            <?php
                try {
                     $dados = $antivirus->listar();
                     $lista = new ArrayIterator($dados);
                         while ($lista->valid()) { ?>
                            <tr>
                                <td><?php echo $lista->current()->mar_ant_nome; ?></td>
                                <td>
                                    <ul class="menu top-bar-right">
                                        <li><a href="#" class="tiny secondary button "><i class="fi-eye"></i> Detalhes </a>
                                        </li>
                                        <li>
                                            <a href="../includes/administrador.php?link=6&ac=Alterar&id=<?php echo $lista->current()->mar_ant_codigo; ?>"
                                               class="tiny success button "><i class="fi-check"></i> ALterar </a></li>
                                        <li>
                                            <a href="../includes/administrador.php?link=6&ac=Apagar&id=<?php echo $lista->current()->mar_ant_codigo; ?>"
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