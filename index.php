<!DOCTYPE html>
<html>
    <head lang="pt-br">

        <meta charset="UTF-8">
        <title>ParkWay - Login</title>

        <!-- CSS -->
        <link rel="stylesheet" href="Sistema/css/style-index.css">
        <!-- /.css -->

    </head>

    <body class="body">
        <div class="container">

            <div class="logo">
                <img src="Sistema/img/logo.png" alt="ParkWay Logo" class="logo">
                <h1 class="logo">ParkWay</h1>
                <h3 class="logo">Systems</h3>
            </div>

            <form method="POST" action="Sistema/backend/validaLogin.php">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="iEmail" name="nEmail" placeholder="Digite seu email..."   required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="iSenha" name="nSenha" placeholder="Digite sua senha..."   required>
                </div>

                <input id="login-button" type="submit" value="Login">

                <?php
                    // Inicia a sessão se ainda não estiver iniciada, para acessar $_SESSION
                    if (session_status() !== PHP_SESSION_ACTIVE) {
                        session_start();
                    }

                    // Verifica se há uma mensagem de erro na sessão
                    if (isset($_SESSION['msg_login'])) {
                        echo '<p class="error-message">' . $_SESSION['msg_login'] . '</p>';
                        unset($_SESSION['msg_login']); // Limpa a mensagem da sessão após exibir
                    }
                ?>
            </form>

        </div>
    </body>
</html