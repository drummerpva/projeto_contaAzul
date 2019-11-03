<head><title>Relatório de Vendas</title></head>
<body>
<style>
th{
    text-align:left;
}
</style>

<h1>Relatório de Vendas</h1>
<fieldset>
<?php if (!empty($filters['clientName'])) {
    echo "Filtrado pelo cliente:". ($filters['clientName'] ?? "")."</br>";
}
if (!empty($filters['period1']) && !empty($filters['period2'])) {
    echo "No período:". date("d/m/Y",strtotime($filters['period1']))." até ".date("d/m/Y",strtotime($filters['period2']))."</br>";
}
if ($filters['status'] != "") {
    echo "Filtrado com status: ".$statuses[$filters['status']];
}?>
</fieldset>
<br>
<table width="100%">
    <tr>
        <th>Cliente</th>
        <th>Data</th>
        <th>Status</th>
        <th>Valor Total</th>
    </tr>
    <?php foreach ($salesList as $sL) {?>
    <tr>
        <td><?php echo $sL['nameClient']; ?></td>
        <td><?php echo date("d/m/Y H:i", strtotime($sL['date_sale'])); ?></td>
        <td><?php echo $statuses[$sL['status']]; ?></td>
        <td><?php echo "R$ " . number_format($sL['total_price'], 2, ",", "."); ?></td>

    </tr>
    <?php }?>
</table>
</body>