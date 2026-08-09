<?php
    include_once(__DIR__ . '/Auth.php');
    require_once __DIR__ . '/../Controller/FalecidoController.php';
    require_once __DIR__ . '/../Model/Dao/falecidoDao.php';
    require_once __DIR__ . '/../Model/falecido.php';
    use Model\Falecido;
    // 2. INSTANCIAR AS CAMADAS (O "Motor" do MVC)
    // (Ajusta a forma como geras a tua conexão PDO se usares uma classe própria)
    $falecidoDao = new FalecidoDao(); 
    $FalecidoController = new FalecidoController($falecidoDao);
    // 3. CRIAR A VARIÁVEL QUE A TABELA PRECISA
    // Chamamos o método do controller para recolher os dados do banco
    $total_falecido = $FalecidoController->totalFalecido(); 
    // Daqui para baixo, o teu HTML/Bootstrap continua exatamente igual...

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
    <link rel="stylesheet" href="../../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../Public/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include_once('assets/sicebar.php') ?>
        <!-- CONTENT -->
        <main class="content">
            <?php include_once('assets/header.php') ?>
            <?php include_once('assets/painel.php') ?>

            
            <!-- CARDS -->
            <div class="row g-4">
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card">
                        <i class="bi bi-people"></i>
                        <h2><?php echo $total_falecido['total_falecidos'] ?></h2>
                        <p>Total Falecidos</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <h2>12</h2>
                        <p>Entradas Hoje</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card">
                        <i class="bi bi-box-arrow-right"></i>
                        <h2>07</h2>
                        <p>Entregues Hoje</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card">
                        <i class="bi bi-snow"></i>
                        <h2>54</h2>
                        <p>Conservação</p>
                    </div>
                </div>
            </div>

            <!-- DESKTOP TABLE -->
            <div class="table-section mt-4">
                <div class="d-flex justify-content-between mb-3">
                    <h5>Últimas Entradas</h5>
                    <div>
                        <a href="" class="btn btn-outline-light"> Ver Todas</a>
                    </div>
                </div>
                <div class="table-responsive desktop-table">
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Origem</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>F2026-1248</td>
                                <td>João Manuel</td>
                                <td>Hospital Geral</td>
                                <td>
                                    <span class="badge bg-success">
                                        Conservação
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>F2026-1248</td>
                                <td>João Manuel</td>
                                <td>Hospital Geral</td>
                                <td>
                                    <span class="badge bg-success">
                                        Conservação
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- MOBILE CARDS -->
                <div class="mobile-list">
                    <div class="entry-card">
                        <table class="table table-striped table-dark">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>F2026-1248</td>
                                    <td>João Manuel</td>
                                    <td><span class="badge bg-success">Conservação</span></td>
                                </tr>
                            </tbody>
                        </table>                       
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