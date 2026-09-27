<?php
    include_once(__DIR__ . '/Auth.php');
    require_once __DIR__ . '/../Controller/EntradaController.php';
    require_once __DIR__ . '/../Model/Dao/entradaDao.php';
    require_once __DIR__ . '/../Model/Entrada.php';
    use Model\Falecido;

    $entradaDao = new EntradaDao(); 
    $entradaController = new EntradaController($entradaDao);
    $conservados = $entradaController->conservado(); 

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
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include_once('assets/sicebar.php') ?>
        <!-- CONTENT -->
        <main class="content">
            <?php include_once('assets/header.php') ?>

           <?php include_once('assets/painel.php') ?>
           
            <!-- DESKTOP TABLE -->
            <div class="table-section mt-4">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <h5>Corpos Em Conservação</h5>
                    </div>
                    <div class="col-md-8">
                        <form class=" ">
                            <div class="d-flex">
                                <input type="search" name="pesquisa" class="form-control " placeholder="Buscar pelo nome do falecido ou Código de entrada">
                                <button type="submit" class="btn btn-primary"> <i class="bi bi-search"></i></button>
                            </div>
                        </form> 
                    </div>
                </div>
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
                <div class="table-responsive desktop-table">
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Falecido</th>
                                <th>Depositante</th>
                                <th>Camara</th>
                                <th>Gaveta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($conservados as $trim):?>
                                <tr>
                                    <td><?= $trim['codigo'] ?></td>
                                    <td><?= $trim['falecido'] ?></td>
                                    <td><?= $trim['depositante'] ?></td>
                                    <td><?= $trim['camara'] ?></td>
                                    <td><?= $trim['gaveta'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- MOBILE CARDS -->
                <div class="mobile-list">
                    <div class="entry-card">
                        <table class="table table-striped table-dark">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>BI</th>
                                    <th>tIPO</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($falecidos as $trim):?>
                                    <tr>
                                        <td><?= $trim['nome'] ?></td>
                                        <td><?= $trim['bi'] ?></td>
                                        <td><?= $trim['tipo'] ?></td>
                                        <td>
                                            <a href="#" class="nav-link"><i class="bi bi-eye-fill "> </i></a>

                                            <a href="../index.php?id=<?= $trim['id_falecido'] ?>" class="nav-link"><i class="bi bi-trash3-fill text-danger "> </i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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