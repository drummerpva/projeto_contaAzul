<head><title>Relatório de Vendas</title></head>
<body>
<style>
th{
    text-align:left;
}
</style>

<h1>Relatório de Vendas</h1>
<fieldset>
    Itens com estoque abaixo do mínimo
</fieldset>
<br>
<table width="100%">
    <tr>
        <th>Nome</th>
        <th width="120">Preço</th>
        <th width="60" nowrap>Quant.</th>
        <th width="90">Quant. Min</th>
        <th width="90">Diferença</th>

    </tr>
    <?php foreach ($inventoryList as $product) {?>
    <tr>
        <td><?php echo $product['name']; ?></td>
        <td ><?php echo "R$ " . number_format($product['price'], 2, ",", "."); ?></td>
        <td style="<?php echo ($product['quant'] <= $product['min_quant']) ? "color:red;font-weight:bold;" : ""; ?>"><?php echo $product['quant']; ?></td>
        <td ><?php echo $product['min_quant']; ?></td>
        <td ><?php echo $product['dif']; ?></td>

    </tr>
    <?php }?>


</table>
</body>