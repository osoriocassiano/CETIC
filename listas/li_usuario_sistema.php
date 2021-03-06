﻿<!--/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/21/2016
 * Time: 6:05 PM
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

<div class="row">
    <div class="small-12 medium-7 columns">
        <ul class="menu">
            <li><a href="../includes/administrador.php?link=4&ac=" class="small button"><i class="fi-plus"></i> Usuário & Serial de PC</a></li>
            <li><a href="../includes/administrador.php?link=10&ac=" class="small button"><i class="fi-plus"></i> Usuário Sistema </a></li>
            <li><a href="../includes/administrador.php?link=9&ac=" class="small button"><i class="fi-list"></i> Listar Usuários do Sistema </a></li>
        </ul>
    </div>
    <div class="small-12 medium-5 columns">
        <div><input type="text" id="pesq" placeholder="Pesquisa..."/></div>
    </div>
</div>
<div class="row">
    <div class="small-12 columns">
        <h5 class="txt_azul"><i class="fi-list"> Lista de Usuário do Sistema</i> </h5>
        <table id="mostrar" class="hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Apelido</th>
                <th>Cargo</th>
                <th>Tipo de usuário</th>
                <th>Opções</th>
            </tr>
            </thead>
            <tbody>
            <?php
            try {
                $usuario = new Crud();
                $usuario->setTabelas("tbl_usuario_sistema LEFT JOIN tbl_cargos ON us_cargo = carg_codigo LEFT JOIN tbl_tipo_usuario ON us_tipo = tpu_codigo");
                $dados = $usuario->listar();
                $lista = new ArrayIterator($dados);
                while ($lista->valid()) { ?>
                    <tr>
                        <td><?php echo $lista->current()->us_nome; ?></td>
                        <td><?php echo $lista->current()->us_apelido; ?></td>
                        <td><?php echo $lista->current()->carg_nome; ?></td>
                        <td><?php echo $lista->current()->tpu_nome; ?></td>
                        <td>
                            <ul class="menu">
                                <li><a href="#" class="tiny secondary button "><i class="fi-eye"></i> Detalhes </a></li>
                                <li>
                                    <a href="../includes/administrador.php?link=10&ac=Alterar&id=<?php echo $lista->current()->us_codigo; ?>"
                                       class="tiny success button "><i class="fi-check"></i> ALterar </a></li>
                                <li>
                                    <a href="../includes/administrador.php?link=10&ac=Apagar&id=<?php echo $lista->current()->us_codigo; ?>"
                                       class="tiny alert button "><i class="fi-minus"></i> Apagar </a></li>
                            </ul>
                        </td>
                    </tr>
                    <?php $lista->next();
                }
            }catch(Exception $e){
                $mensagem = $e->getMessage();
            }?>
            </tbody>
        </table>
    </div>
</div>
