<h1>Usuário - Adicionar</h1>
<?php echo (!empty($errorMsg)) ? "<div class='warn'>$errorMsg</div>" : ""; ?>
<form method="POST">
    <label for="name">Nome</label><br/>
    <input type="text" name="name" required id="name"/><br/><br/>
    <label for="email">Email</label><br/>
    <input type="email" name="email" id="email"/><br/><br/>
    <label for="phone">Telefone</label><br/>
    <input type="tel" name="phone" id="phone"/><br/><br/>
    <label for="stars">Estrelas</label><br/>
    <select name="stars" id="stars">
        <option value="1">1 Estrela</option>
        <option value="2">2 Estrelas</option>
        <option value="3" selected>3 Estrelas</option>
        <option value="4">4 Estrelas</option>
        <option value="5">5 Estrelas</option>
    </select><br/><br/>
    <label for="obsI">Observações Internas</label><br/>
    <textarea name="internalObs" id="obsI"></textarea><br/><br/>
    <label for="addressZipCode">CEP</label><br>
    <input type="tel" name="addressZipCode" id="addressZipCode"><br><br>   
    <label for="address">Rua</label><br>
    <input type="text" name="address" id="address"><br><br>   
    <label for="addressNumber">Número</label><br>
    <input type="text" name="addressNumber" id="addressNumber"><br><br>   
    <label for="address2">Complemento</label><br>
    <input type="text" name="address2" id="address2"><br><br>   
    <label for="addressNeighb">Bairro</label><br>
    <input type="text" name="addressNeighb" id="addressNeighb"><br><br>   
    <label for="addressCity">Cidade</label><br>
    <input type="text" name="addressCity" id="addressCity"><br><br>   
    <label for="addressState">Estado</label><br>
    <input type="text" name="addressState" id="addressState"><br><br>   
    <label for="addressCountry">País</label><br>
    <input type="text" name="addressCountry" id="addressCountry"><br><br>   

    <input class="bt-gre" type="submit" value="Adicionar"/>
</form>
<script type="text/javascript" src="<?php echo BASE_URL."assets/js/scriptClientAdd.js";?>"></script>