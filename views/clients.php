<h1>Clientes</h1>
<?php if ($editPermission) {?>
    <a class="button" href="<?php echo BASE_URL . "clients/add"; ?>">Adicionar Cliente</a>
<?php }?>
<input type="text" id="busca" data-type="searchClients"/>
<table width="100%">
    <tr>
        <th>Nome</th>
        <th width="100">Telefone</th>
        <th width="150" nowrap>Cidade</th>
        <th width="50">Avaliação</th>
        <th width="170">Ações</th>
    </tr>
    <?php foreach ($clientsList as $uL) {?>
        <tr>
            <td><?php echo $uL['name']; ?></td>
            <td><?php echo $uL['phone']; ?></td>
            <td><?php echo $uL['address_city']; ?></td>
            <td style="text-align:center;"><?php echo $uL['stars']; ?></td>
            <td style="text-align:center;"><?php if ($editPermission) {?>
                <a  class="button bt-sm bt-yel" href="<?php echo BASE_URL . "clients/edit/" . $uL['Id']; ?>">Editar</a>
                <a class="button bt-sm bt-red" href="<?php echo BASE_URL . "clients/del/" . $uL['Id']; ?>" onclick="return confirm('Deseja realmente exluir?');">Excluir</a>
            <?php } else {?>
                <a  class="button bt-sm" href="<?php echo BASE_URL . "clients/view/" . $uL['Id']; ?>">Ver Detalhes</a>
            <?php }?>
            </td>
        </tr>
    <?php }?>
</table>
<div class="pagination">
    <?php for ($q = 1; $q <= $pCount; $q++) {?>
        <div class="pagItem <?php echo ($pag == $q) ? "pagActive":"";?>"><a href="<?php echo BASE_URL."clients?p=".$q;?>"><?php echo $q; ?></a></div>
    <?php }?>
    <div style="clear:both"></div>
</div>
