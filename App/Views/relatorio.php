<?php
    include_once(__DIR__ . '/Auth.php');
    require_once __DIR__ . '/../Controller/RelatorioController.php';
    require_once __DIR__ . '/../Model/Dao/relatorioDao.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start(); 
    }


    $controller = new RelatorioController();

    // Lê os dados salvos pela Session no arquivo de processamento
    $dadosConsulta = $_SESSION['resultado_consulta'] ?? [];
    $filtroAtivo   = $_SESSION['filtro_ativo'] ?? null;

    $tipo       = $filtroAtivo['tipo'] ?? null;
    $dataInicio = $filtroAtivo['data_inicio'] ?? null;
    $dataFim    = $filtroAtivo['data_fim'] ?? null;

    // Lógica de exibição da Tabela
    // Lógica de exibição da tabela

    if ($filtroAtivo !== null) {

        // Foi realizada uma consulta
        $dadosTabela = $dadosConsulta;

        $tituloTabela = "Resultado da Consulta: Histórico de " . ucfirst($tipo);

        $exibindoConsulta = true;

    } else {

        // Nenhuma consulta realizada: mostrar permanência atual
        $dadosTabela = $controller->getPermanencia();

        $tituloTabela = "Permanência Atual na Morgue";

        $exibindoConsulta = false;
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
        .filter-card{
            background:var(--card);
            color:azure;
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

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card dashboard-card card-counter card-ocupado shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small">Permanência Atual</span>
                                <h3 class="fw-bold mb-0 text-danger"></h3>
                            </div>
                            <i class="bi bi-person-fill-exclamation fs-1 text-danger opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card dashboard-card card-counter card-livre shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div >
                                <span class="text-muted small">Câmaras Livres</span>
                                <h3 class="fw-bold mb-0 text-success"></h3>
                            </div>
                            <i class="bi bi-door-open-fill fs-1 text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card dashboard-card card-counter card-hoje shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small">Movimentos Hoje</span>
                                <h3 class="fw-bold mb-0 text-primary"></h3>
                            </div>
                            <i class="bi bi-arrow-left-right fs-1 text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4 no-print filter-card">
                <div class="card-body">
                    <form method="POST" action="../relatorio.php" class="card bg-dark text-white p-3 mb-4 border-secondary">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="tipo" class="form-label fw-bold">Tipo de Histórico</label>
                                <select name="tipo" id="tipo" class="form-select bg-dark text-white border-secondary" required>
                                    <option value="entradas" <?= $tipo === 'entradas' ? 'selected' : '' ?>>Entradas</option>
                                    <option value="saidas" <?= $tipo === 'saidas' ? 'selected' : '' ?>>Saídas</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="data_inicio" class="form-label fw-bold">Data Inicial</label>
                                <input type="date" name="data_inicio" id="data_inicio" class="form-control bg-dark text-white border-secondary" value="<?= $dataInicio ?? date('Y-m-01') ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label for="data_fim" class="form-label fw-bold">Data Final</label>
                                <input type="date" name="data_fim" id="data_fim" class="form-control bg-dark text-white border-secondary" value="<?= $dataFim ?? date('Y-m-d') ?>" required>
                            </div>

                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Buscar
                                </button>
                                <?php if ($exibindoConsulta): ?>
                                    <a href="../relatorio.php?limpar=1" class="btn btn-outline-light" title="Limpar e voltar para Permanência">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- DESKTOP TABLE -->
             <div class="card shadow-sm filter-card">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-secondary">
                        <i class="bi bi-list-check"></i> <?= $tituloTabela ?></h5>
                    </h5>
                </div>
                
            </div>
            <div class="table-responsive desktop-table text-white">
                <table class="table table-striped table-dark align-middle">
                    <thead>
                        <tr>
                            <?php if ($exibindoConsulta && $tipo === 'saidas'): ?>
                                <th><?= $exibindoConsulta ? 'Cód. Saída' : 'Cód. Entrada' ?></th>
                                <th><?= $exibindoConsulta ? 'Falecido' : 'Falecido' ?></th>
                                <th><?= $exibindoConsulta ? 'BI / Documento' : 'BI / Documento' ?></th>
                                
                            
                                <th>Data de Saída</th>
                                <th>Operador</th>
                                <th>Observação</th>
                            <?php else: ?>
                                <th>Cod. Entrada</th>
                                <th>Falecido</th>
                                <th>BI / Documento</th>
                                <th>Câmara / Gaveta</th>
                                <th>Data de Entrada</th>
                                <th><?= $exibindoConsulta ? 'Operador' : 'Dias na Morgue' ?></th>
                            <?php endif; ?>
                            
                            <th class="text-center no-print">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                       <tbody>
                        <?php if (!empty($dadosTabela)): ?>
                            <?php foreach ($dadosTabela as $item): ?>
                                <tr>

                                    <?php if ($exibindoConsulta && $tipo === 'saidas'): ?>

                                        <td>
                                            <strong><?= htmlspecialchars($item['saida']) ?></strong>
                                        </td>

                                        <td><?= htmlspecialchars($item['falecido']) ?></td>

                                        <td><?= htmlspecialchars($item['bi'] ?? 'N/D') ?></td>

                                        <td><?= htmlspecialchars($item['data_formatada']) ?></td>

                                        <td><?= htmlspecialchars($item['operador'] ?? 'N/A') ?></td>

                                        <td><?= htmlspecialchars($item['observacao'] ?? '-') ?></td>

                                    <?php else: ?>

                                        <td>
                                            <strong><?= htmlspecialchars($item['entrada']) ?></strong>
                                        </td>

                                        <td><?= htmlspecialchars($item['falecido']) ?></td>

                                        <td><?= htmlspecialchars($item['bi'] ?? 'N/D') ?></td>

                                        <td>
                                            <span class="badge bg-secondary">
                                                <?= htmlspecialchars($item['gaveta']) ?>
                                            </span>
                                        </td>

                                        <td><?= htmlspecialchars($item['data_formatada']) ?></td>

                                        <td>

                                            <?php if (!$exibindoConsulta): ?>

                                                <span class="badge bg-<?= ($item['dias_morgue'] > 15) ? 'danger' : 'warning text-dark' ?>">
                                                    <?= $item['dias_morgue'] ?> dias
                                                </span>

                                            <?php else: ?>

                                                <?= htmlspecialchars($item['operador'] ?? 'N/A') ?>

                                            <?php endif; ?>

                                        </td>

                                    <?php endif; ?>

                                    <td class="text-center no-print">
                                        <button
                                            class="btn btn-sm btn-outline-light"
                                            title="Imprimir Comprovativo"
                                            onclick="window.print()">
                                            <i class="bi bi-printer-fill"></i>
                                        </button>
                                    </td>

                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Nenhum registro encontrado para o período selecionado.
                                </td>
                            </tr>

                        <?php endif; ?>
                    </tbody>
                      
                </table>
            </div>
        </main>
    </div>
</body>
</html>