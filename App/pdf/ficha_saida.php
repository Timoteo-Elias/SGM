<?php
    require_once __DIR__ . '/../config/conexao.php';
    require_once __DIR__ . '/../Model/Dao/saidaDao.php';
    require_once __DIR__ . '/../Controller/SaidaController.php';
    require_once __DIR__ . '/../Model/Saida.php';
    use Model\Saida;
    // 2. INSTANCIAR AS CAMADAS (O "Motor" do MVC)
    // (Ajusta a forma como geras a tua conexão PDO se usares uma classe própria)
    $saidaController = new SaidaController();


    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $ficha = $saidaController->FichaById($id);
    }
    $config = $saidaController->Confi();

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../Public/bootstrap-icons/font/bootstrap-icons.min.css">
    <script src="../../Public/js/bootstrap.min.js"></script>
    <title>Ficha de Entrada de Falecido</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #e9edf2;
            font-family: Arial, Helvetica, sans-serif;
            color: #173f68;
            font-size: 10px;
        }

        .page {
            width: 190mm;
            min-height: 277mm;
            margin: 10mm auto;
            background: #fff;
            padding: 7mm;
            border: 1px solid #d7e1ea;
        }

        .header {
            display: grid;
            grid-template-columns: 1fr 58mm;
            gap: 8px;
            align-items: center;
            margin-bottom: 8px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            width: 27mm;
            height: 20mm;
            border: 2px solid #174f7f;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            font-weight: bold;
            color: #174f7f;
        }

        .hospital {
            font-size: 17px;
            font-weight: 800;
            line-height: 1.05;
        }

        .service {
            font-size: 10px;
            font-weight: 700;
            margin-top: 4px;
        }

        .motto {
            font-size: 8px;
            margin-top: 3px;
            color: #54718b;
        }

        .code-box {
            border: 1.5px solid #174f7f;
            border-radius: 5px;
            padding: 5px;
            text-align: center;
        }

        .code-label {
            font-size: 8px;
            font-weight: bold;
        }

        .code {
            font-size: 12px;
            font-weight: 800;
            margin: 3px 0;
        }

        .qr {
            width: 20mm;
            height: 20mm;
            margin: 4px auto;
            border: 1px solid #aaa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #777;
        }

        .section {
            border: 1.2px solid #1d5a8d;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 7px;
        }

        .section-title {
            background: #164f80;
            color: white;
            font-size: 11px;
            font-weight: 800;
            padding: 6px 9px;
        }

        .section-body {
            padding: 7px;
        }

        .title {
            background: #164f80;
            color: white;
            text-align: center;
            font-size: 17px;
            font-weight: 800;
            padding: 9px;
            border-radius: 5px;
            margin-bottom: 8px;
            letter-spacing: .3px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 6px;
        }

        .col-12 { grid-column: span 12; }
        .col-8 { grid-column: span 8; }
        .col-6 { grid-column: span 6; }
        .col-4 { grid-column: span 4; }

        .field label {
            display: block;
            font-weight: 700;
            margin-bottom: 2px;
            color: #164f80;
        }

        .value {
            min-height: 20px;
            background: #eef5fa;
            border-radius: 2px;
            padding: 5px 7px;
            color: #193e61;
        }

       

        .document {
            height: 28mm;
            margin-top: 6px;
            border: 1px solid #b7c9d8;
            background: #f4f8fb;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #7890a5;
            font-weight: bold;
        }

        .observacao {
            min-height: 15mm;
        }

        .declaration {
            border: 1px solid #a9bfd2;
            margin-top: 7px;
            padding: 7px;
            text-align: center;
            font-weight: 700;
        }

        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-top: 12px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #50708c;
            padding-top: 4px;
            font-size: 8px;
        }

        .footer {
            margin-top: 8px;
            padding-top: 7px;
            border-top: 1px solid #9bb0c2;
            display: grid;
            grid-template-columns: 1.1fr 1fr 1.2fr 1.1fr;
            gap: 8px;
            font-size: 7.5px;
            color: #31546f;
        }

        .footer-item {
            border-right: 1px solid #b8c7d3;
            padding-right: 7px;
        }

        .footer-item:last-child {
            border-right: 0;
        }

        .footer strong {
            display: block;
            color: #164f80;
            margin-bottom: 2px;
        }

        .page-number {
            text-align: right;
            font-size: 7px;
            color: #718596;
            margin-top: 4px;
        }

        @media print {
            body { background: white; }
            .page {
                margin: 0;
                border: 0;
                width: 100%;
                min-height: auto;
            }
        }
    </style>
</head>

<body>
    <div class="page">

        <div class="header">
            <div class="brand">
                <div>
                    <div class="hospital" style="text-transform: uppercase;"><?= $config['nome'] ?? 'N/A' ?></div>
                    <div class="service">SERVIÇO DE GESTÃO DA MORGUE</div>
                    <div class="motto">Saúde ao serviço da vida</div>
                </div>
            </div>

            <div class="code-box">
                <div class="code-label">Código da Saída</div>
                <div class="code"><?= $ficha['codigo'] ?? 'N/A' ?></div>
                <div class="code-label">Data de Saída</div>
                <div><?= $ficha['saida'] ?? 'N/A' ?></div>
            </div>
        </div>

        <div class="title">FICHA DE ENTRADA DE FALECIDO</div>

        <div class="section">
            <div class="section-title">1. IDENTIFICAÇÃO DO FALECIDO</div>
            <div class="section-body identity">
                <div class="row">
                    <div class="field col-12 mb-2">
                        <label>Nome Completo</label>
                        <div class="value"><?= $ficha['falecido'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-4 mb-2">
                        <label>Sexo</label>
                        <div class="value"><?= $ficha['sexo'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-4 mb-2">
                        <label>Idade</label>
                        <div class="value"><?= $ficha['idade'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-4 mb-2">
                        <label>Estado Civil</label>
                        <div class="value"><?= $ficha['estado_civil'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-6 mb-2">
                        <label>Data de Nascimento</label>
                        <div class="value"><?= $ficha['data_nascimento'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-6 mb-2" >
                        <label>Nacionalidade</label>
                        <div class="value"><?= $ficha['nacionalidade'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-12 mb-2">
                        <label>BI / Documento</label>
                        <div class="value"><?= $ficha['bi'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-12 mb-2">
                        <label>Nome do Pai</label>
                        <div class="value"><?= $ficha['pai'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-12 mb-2">
                        <label>Nome da Mãe</label>
                        <div class="value"><?= $ficha['mae'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-12 mb-2">
                        <label>Endereço</label>
                        <div class="value"><?= $ficha['endereco'] ?? 'N/A' ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">2. DADOS DA ENTRADA</div>
            <div class="section-body">
                <div class="row">
                    <div class="field col-4 mb-2">
                        <label>Data e Hora da Entrada</label>
                        <div class="value"><?= $ficha['saida'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-4 mb-2">
                        <label>Estado do Corpo</label>
                        <div class="value"><?= $ficha['estado'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-4 mb-2">
                        <label>Operador Responsável</label>
                        <div class="value"><?= $ficha['operador'] ?? 'N/A' ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">3. DADOS DO RECEPTOR</div>
            <div class="section-body">
                <div class="row">
                    <div class="field col-6 mb-3">
                        <label>Nome Completo</label>
                        <div class="value"><?= $ficha['receptor'] ?? 'N/A' ?></div>
                    </div>
                    <div class="field col-6 mb-3">
                        <label>BI / Documento</label>
                        <div class="value"><?= $ficha['bi_receptor'] ?? 'N/A' ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="declaration">
            Declaro que as informações acima correspondem aos dados registados no sistema no momento da Saída.
        </div>

        <div class="signatures">
            <div class="signature-line">Responsável pela Entrada<br><strong><?= $ficha['operador'] ?? 'N/A' ?></strong></div>
            <div class="signature-line">Receptor<br><strong><?= $ficha['receptor'] ?? 'N/A' ?></strong></div>
            <div class="signature-line">Data / Hora<br><strong><?= $ficha['saida'] ?? 'N/A' ?></strong></div>
        </div>

        <div class="footer">
            <div class="footer-item">
                <strong><?= $config['nome'] ?? 'N/A' ?></strong>
                Serviço de Gestão da Morgue
            </div>
            <div class="footer-item">
                <strong>Contactos</strong>
                +244 <?= $config['telefone'] ?? 'N/A' ?><br>
            </div>
            <div class="footer-item">
                <strong>E-mail</strong>
                <?= $config['email'] ?? 'N/A' ?>
            </div>
            <div class="footer-item">
                <strong>Localização</strong>
                <?= $config['endereco'] ?? 'N/A' ?>
            </div>
        </div>

    </div>
    <div class=" container d-flex justify-content-end gap-2 mt-3 p-3">
        <a href="../Views/saidas.php" class="btn btn-sm btn-secondary">Voltar</a>
        <a href="saida_pdf.php?id=<?= $id ?>"
        target="_blank"
        class="btn btn-sm btn-danger">
            <i class="bi bi-file-earmark-pdf"></i>
            Gerar PDF
        </a>
    </div>
</body>
</html>