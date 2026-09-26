<?php 
    include_once(__DIR__ . '/Auth.php');
    require_once __DIR__ . '/../Model/Camara.php'; 
    require_once __DIR__ . '/../Controller/CamaraController.php';
    require_once __DIR__ . '/../Model/Dao/camaraDao.php';
    use Model\Estados;

   $camaraController = new CamaraController();


    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $camara =  $camaraController->getForId($id);
    }

    $camaraDao = new CamaraDao();
    $estados = $camaraDao->getEstado();
    if(session_status() === PHP_SESSION_NONE) {
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
            <div class="container mt-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Atualizar Camara (<?=$camara['codigo'] ?>)</h4>
                    </div>
                    <div class="card-body">
                        <form action="../camaras.php" method="POST">
                            
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">ID</label>
                                    <input type="text" name="id_camara" class="form-control" readonly value="<?= !empty($camara['id_camara']) ? $camara['id_camara'] : 0  ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Capacidade </label>
                                    <input type="number" name="capacidade" class="form-control" value="<?= $camara['capacidade'] ?>" min="1" oninput=" if(this.value < 0  )this.value = 1;">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Temperatura </label>
                                    <input type="number" name="temperatura" class="form-control" value="<?= $camara['temperatura']  ?>" min="-20" max="20" oninput=" if(this.value < -20  )this.value = -20; if(this.value > 20)this.value = 20;">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Estado </label>
                                    <select name="estado" class="form-select" required>
                                        <option><?= $camara['estado']  ?></option>
                                        <?php foreach ($estados as $estado): ?>
                                            <option value="<?= $estado['id_estado']; ?>">
                                                <?= htmlspecialchars($estado['nome']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label fw-bold">Observações</label>
                                    <textarea name="obs" class="form-control" placeholder="Observações sobre a câmara"></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="camaras.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Atualizar</button>
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