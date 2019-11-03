<div class="dbRow">
    <div class="grid-1">
        <div class="dbGridArea">
            <div class="dbGridAreaCount"><?php echo $productsSold; ?></div>
            <div class="dbGridAreadLegend">Produtos Vendidos</div>
        </div>
    </div>
    <div class="grid-1">
        <div class="dbGridArea">
            <div class="dbGridAreaCount"><?php echo "R$ " . number_format($revenue, 2, ",", "."); ?></div>
            <div class="dbGridAreadLegend">Receitas</div>
        </div>
    </div>
    <div class="grid-1">
        <div class="dbGridArea">
            <div class="dbGridAreaCount"><?php echo "R$ " . number_format($expenses, 2, ",", "."); ?></div>
            <div class="dbGridAreadLegend">Despesas</div>
        </div>
    </div>
</div>
<div class="dbRow">
    <div class="grid-2">
        <div class="dbInfo">
            <div class="dbInfoTitle">Despesas e Receitas dos últimos 30 dias</div>
            <div class="dbInfoBody" style="height:326px">
                <canvas id="rel1" style="max-height:100% !important"></canvas>
            </div>
        </div>
    </div>
    <div class="grid-1">
        <div class="dbInfo">
            <div class="dbInfoTitle">Status de Pagamentos</div>
            <div class="dbInfoBody" style="height:326px">
                <canvas id="rel2" style="max-height:100% !important"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    var daysList = <?php echo json_encode($daysList); ?>;
    var revenueList = <?php echo json_encode(array_values($revenueList)); ?>;
    var expensesList = <?php echo json_encode(array_values($expensesList)); ?>;
    var statusName = <?php echo json_encode(array_values($statuses)); ?>;
    var statusValues = <?php echo json_encode(array_values($paymentsList)); ?>;

</script>
<script src="<?php echo BASE_URL . "assets/js/Chart.min.js"; ?>"></script>
<script src="<?php echo BASE_URL . "assets/js/scriptHome.js"; ?>"></script>