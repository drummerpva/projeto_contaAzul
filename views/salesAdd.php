<h1>Venda - Adicionar</h1>
<form method="POST">

    <label for="clientName">Cliente</label><br/>
    <input type="text" name="clientName" id="clientName" data-type="searchClients" autocomplete='off'/>
    <input type="hidden" name="clientId" />
    <button class="clientAddButton">+</button><div style="clear:both"></div><br/><br/>
    <label for="status">Status da Venda</label><br/>
    <select name="status" id="status">
        <option value="0">Aguardando Pagamento</option>
        <option value="1">Pago</option>
        <option value="2">Cancelado</option>
    </select><br><br>
    <label for="totalPrice">Total da Venda</label>
    <input type="text" name="totalPrice" id="totalPrice" disabled><br><br>
    <hr/>
    <h4>Produtos</h4>
    <fieldset>
        <legend>Adicionar Produto</legend>
        <input type="text" id="addProd" data-type="searchProducts" autocomplete='off'/>
    </fieldset>
    <table width="100%" id="tableProducts">
        <tr>
            <th>Nome</th>
            <th>Qtde</th>
            <th>Preço Unit.</th>
            <th>Sub-Total</th>
            <th>Excluir</th>
        </tr>
    </table>




    <hr>
    <input type="submit" value="Cadastrar Venda"/>
</form>
<script src="<?php echo BASE_URL . "assets/js/scriptSalesAdd.js"; ?>" type="text/javascript"></script>