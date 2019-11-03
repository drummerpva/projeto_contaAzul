<h1>Produto - Adicionar</h1>
<?php echo (!empty($errorMsg)) ? "<div class='warn'>$errorMsg</div>" : ""; ?>
<form method="POST">
    <label for="name">Nome</label><br/>
    <input type="text" name="name" required id="name"/><br/><br/>

    <label for="price">Preço</label><br/>
    <input type="text" name="price" required id="price"/><br/><br/>

    <label for="quant">Quantidade em estoque</label><br/>
    <input type="number" name="quant" required id="quant"/><br/><br/>

    <label for="minQuant">Quantidade mínima</label><br/>
    <input type="number" name="minQuant" required id="minQuant"/><br/><br/>


    <input class="bt-gre" type="submit" value="Adicionar"/>
</form>
<script type="text/javascript" src="<?php echo BASE_URL."assets/js/";?>sciptInventoryAdd.js"></script>