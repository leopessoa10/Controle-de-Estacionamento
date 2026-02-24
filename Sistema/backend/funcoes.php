<?PHP
    // Verifica o tipo de usuário na sessão
    if (isset($_SESSION['idTipoUsuario'])) {
        if ($_SESSION['idTipoUsuario'] == 1) {
            include("funcaoMenuAdm.php");
        } else if ($_SESSION['idTipoUsuario'] == 2) {
            include("funcaoMenuFuncionario.php");
        } else if ($_SESSION['idTipoUsuario'] == 3) {
            include("funcaoMenu.php");
        } else {
            echo "Tipo de usuário inválido.";
        }
    } else {
        echo "Sessão não iniciada ou idTipoUsuario não definido.";
    }

    // Inclui outras funções necessárias
    include("funcaoTipoUsuario.php");
    include("funcaoUsuario.php");
    include("funcaoEmpresa.php");
    include("funcaoVaga.php");
    include("funcaoPainel.php");
        
?>