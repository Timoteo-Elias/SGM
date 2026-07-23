<?php 
    require_once __DIR__ . '/../Controller/FalecidoController.php';
    require_once __DIR__ . '/../Model/Dao/falecidoDao.php';
    require_once __DIR__ . '/../Model/falecido.php';
    use Model\Falecido;
    // 2. INSTANCIAR AS CAMADAS (O "Motor" do MVC)
    // (Ajusta a forma como geras a tua conexão PDO se usares uma classe própria)
    $FalecidoController = new FalecidoController();
    // 3. CRIAR A VARIÁVEL QUE A TABELA PRECISA
    // Daqui para baixo, o teu HTML/Bootstrap continua exatamente igual...

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $falecidos = $FalecidoController->getForId($id);
    }

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
                        <h4 class="mb-0">Cadastrar Novo Ingresso (Morgue)</h4>
                    </div>
                    <div class="card-body">
                        <form action="../index.php" method="POST">
                            
                            <div class="row mb-3">
                                <div class="col-md-1">
                                    <label class="form-label fw-bold">ID</label>
                                    <input type="text" name="id_falecido" class="form-control" readonly value="<?= !empty($falecidos['id_falecido']) ?  $falecidos['id_falecido'] : 0  ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Código do Processo *</label>
                                    <input type="text" name="codigo_up" class="form-control" value="<?= !empty($falecidos['codigo']) ?  $falecidos['codigo'] : 0  ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Nome Completo *</label>
                                    <input type="text" name="nome_up" class="form-control" value="<?= $falecidos['nome_completo'] ?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Sexo *</label>
                                    <select name="sexo_up" class="form-select" >
                                        <option value=""><?= $falecidos['sexo'] ?></option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Feminino</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Data de Nascimento (Opcional)</label>
                                    <input type="date" name="nascimento_up" class="form-control" value="<?= $falecidos['data_nascimento'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Nº do BI (Opcional)</label>
                                    <input type="text" name="bi_up" class="form-control" value="<?= $falecidos['bi'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Estado Civil (Opcional)</label>
                                    <select name="estado_civil_up" class="form-select">
                                        <option value=""><?= $falecidos['estado_civil'] ?></option>
                                        <option value="Solteiro(a)">Solteiro(a)</option>
                                        <option value="Casado(a)">Casado(a)</option>
                                        <option value="Viúvo(a)">Viúvo(a)</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Nacionalidade (Opcional)</label>
                                    <input type="text" name="nacionalidade_up" class="form-control" value="<?= $falecidos['nacionalidade'] ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Nome do Pai (Opcional)</label>
                                    <input type="text" name="papa" class="form-control" value="<?= $falecidos['pai'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Nome da Mãe (Opcional)</label>
                                    <input type="text" name="mama" class="form-control" value="<?= $falecidos['mae'] ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Endereço (Opcional)</label>
                                    <input type="text" name="endereco_up" class="form-control" value="<?= $falecidos['endereco'] ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Observações Médicas / Circunstâncias de Entrada *</label>
                                <textarea name="obs_up" class="form-control" rows="3" value="<?= $falecidos['observacoes'] ?>" ></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="falecidos.php" class="btn btn-secondary">Cancelar</a>
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