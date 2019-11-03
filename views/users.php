<h1>Usuários</h1>
<a class="button" href="<?php echo BASE_URL . "users/add"; ?>">Adicionar Usuário</a>
<table width="100%">
    <tr>
        <th>Usuário</th>
        <th>Grupo</th>
        <th width="170">Ações</th>
    </tr>
    <?php foreach($usersList as $uL){?>
        <tr>
            <td><?php echo $uL['email'];?></td>
            <td><?php echo $uL['groupName'];?></td>
            <td>
                <a href="<?php echo BASE_URL."users/edit/".$uL['Id'];?>">Editar</a>
                <a href="<?php echo BASE_URL."users/del/".$uL['Id'];?>">Excluir</a>
            </td>
        </tr>
    <?php } ?>
</table>