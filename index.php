<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se o utilizador já estiver autenticado, vai direto para a Dashboard
if (isset($_SESSION['usuario_logged'])) {
    header("Location: Views/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="Public/css/bootstrap.min.css">
</head>
<body class="bg-dark d-flex align-items-center justify-content-center vh-100">

<div class="container d-flex justify-content-center">
    <div class="card p-4 shadow-sm border-0" style="width: 100%; max-width: 400px; border-radius: 8px;">
        
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">Acesso ao Sistema</h3>
            <p class="text-muted small">Insira as suas credenciais para entrar</p>
        </div>

        <!-- Alerta para Mensagens de ERRO -->
        <?php if (isset($_SESSION['erro'])): ?>
            <div class="alert alert-danger p-2 small text-center" role="alert">
                ⚠️ <?= htmlspecialchars($_SESSION['erro']); ?>
            </div>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>

        <!-- Formulário de Autenticação -->
        <form action="login.php" method="POST">
            
            <div class="mb-3">
                <label for="email" class="form-label font-weight-bold">E-mail</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control" 
                    placeholder="seu.email@exemplo.com" 
                    required 
                    autofocus
                >
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label font-weight-bold">Senha</label>
                <input 
                    type="password" 
                    name="senha" 
                    id="senha" 
                    class="form-control" 
                    placeholder="••••••••" 
                    required
                >
            </div>

            

            <button type="submit" name="btn-login" class="btn btn-primary w-100 fw-bold py-2">
                Entrar
            </button>
            <div class="mt-4">
                <a class="btn btn-primary w-100 fw-bold py-2" href="recuperar_senha.php">esqueceu a senha?</a>
            </div>

        </form>

        <div class="text-center mt-3">
            <small class="text-muted">© <?= date("Y") ?> SGM. Todos os direitos reservados.</small>
        </div>
    </div>
</div>

</body>
</html>