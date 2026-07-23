<?php
    $pagina = basename($_SERVER['PHP_SELF']);
?>
<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="logo-area">
        <div class="logo-icon">
            <i class="bi bi-cpu"></i>
        </div>
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
        <li class="<?= $pagina == 'conservado.php' ? 'active' : '' ?>">
            <a href="conservado.php">
                <i class="bi bi-snow"></i>
                <span>Conservação</span>
            </a>
        </li>
        <li class="<?= $pagina == 'entregas.php' ? 'active' : '' ?>">
            <a href="entregas.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Entregas</span>
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