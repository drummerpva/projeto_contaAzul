<h1>Relatório de Vendas</h1>
<form onsubmit="return openPopup(this);">
    <div class="reportGrid4">
        Nome do Cliente: <br>
        <input type="text" name="clientName">
    </div>
    <div class="reportGrid4">
        Periodo: <br>
        <input type="date" name="period1"><br>
        até<br>
        <input type="date" name="period2"><br>
    </div>
    <div class="reportGrid4">
        Status da Venda: <br>
        <select name="status">
            <option selected value="">Todos os Status</option>
            <?php foreach ($statuses as $k => $v) {?>
                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
            <?php }?>
        </select>
    </div>
    <div class="reportGrid4">
        Ordernação: <br>
        <select name="order">
            <option value="dateDesc">Mais Recente</option>
            <option value="dateAsc">Mais Antigo</option>
            <option value="status">Status da Venda</option>
        </select>
    </div>

    <div style="clear:both"></div>
    <div style="text-align:center;">
        <input type="submit" value="Gerar Relatório">
    </div>
</form>
<script type="text/javascript" src="<?php echo BASE_URL."assets/js/reportSales.js"?>"></script>