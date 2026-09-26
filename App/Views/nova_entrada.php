<?php  
  include_once(__DIR__ . '/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/../config/conexao.php';
    require_once __DIR__ . '/../Model/Dao/EntradaDao.php';
    $entradaDao = new EntradaDao();
    $proximoCodigo = $entradaDao->getProximoCodigo();
    $estados = $entradaDao->getEstado(); 
    $falecidos = $entradaDao->getFalecido();
    $gavetas = $entradaDao->getGavetas();
    $depositantes = $entradaDao->getDepositantes();
    $idUsuario   = $_SESSION['usuario_logged']['id'] ?? null;
    $nomeUsuario = $_SESSION['usuario_logged']['nome'] ?? 'Operador Indefinido';
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
            <div class="container mt-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Cadastrar Nova Entrada</h4>
                    </div>
                    <div class="card-body">
                        <form action="../entrada.php" method="POST">
                            
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Código*</label>
                                    <input type="text" name="codigo" class="form-control" value="<?= htmlspecialchars($proximoCodigo); ?>" readonly>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold">Falecido*</label>
                                    <select name="falecido" class="form-select" required>
                                        <option value="">Selecione o falecido</option>
                                        <?php foreach ($falecidos as $falecido): ?>
                                            <option value="<?= htmlspecialchars($falecido['id_falecido']); ?>"><?= htmlspecialchars($falecido['nome_completo']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Depositante*</label>
                                    <select name="depositante" class="form-select" required>
                                        <option value="">Selecione o depositante</option>
                                        <?php foreach ($depositantes as $depositante): ?>
                                            <option value="<?= htmlspecialchars($depositante['id_depositante']); ?>"><?= htmlspecialchars($depositante['nome']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Gaveta*</label>
                                    <select name="gaveta" class="form-select" required>
                                        <option value="">Selecione a gaveta</option>
                                        <?php foreach ($gavetas as $gaveta): ?>
                                            <option value="<?= htmlspecialchars($gaveta['id_gaveta']); ?>"><?= htmlspecialchars($gaveta['cod_gaveta']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Estado*</label>
                                    <select name="estado" class="form-select" required>
                                        <option value="">Selecione o estado</option>
                                        <?php foreach ($estados as $estado): ?>
                                            <option value="<?= htmlspecialchars($estado['id_estado']); ?>"><?= htmlspecialchars($estado['nome']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>    
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Usuario Responsavel*</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($nomeUsuario) ?>" readonly disabled>
                                </div>    
                                <div class="col-md-6 mb-3">
                                    <input type="hidden" name="usuario" value="<?= $idUsuario ?>">
                                </div>    
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="entradas.php" class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i> Cancelar</a>
                                <button type="submit" name="add_entrada" class="btn btn-sm btn-success"><i class="bi bi-floppy-fill"></i> Salvar</button>
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