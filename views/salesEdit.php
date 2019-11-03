<h1>Venda - Editar</h1>
<b>Nome do Cliente:</b><br>
<?php echo $salesInfo['info']['clientName']; ?><br><br>
<b>Data da Venda: <br>
</b><?php echo date("d/m/Y", strtotime($salesInfo['info']['date_sale'])); ?><br><br>
<b>Total da Venda: <br>
</b><?php echo "R$ " . number_format($salesInfo['info']['total_price'], 2, ",", "."); ?><br><br>
<b>Status da Venda: </b><br>
<?php if ($permissionEdit) {?>
<form method="post">
<select name="status" id="status">
    <?php foreach ($statuses as $key => $value) {?>
        <option value="<?php echo $key; ?>" <?php echo ($salesInfo['info']['status'] == $key) ? "selected" : ""; ?>><?php echo $value; ?></option>
    <?php }?>
    </select><br><br>
    <input type="submit" value="Salvar">

</form>
<?php } else {
    echo $statuses[$salesInfo['info']['status']];
}?>
<hr/>
<table width="100%">
    <tr>
        <td>Produto</td>
        <td width="150">Quantidade</td>
        <td width="150" >Preço Unitário</td>
        <td width="150" >Total</td>
    </tr>
    <?php foreach ($salesInfo['products'] as $prod) {?>
        <tr>
            <td><?php echo $prod['productName']; ?></td>
            <td><?php echo $prod['quant']; ?></td>
            <td><?php echo "R$ " . number_format($prod['sale_price'], 2, ",", "."); ?></td>
            <td><?php echo "R$ " . number_format($prod['sale_price'] * $prod['quant'], 2, ",", "."); ?></td>
        </tr>
    <?php }?>
    <tr>
        <td colspan="3" style="text-align:right;">Total</td>
        <td><?php echo "R$ " . number_format($salesInfo['info']['total_price'], 2, ",", "."); ?></td>
    </tr>
</table>

<script src="<?php echo BASE_URL . "assets/js/scriptSalesAdd.js"; ?>" type="text/javascript"></script>