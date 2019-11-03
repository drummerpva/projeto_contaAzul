<?php //print_r($groupInfo);
//exit;?>
<h1>Permissões - Editar Grupo</h1>
<form method="POST">
    <label for="name">Nome do Grupo</label><br/>
    <input type="text" name="name" required id="name" value="<?php echo $groupInfo['name'] ?? ""; ?>"/><br/><br/>
    <label>Permissões</label><br/>
    <?php foreach ($permissionsList as $p) { ?>
        <div class=".pItem">
            <label for="perm<?php echo $p['Id'] ?>">
                <input  <?php echo (in_array($p['Id'],$groupInfo['params']))?"checked":"";?> id="perm<?php echo $p['Id']; ?>" type="checkbox" name="permissions[]" value="<?php echo $p['Id'] ?>">
                <?php echo $p['name']; ?>
            </label>
        </div>
    <?php } ?>
    <br/><br/>
    <input class ="bt-gre" type="submit" value="Salvar"/>
</form>