<h1>Estoque</h1>
<?php if ($addPermission) {?>
    <a class="button" href="<?php echo BASE_URL . "inventory/add"; ?>">Adicionar Produto</a>
<?php }?>
<input type="text" id="busca" data-type="searchInventory"/>
<table width="100%">
    <tr>
        <th>Nome</th>
        <th width="100">Preço</th>
        <th width="60" nowrap>Quant.</th>
        <th width="90">Quant. Min</th>
        <th width="170">Ações</th>
    </tr>
    <?php foreach ($inventoryList as $product) {?>
    <tr>
        <td><?php echo $product['name']; ?></td>
        <td style="text-align:right"><?php echo "R$ " . number_format($product['price'], 2, ",", "."); ?></td>
        <td style="text-align:center; <?php echo ($product['quant'] <= $product['min_quant']) ? "color:red;font-weight:bold;": ""; ?>"><?php echo $product['quant']; ?></td>
        <td style="text-align:center"><?php echo $product['min_quant']; ?></td>
        <td style="text-align:center"><?php if ($editPermission) {?>
                <a  class="button bt-sm bt-yel" href="<?php echo BASE_URL . "inventory/edit/" . $product['Id']; ?>">Editar</a>
                <a class="button bt-sm bt-red" href="<?php echo BASE_URL . "inventory/del/" . $product['Id']; ?>" onclick="return confirm('Deseja realmente exluir?');">Excluir</a>
            <?php } else {?>
                <a  class="button bt-sm" href="<?php echo BASE_URL . "inventory/view/" . $product['Id']; ?>">Ver Detalhes</a>
            <?php }?>
        </td>

    </tr>
    <?php }?>


</table>