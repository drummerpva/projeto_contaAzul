<h1>Vendas</h1>
<?php if ($addPermission) {?>
    <a class="button" href="<?php echo BASE_URL . "sales/add"; ?>">Adicionar Venda</a>
<?php }?>
<table width="100%">
    <tr>
        <th>Cliente</th>
        <th>Data</th>
        <th>Status</th>
        <th>Valor Total</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($salesList as $sL) {?>
    <tr>
        <td><?php echo $sL['nameClient']; ?></td>
        <td><?php echo date("d/m/Y H:i", strtotime($sL['date_sale'])); ?></td>
        <td><?php echo $statuses[$sL['status']]; ?></td>
        <td><?php echo "R$ " . number_format($sL['total_price'], 2, ",", "."); ?></td>
        <td style="text-align:center;" nowrap>
                <a class="button bt-sm bt-yel" href="<?php echo BASE_URL . "sales/edit/" . $sL['Id']; ?>">Editar</a>
                <a class="button bt-sm bt-red" href="<?php echo BASE_URL . "sales/del/" . $sL['Id']; ?>" onclick="return confirm('Deseja realmente exluir?');">Cancelar</a>
        </td>

    </tr>
    <?php }?>
</table>