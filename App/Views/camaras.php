<?php
    include_once(__DIR__ . '/Auth.php');
    require_once __DIR__ . '/../Model/Camara.php'; 
    require_once __DIR__ . '/../Controller/CamaraController.php';
    require_once __DIR__ . '/../Model/Dao/camaraDao.php';
    use Model\Estados;
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); 
    }
    $camaraController = new CamaraController();

    $camaras = $camaraController->index();

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morgue System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../Public/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="../../Public/js/bootstrap.min.js"></script>
    <style>
        :root{
            --primary:#00d9ff;
            --dark:#0b0f19;
            --card:#111827;
            --border:#1f2937;
        }
        body{
            background:var(--dark);
            color:#fff;
            font-family:Segoe UI;
        }
        .wrapper{
            display:flex;
            min-height:100vh;
        }
        .sidebar{
            width:280px;
            background:var(--card);
            border-right:1px solid var(--border);
            padding:20px;
        }
        .logo-area{
            text-align:center;
            margin-bottom:20px;
        }
        .menu{
            list-style:none;
            padding:0;
        }
        .menu li{
            margin-bottom:8px;
        }
        .menu li a{
            display:flex;
            gap:10px;
            color:#ccc;
            text-decoration:none;
            padding:12px;
            border-radius:12px;
        }
        .menu li.active a,
        .menu li a:hover{
            background:#132538;
            color:var(--primary);
        }
        .content{
            flex:1;
            padding:25px;
        }
        .topbar{
            display:flex;
            justify-content:space-between;
            margin-bottom:25px;
        }
        .icons{
            display:flex;
            gap:20px;
            font-size:24px;
        }
        .dashboard-card{
            background:var(--card);
            padding:10px;
            border-radius:10px;
            border:1px solid var(--border);
        }
        .dashboard-card i{
            color:var(--primary);
            font-size:30px;
        }
        .table-section{
            background:var(--card);
            padding:20px;
            border-radius:15px;
        }
        .mobile-list{
            display:none;
        }
        .mobile-navbar{
            display:none;
        }
        /* TABLET */
        @media(max-width:992px){
            .sidebar{
                width:90px;
            }
            .sidebar span,
            .logo-area h3,
            .logo-area small{
                display:none;
            }
        }
        /* MOBILE */
        @media(max-width:768px){
            .sidebar{
                position:fixed;
                left:-280px;
                top:0;
                height:100%;
                z-index:999;
                transition:.3s;
            }
            .sidebar.compact{
               width: 80px;
            }
            .content{
                width:100%;
                padding:25px;
                margin-bottom:80px;
            }
            .desktop-table{
                display:none;
            }
            .mobile-list{
                display:block;
            }
            .mobile-navbar{
                display:flex;
                justify-content:space-around;
                align-items:center;
                position:fixed;
                bottom:0;
                left:0;
                width:100%;
                height:70px;
                background:#111827;
                border-top:1px solid #222;
            }
            .mobile-navbar a{
                color:white;
                font-size:24px;
            }
            .mobile-menu{
                display:block;
                font-size:28px;
                cursor:pointer;
                color:var(--primary);
            }
             .logo-area h5{
            display: none;
            }
            .sidebar{
                display: none;
            }
        }
        .entry-card{
            background:#0f172a;
            border-radius:12px;
            margin-bottom:12px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        table{
            background-color:#111827;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include_once('assets/sicebar.php') ?>
        <!-- CONTENT -->
        <main class="content">
            <?php include_once('assets/header.php') ?>
            <?php include_once('assets/painel.php') ?>

             <div class="table-section mt-4">
                <div class="d-flex justify-content-between">
                    <h5>Gestão de Câmaras</h5>
                    <div>                    
                        <a href="add_camara.php" class="btn btn-outline-primary"> <i class="bi bi-plus"></i> Nova Câmara</a>
                    </div>
                </div>
                <?php if (isset($_SESSION['sucesso'])): ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <strong>✓ Sucesso!</strong> <?= $_SESSION['sucesso']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php 
                    // IMPORTANTE: Limpa a mensagem para ela não reaparecer se o utilizador atualizar a página (F5)
                    unset($_SESSION['sucesso']); 
                    ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['erro'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <strong>✗ Erro!</strong> <?= $_SESSION['erro']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php 
                    // IMPORTANTE: Limpa a mensagem para ela não reaparecer se o utilizador atualizar a página (F5)
                    unset($_SESSION['erro']); 
                    ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['delete'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <strong>✓ Sucesso!</strong> <?= $_SESSION['delete']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php 
                    // IMPORTANTE: Limpa a mensagem para ela não reaparecer se o utilizador atualizar a página (F5)
                    unset($_SESSION['delete']); 
                    ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['atualizado'])): ?>
                    <div class="alert alert-primary alert-dismissible fade show mt-3" role="alert">
                        <strong>✓ Sucesso!</strong> <?= $_SESSION['atualizado']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php 
                    // IMPORTANTE: Limpa a mensagem para ela não reaparecer se o utilizador atualizar a página (F5)
                    unset($_SESSION['atualizado']); 
                    ?>
                <?php endif; ?>
            </div>
            
            <!-- CARDS -->
            <div class="row g-4 mt-2">
                <?php foreach ($camaras as $camara): 
                    $total = $camara['capacidade'];
                    $ocupadas = $camara['quantidade_gavetas_criadas'];
                    $livres = $camara['capacidade_livre'];
                    
                    // Cálculo da percentagem de ocupação
                    $percentagem = ($total > 0) ? round(($ocupadas / $total) * 100) : 0;
                    ?>
                    <div class="col-xl-4 col-md-6">
                        <div class="dashboard-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-muted"><?= htmlspecialchars($camara['codigo']); ?></h6>
                                <?php if (strtolower($camara['estado']) === 'avariada'): ?>
                                    <span class="badge bg-danger pt-0 p-1">
                                        <?= htmlspecialchars($camara['estado']); ?>      
                                    </span>
                                <?php elseif (strtolower($camara['estado']) === 'operacional'): ?>
                                    <span class="badge bg-success pt-0 p-1">
                                        <?= htmlspecialchars($camara['estado']); ?>      
                                    </span>
                                <?php elseif (strtolower($camara['estado']) === 'manutenção'): ?>
                                    <span class="badge bg-warning pt-0 p-1">
                                        <?= htmlspecialchars($camara['estado']); ?>      
                                    </span>
                            <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <h2><?= htmlspecialchars($camara['temperatura']); ?><span>ºC</span></h2>
                                <?php if (strtolower($camara['estado']) === 'avariada'): ?>
                                    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                                <?php elseif (strtolower($camara['estado']) === 'operacional'): ?>
                                    <i class="bi bi-graph-up-arrow text-success"></i>
                                <?php elseif (strtolower($camara['estado']) === 'manutenção'): ?>
                                    <i class="bi bi-tools text-warning"></i>
                                <?php endif; ?>
                                
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <p style="font-size: 13px; color:azure"><?= $ocupadas ?>/<?= $total ?> Gavetas</p>
                                <p style="font-size: 14px; "><?= $percentagem; ?>%</p>
                            </div>

                            <div style="width: 100%;">
                                <!-- Barra de Progresso Visual -->
                                <div class="progress " style="height: 10px;">
                                    <div class="progress-bar <?= $percentagem >= 90 ? 'bg-danger' : 'bg-info'; ?>" 
                                        role="progressbar" 
                                        style="width: <?= $percentagem; ?>%;" 
                                        aria-valuenow="<?= $percentagem; ?>" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <a href="gavetas.php?camara=<?= urlencode($camara['codigo']); ?>" class="btn btn-outline-secondary btn-sm mt-2 mb-2"> Ver Gavetas</a>
                                <a href="edit_camara.php?camara=<?= urlencode($camara['codigo']); ?>" class="btn btn-outline-primary btn-sm mt-2  mb-2"> Atualizar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- MOBILE NAV -->
    <?php include_once('assets/mobile.php') ?>
    <script>
        function toggleSidebar() {
            document.getElementById("menu").classList.toggle("compact");
        }
    </script>
</body>
</html>