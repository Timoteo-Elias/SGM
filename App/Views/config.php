<?php  
    include_once(__DIR__ . '/Auth.php');
    require_once __DIR__ . '/../Model/Config.php'; 
    require_once __DIR__ . '/../Controller/ConfigController.php';
    require_once __DIR__ . '/../Model/Dao/configDao.php';
    use Model\Config;

    $configController = new ConfigController(); 
    $config = $configController->index();

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

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
    <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="../../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../Public/bootstrap-icons/font/bootstrap-icons.min.css">
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
            margin-bottom:40px;
        }
        .logo-icon{
            font-size:50px;
            color:var(--primary);
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
            padding:20px;
            border-radius:15px;
            border:1px solid var(--border);
        }
        .dashboard-card i{
            color:var(--primary);
            font-size:35px;
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
        .card-body{
            background-color: #111827;
            color: #ccc;
           
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include_once('assets/sicebar.php') ?>
        <!-- CONTENT -->
        <main class="content">
            <?php include_once('assets/header.php') ?>
           
            <!-- DESKTOP TABLE -->
            <div class="container">
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
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Configurações do Sistema</h4>
                    </div>
                    <div class="card-body">
                        <form action="../config.php" method="POST">
                            
                            <div class="row mb-3 p-3">
                                <div class="col-md-1">
                                    <label class="form-label fw-bold">ID</label>
                                    <input type="text" name="id_config" class="form-control" readonly value="<?= !empty($config['id_config']) ? $config['id_config'] : 0  ?>">
                                </div>
                                <div class="col-md-11 mb-3">
                                    <label class="form-label fw-bold">Nome do Hospital *</label>
                                    <input type="text" name="hospital" class="form-control" value="<?= htmlspecialchars($config['nome'] ?? '', ENT_QUOTES, 'UTF-8') ?>" >
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Telefone *</label>
                                    <input type="text" name="telefone" class="form-control" value="<?= isset($config['telefone']) ? $config['telefone'] : '' ?>" placeholder="Nº de Telefone" maxlength="9" pattern="[0-9]{9}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" value="<?= isset($config['email']) ? $config['email'] : '' ?>" placeholder="Endereço de Email">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Dias de Permanência dos corpos *</label>
                                    <input type="text" name="dias_permanencia" class="form-control" value="<?= isset($config['dias_permanencia']) ? $config['dias_permanencia'] : '' ?>" placeholder="Dias de Permanência" maxlength="2" pattern="[0-9]{2}">
                                </div>    
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Endereço *</label>
                                    <input type="text" name="endereco" class="form-control" value="<?= isset($config['endereco']) ? $config['endereco'] : '' ?>" placeholder="Endereço completo">
                                </div>    
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="index.php" class="btn btn-sm btn-secondary"><i class="bi bi-x-circle"></i> Voltar</a>
                                <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-floppy-fill"></i> Atualizar</button>
                            </div>
                        </form>
                    </div>
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