<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function montaMenu($n1,$n2){
    
    $menuFuncionario    = '';
    $acaoFuncionario    = '';

    $opcPainel          = '';
    $opcVagas           = '';
    $opcPerfil          = '';
    
    //Primeiro nível do menu
    switch ($n1) {
        case 'funcionario':
            $menuFuncionario = 'menu-open';
            $acaoFuncionario = 'active';
            break;
    
        default:
            # code...
            break;
    }

    //Segundo nível do menu
    switch ($n2) {
        case 'painel':
            $opcPainel = 'active';
            break;

        case 'vagas':
            $opcVagas = 'active';
            break;

        case 'perfil':
            $opcPerfil = 'active';
            break;
        
        default:
            # code...
            break;
    }
    
    $html = 
    '<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item '.$menuFuncionario.'">
                <a href="#" class="nav-link '.$acaoFuncionario.'">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Menu - Funcionário
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./painel.php" class="nav-link '.$opcPainel.'">
                        <i class="ion ion-pie-graph nav-icon"></i>
                        <p>Dados diários</p>
                        </a>
                    </li>              
                </ul>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./vagas.php" class="nav-link '.$opcVagas.'">
                        <i class="fas fa-car nav-icon"></i>
                        <p>Vagas</p>
                        </a>
                    </li>              
                </ul>
                
            </li>

            <li class="nav-item">
                <a href="./perfil.php" class="nav-link '.$opcPerfil.'">
                <i class="nav-icon fas fa-user"></i>
                <p>Meu Perfil</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="backend/validaLogoff.php" class="nav-link text-danger">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Sair</p>
                </a>
            </li>
        
        </ul>
    </nav>';

    return $html;
}

?>