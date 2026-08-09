<div class="topbar">
    <div class="d-flex align-items-center gap-3">
        <?php if($_SESSION['usuario_logged']['perfil'] == 'admin'){?>
            <h4 class="m-0">Painel Administrativo</h4>
        <?php } else { ?>
            <h4 class="m-0">Painel do Operador</h4>
        <?php } ?>
    </div>
    <div class="icons">
        <a href="perfil.php">
            <img src="../../uploads/usuarios/<?php echo isset($_SESSION['usuario_logged']['imagem']) ? htmlspecialchars($_SESSION['usuario_logged']['imagem']) : 'default.jpg'; ?>" alt="Foto do Usuário" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
        </a>
    </div>
</div>