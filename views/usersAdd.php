<h1>Usuário - Adicionar</h1>
<?php echo (!empty($errorMsg)) ? "<div class='warn'>$errorMsg</div>":"";?>
<form method="POST">
    <label for="name">Email</label><br/>
    <input type="email" name="email" required id="name"/><br/><br/>
    <label for="senha">Senha</label><br/>
    <input type="password" name="password" required id="senha"/><br/><br/>
    <label>Grupo</label><br/>
    <select name="group">
        <option disabled selected>Selecione</option>
        <?php foreach($groupsList as $gL){?>
            <option value="<?php echo $gL['Id'] ?? "";?>"><?php echo $gL['name'] ?? "";?></option>
        <?php }?>
    </select><br/><br/>
    <input class="bt-gre" type="submit" value="Adicionar"/>
</form>