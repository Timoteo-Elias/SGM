<?php

    require_once __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../Controller/DepositanteController.php';
    require_once __DIR__ . '/../Model/Dao/depositanteDao.php';
    require_once __DIR__ . '/../Model/depositante.php'; 
    use Model\Depositante;

    use Dompdf\Dompdf;
    use Dompdf\Options;

    $depositanteController = new DepositanteController(); 
    $depositantes = $depositanteController->lista();
    $config = $depositanteController->Confi();

// --------------------------------------------------
// 3. CONFIGURAR DOMPDF
// --------------------------------------------------

$options = new Options();

$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);


$linhas = '';
if(!empty($depositantes) && is_array( $depositantes)
) {
    foreach ($depositantes as $trim) {
        $linhas .= '
            <tr>
                <td>' . htmlspecialchars($trim['nome']) . '</td>
                <td>' . htmlspecialchars($trim['bi']) . '</td>
                <td>' . htmlspecialchars($trim['telefone']) . '</td>
                <td>' . htmlspecialchars($trim['tipo']) . '</td>
                <td>' . htmlspecialchars($trim['criado_em']) . '</td>
            </tr>';
    }
} else {
    $linhas = '<tr><td colspan="6">Nenhum depositante encontrado.</td></tr>';
}


$html = '
<!DOCTYPE html>
<html lang="pt">
<head>
    <style>

        @page {
            size: A4;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #173f68;
            font-size: 10px;
        }

        .page {
            width: 100%;
            background: #fff;
            padding: 3mm;
        }

        .header {
            width: 100%;
            margin-bottom: 8px;
        }

        .brand {
            width: 60%;
            float: left;
        }

        .hospital {
            font-size: 17px;
            font-weight: bold;
            line-height: 1.05;
            text-transform: uppercase;
        }

        .service {
            font-size: 10px;
            font-weight: bold;
            margin-top: 4px;
        }

        .motto {
            font-size: 8px;
            margin-top: 3px;
            color: #54718b;
        }

        .code-box {
            width: 30%;
            float: right;
            border: 1.5px solid #174f7f;
            padding: 5px;
            text-align: center;
        }

        .code-label {
            font-size: 8px;
            font-weight: bold;
            margin-top: 3px;
        }

        .code {
            font-size: 12px;
            font-weight: bold;
            margin: 3px 0;
            margin-bottom: 5px;
        }
        .clear {
            clear: both;
        }
        .title {
            background: #164f80;
            color: white;
            text-align: center;
            font-size: 17px;
            font-weight: bold;
            padding: 9px;
            margin-bottom: 8px;
        }
        .table-responsive{
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th {
            background-color: #0d6efd;
            color: white;
            padding: 8px;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        td {
            padding: 7px;
            border: 1px solid #dee2e6;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 8px;
            padding-top: 7px;
            border-top: 1px solid #9bb0c2;
            font-size: 7.5px;
            color: #31546f;
        }

        .footer table {
            border-spacing: 0;
        }

        .footer td {
            width: 25%;
            padding: 0 6px;
            border-right: 1px solid #b8c7d3;
        }

        .footer td:last-child {
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

    </style>
</head>

<body>

<div class="page">
    <div class="header">
        <div class="brand">
            <div class="hospital">
                ' . htmlspecialchars($config['nome'] ?? 'N/A') . '
            </div>

            <div class="service">
                SERVIÇO DE GESTÃO DA MORGUE
            </div>

            <div class="motto">
                Saúde ao serviço da vida
            </div>
        </div>
        <div class="code-box">
        </div>
        <div class="clear"></div>
    </div>
    <div class="title">
        LISTA DE DEPOSITANTES
    </div>
    <div class="section">

        <div class="table-responsive desktop-table">
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>Nome Completo</th>
                        <th>Bilhete de Identidade</th>
                        <th>Telefone</th>
                        <th>Tipo</th>
                        <th>Data de Cadastramento</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $linhas . '
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="footer">

        <table>

            <tr>

                <td>
                    <strong>'
                        . htmlspecialchars($config['nome'] ?? 'N/A') .
                    '</strong>
                    Serviço de Gestão da Morgue
                </td>

                <td>
                    <strong>Contactos</strong>
                    +244 '
                        . htmlspecialchars($config['telefone'] ?? 'N/A') .
                    '
                </td>

                <td>
                    <strong>E-mail</strong>
                    '
                        . htmlspecialchars($config['email'] ?? 'N/A') .
                    '
                </td>

                <td>
                    <strong>Localização</strong>
                    '
                        . htmlspecialchars($config['endereco'] ?? 'N/A') .
                    '
                </td>

            </tr>

        </table>

    </div>
    <div class="page-number">
        Documento gerado pelo SGM
    </div>

</div>

</body>
</html>
';


// --------------------------------------------------
// 5. GERAR PDF
// --------------------------------------------------

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();


// --------------------------------------------------
// 6. MOSTRAR PDF NO NAVEGADOR
// --------------------------------------------------

$dompdf->stream(
    'Lista_Depositante.pdf',
    [
        'Attachment' => false
    ]
);