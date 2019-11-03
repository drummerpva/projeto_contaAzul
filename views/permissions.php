<h1>Permissões</h1>
<div class="tabArea">
    <div class="tabItem activeTab">Grupos de Permissões</div>
    <div class="tabItem">Permissões</div>
</div>
<div class="tabContent">
    <div class="tabBody" style="display:block;">
        <a class="button" href="<?php echo BASE_URL . "permissions/addGroup"; ?>">Adicionar Grupo de Permissões</a>
        <table width="100%">
            <tr>
                <th align="left">Nome do Grupo de Permissões</th>
                <th width="170">Ações</th>
            </tr>
            <?php foreach ($permissionsGroupsList as $pG) {
                ?>
                <tr>
                    <td><?php echo $pG['name']; ?></td>
                    <td>
                        <a class="button bt-sm bt-yel" href="<?php echo BASE_URL . "permissions/editGroup/" . $pG['Id']; ?>" >Editar</a>
                        <a class="button bt-sm bt-red" href="<?php echo BASE_URL . "permissions/delGroup/" . $pG['Id']; ?>" onclick="return confirm('Deseja realmente excluir?');">Excluir</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <div class="tabBody">
        <a class="button" href="<?php echo BASE_URL . "permissions/add"; ?>">Adicionar Permissão</a>
        <table width="100%">
            <tr>
                <th align="left">Nome da Permissão</th>
                <th width="50">Ações</th>
            </tr>
            <?php foreach ($permissionsList as $pL) {
                ?>
                <tr>
                    <td><?php echo $pL['name']; ?></td>
                    <td>
                        <a class="button bt-sm bt-red" href="<?php echo BASE_URL . "permissions/del/" . $pL['Id']; ?>" onclick="return confirm('Deseja realmente excluir?');">Excluir</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>