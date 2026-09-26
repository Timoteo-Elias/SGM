<?php

    $pagina = basename($_SERVER['PHP_SELF']);
    if($_SESSION['usuario_logged']['perfil'] == 'admin'){

     
?>
<!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo-area">
            <h5>HOSPITAL GERAL DE CACUACO</h5>
            <small>Sistema de Gestão</small>
        </div>
        <hr>
        <ul class="menu" id="menu">
            <li class="<?= $pagina == 'index.php' ? 'active' : '' ?>">
                <a href="index.php" >
                    <i onclick="toggleSidebar()" class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?= $pagina == 'conservados.php' ? 'active' : '' ?>">
                <a href="conservados.php">
                    <i class="bi bi-snow"></i>
                    <span>Conservação</span>
                </a>
            </li>
           
            <li class="<?= $pagina == 'gavetas.php' ? 'active' : '' ?>">
                <a href="gavetas.php">
                    <i class="bi bi-inboxes-fill"></i>
                    <span>Gavetas</span>
                </a>
            </li>
            <li class="<?= $pagina == 'camaras.php' ? 'active' : '' ?>">
                <a href="camaras.php">
                    <i class="bi bi-square-fill"></i>
                    <span>Camaras</span>
                </a>
            </li>
            <li class="<?= $pagina == 'estados.php' ? 'active' : '' ?>">
                <a href="estados.php">
                    <i class="bi bi-bullseye"></i>
                    <span>Estados</span>
                </a>
            </li>

            <li class="<?= $pagina == 'relatorio.php' ? 'active' : '' ?>">
                <a href="relatorio.php">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Relatórios</span>
                </a>
            </li>
            <li class="<?= $pagina == 'usuario.php' ? 'active' : '' ?>">
                <a href="usuario.php">
                    <i class="bi bi-person"></i>
                    <span>Usuários</span>
                </a>
            </li>
            <li class="<?= $pagina == 'config.php' ? 'active' : '' ?>">
                <a href="config.php">
                    <i class="bi bi-gear"></i>
                    <span>Configurações</span>
                </a>
            </li>
        </ul>
    </aside>

<?php
 } 

  if($_SESSION['usuario_logged']['perfil'] == 'operador'){
?>
    <aside class="sidebar">
        <div class="logo-area">
            <h5>HOSPITAL GERAL DE CACUACO</h5>
            <small>Sistema de Gestão</small>
        </div>
        <hr>
        <ul class="menu" id="menu">
            <li class="<?= $pagina == 'index.php' ? 'active' : '' ?>">
                <a href="index.php" >
                    <i onclick="toggleSidebar()" class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?= $pagina == 'falecidos.php' ? 'active' : '' ?>">
                <a href="falecidos.php">
                    <i class="bi bi-person-vcard"></i>
                    <span>Falecidos</span>
                </a>
            </li>
            <li class="<?= $pagina == 'entradas.php' ? 'active' : '' ?>">
                <a href="entradas.php">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Entradas</span>
                </a>
            </li>
            <li class="<?= $pagina == 'depositantes.php' ? 'active' : '' ?>">
                <a href="depositantes.php">
                    <i class="bi bi-person-fill"></i>
                    <span>Depositantes</span>
                </a>
            </li>
            <li class="<?= $pagina == 'saidas.php' ? 'active' : '' ?>">
                <a href="saidas.php">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Saidas</span>
                </a>
            </li>
             <li class="<?= $pagina == 'conservados.php' ? 'active' : '' ?>">
                <a href="conservados.php">
                    <i class="bi bi-snow"></i>
                    <span>Conservação</span>
                </a>
            </li>
            <li class="<?= $pagina == 'relatorio.php' ? 'active' : '' ?>">
                <a href="relatorio.php">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Relatórios</span>
                </a>
            </li>
        </ul>
    </aside>
<?php
    }
?>