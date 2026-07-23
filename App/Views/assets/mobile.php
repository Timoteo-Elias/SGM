<?php
    $pagina = basename($_SERVER['PHP_SELF']);
?>

    <nav class="mobile-navbar">
        <a href="tec_index.php" class="<?= $pagina == 'tec_index.php' ? 'active' : '' ?>">
            <i class="bi bi-house"></i>
        </a>

        <a href="falecidos.php" class="<?= $pagina == 'falecidos.php' ? 'active' : '' ?>">
            <i class="bi bi-person-vcard"></i>
        </a>

        <a href="entradas.php" class="<?= $pagina == 'entradas.php' ? 'active' : '' ?>">
            <i class="bi bi-box-arrow-in-right"></i>
        </a>

        <a href="conservado.php" class="<?= $pagina == 'conservado.php' ? 'active' : '' ?>">
            <i class="bi bi-snow"></i>
        </a>

        <a href="entregas.php" class="<?= $pagina == 'entregas.php' ? 'active' : '' ?>">
            <i class="bi bi-box-arrow-right"></i>
        </a>

        <a href="relatorio.php" class="<?= $pagina == 'relatorio.php' ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-bar-graph"></i>
        </a>

        <a href="cofig.php" class="<?= $pagina == 'config.php' ? 'active' : '' ?>">
            <i class="bi bi-gear"></i>
        </a>
    </nav>