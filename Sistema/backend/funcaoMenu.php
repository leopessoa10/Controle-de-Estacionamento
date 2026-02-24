<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function montaMenu($n1,$n2){
    
    $menuAdmin = '';
    $acaoAdmin = '';
    $menuRelatorio  = '';
    $acaoRelatorio  = '';

    $opcPainel        = '';
    $opcPainelSimples = '';
    $opcUsuarios      = '';
    $opcVagas         = '';
    $opcEmpresas      = '';
    $opcRelatVagas      = '';
    $opcRelatMovi      = '';
    $opcPerfil        = '';
    
    //Primeiro nível do menu
    switch ($n1) {
        case 'administrador':
            $menuAdmin = 'menu-open';
            $acaoAdmin = 'active';
            break;

        case 'relatorio':
            $menuRelatorio = 'menu-open';
            $acaoRelatorio = 'active';
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
            
        case 'painel-total':
            $opcPainelSimples = 'active';
            break;
            
        case 'usuarios':
            $opcUsuarios = 'active';
            break;     
            
        case 'vagas':
            $opcVagas = 'active';
            break;   
            
        case 'empresas':
            $opcEmpresas = 'active';
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
            <li class="nav-item '.$menuAdmin.'">
                <a href="#" class="nav-link '.$acaoAdmin.'">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Menu - Dono
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
                        <a href="./painel-total.php" class="nav-link '.$opcPainelSimples.'">
                        <i class="ion ion-pie-graph nav-icon"></i>
                        <p>Dados Totais</p>
                        </a>
                    </li>              
                </ul>
                
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./usuarios.php" class="nav-link '.$opcUsuarios.'">
                        <i class="far fa-user nav-icon"></i>
                        <p>Usuários</p>
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

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./empresas.php" class="nav-link '.$opcEmpresas.'">
                        <i class="fab fa-houzz nav-icon"></i>
                        <p>Empresas</p>
                        </a>
                    </li>              
                </ul>

            </li>

            <li class="nav-item '.$menuRelatorio.'">
                <a href="#" class="nav-link '.$acaoRelatorio.'">
                    <i class="nav-icon fas fa-print"></i>
                    <p>
                        Relatórios
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./relatorio-vagas.php" class="nav-link '.$opcRelatVagas.'">
                        <i class="fas fa-file-alt nav-icon"></i>
                        <p>Vagas</p>
                        </a>
                    </li>              
                </ul>

                                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./relatorio-movimentacao.php" class="nav-link '.$opcRelatMovi.'">
                        <i class="fas fa-file-alt nav-icon"></i>
                        <p>Movimentação</p>
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