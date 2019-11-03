<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css"/>
        <link href="<?php echo BASE_URL; ?>assets/css/login.css" rel="stylesheet" />
    </head>
    <body>
        <div class="loginArea">
            <form method="POST">
                <input type="email" name="email" required placeholder="Digite seu e-mail"/>
                <input type="password" name="password" required placeholder="Digite sua senha"/>
                <input type="submit" value="Entrar"/><br/><br/>
                <?php if (!empty($error)) {
                    ?>
                <div class="warning"><?php echo $error;?></div>
                    
                    <?php
                }
                ?>
            </form>
        </div>

        <script src="<?php echo BASE_URL; ?>assets/js/jquery.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>assets/js/script.js" type="text/javascript"></script>
    </body>
</html>