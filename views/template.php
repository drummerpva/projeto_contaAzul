<!DOCTYPE html>
<html>
    <head>
        <title>Painel | <?php echo $viewData['companyName']; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo BASE_URL; ?>assets/css/estilos.css" rel="stylesheet" />
        <script type="text/javascript">
            var BASE_URL = '<?php echo BASE_URL . "';"; ?>
        </script>
        <script src="<?php echo BASE_URL; ?>assets/js/jquery.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>assets/js/jquery.mask.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="leftMenu">
            <div class="companyName"><?php echo $viewData['companyName']; ?></div>
            <div class="menuArea">
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                    <li><a href="<?php echo BASE_URL . "permissions"; ?>">Permissões</a></li>
                    <li><a href="<?php echo BASE_URL . "users"; ?>">Usuários</a></li>
                    <li><a href="<?php echo BASE_URL . "clients"; ?>">Clientes</a></li>
                    <li><a href="<?php echo BASE_URL . "inventory"; ?>">Estoque</a></li>
                    <li><a href="<?php echo BASE_URL . "sales"; ?>">Vendas</a></li>
                    <li><a href="<?php echo BASE_URL . "purchases"; ?>">Compras</a></li>
                    <li><a href="<?php echo BASE_URL . "report"; ?>">Relatórios</a></li>
                </ul>

            </div>
        </div>
        <div class="container">
            <div class="top">
                <div class="topRight"><a href="<?php echo BASE_URL . "login/logOut"; ?>">Sair</a></div>
                <div class="topRight"><?php echo $viewData['userEmail']; ?></div>
            </div>
            <div class="area">
                <?php $this->loadViewInTemplate($viewName, $viewData);?>
            </div>
        </div>


        <script src="<?php echo BASE_URL; ?>assets/js/script.js" type="text/javascript"></script>
    </body>
</html>