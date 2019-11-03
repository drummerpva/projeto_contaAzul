<h1>Usuário - Editar</h1>
<?php echo (!empty($errorMsg)) ? "<div class='warn'>$errorMsg</div>" : ""; ?>
<form method="POST">
    <label for="name">Nome</label><br/>
    <input value="<?php echo $clientInfo['name'] ?? "";?>" type="text" name="name" required id="name"/><br/><br/>
    <label for="email">Email</label><br/>
    <input value="<?php echo $clientInfo['email'] ?? "";?>" type="email" name="email" id="email"/><br/><br/>
    <label for="phone">Telefone</label><br/>
    <input value="<?php echo $clientInfo['phone'] ?? "";?>" type="tel" name="phone" id="phone"/><br/><br/>
    <label for="stars">Estrelas</label><br/>
    <select name="stars" id="stars">
        <option value="1" <?php echo ($clientInfo['stars'] == '1') ?"selected":""; ?>>1 Estrela</option>
        <option value="2" <?php echo ($clientInfo['stars'] == '2') ?"selected":""; ?>>2 Estrelas</option>
        <option value="3" <?php echo ($clientInfo['stars'] == '3') ?"selected":""; ?>>3 Estrelas</option>
        <option value="4" <?php echo ($clientInfo['stars'] == '4') ?"selected":""; ?>>4 Estrelas</option>
        <option value="5" <?php echo ($clientInfo['stars'] == '5') ?"selected":""; ?>>5 Estrelas</option>
    </select><br/><br/>
    <label for="obsI">Observações Internas</label><br/>
    <textarea name="internalObs" id="obsI"><?php echo $clientInfo['internal_obs'] ?? "";?></textarea><br/><br/>
    <label for="addressZipCode">CEP</label><br>
    <input value="<?php echo $clientInfo['address_zipcode'] ?? "";?>" type="tel" name="addressZipCode" id="addressZipCode"><br><br>   
    <label for="address">Rua</label><br>
    <input value="<?php echo $clientInfo['address'] ?? "";?>" type="text" name="address" id="address"><br><br>   
    <label for="addressNumber">Número</label><br>
    <input value="<?php echo $clientInfo['addressNumber'] ?? "";?>" type="text" name="addressNumber" id="addressNumber"><br><br>   
    <label for="address2">Complemento</label><br>
    <input value="<?php echo $clientInfo['address2'] ?? "";?>" type="text" name="address2" id="address2"><br><br>   
    <label for="addressNeighb">Bairro</label><br>
    <input value="<?php echo $clientInfo['address_neighb'] ?? "";?>" type="text" name="addressNeighb" id="addressNeighb"><br><br>   
    <label for="addressCity">Cidade</label><br>
    <input value="<?php echo $clientInfo['address_city'] ?? "";?>" type="text" name="addressCity" id="addressCity"><br><br>   
    <label for="addressState">Estado</label><br>
    <input value="<?php echo $clientInfo['address_state'] ?? "";?>" type="text" name="addressState" id="addressState"><br><br>   
    <label for="addressCountry">País</label><br>
    <input value="<?php echo $clientInfo['address_country'] ?? "";?>" type="text" name="addressCountry" id="addressCountry"><br><br>   

    <input class="bt-gre" type="submit" value="Salvar"/>
</form>
<script type="text/javascript" src="<?php echo BASE_URL."assets/js/scriptClientAdd.js";?>"></script>