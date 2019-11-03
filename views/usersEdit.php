<h1>Usuário - Editar</h1>
<?php echo (!empty($errorMsg)) ? "<div class='warn'>$errorMsg</div>":"";?>
<form method="POST">
    <label for="name">Email</label><br/>
    <input value="<?php echo $userInfo['email']??"";?>" type="email" name="" required id="name" disabled/><br/><br/>
    <label for="senha">Senha</label><br/>
    <input type="password" name="password" id="senha"/><br/><br/>
    <label>Grupo</label><br/>
    <select name="group">
        <option disabled >Selecione</option>
        <?php foreach($groupsList as $gL){?>
            <option <?php echo ($gL['Id'] == $userInfo['group']) ?"selected":"";?> value="<?php echo $gL['Id'] ?? "";?>"><?php echo $gL['name'] ?? "";?></option>
        <?php }?>
    </select><br/><br/>
    <input class="bt-gre" type="submit" value="Salvar"/>
</form>