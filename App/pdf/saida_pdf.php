<?php

require_once __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../Model/Saida.php';
require_once __DIR__ . '/../Model/Dao/saidaDao.php';
require_once __DIR__ . '/../Controller/SaidaController.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// --------------------------------------------------
// 1. VALIDAR ID DA ENTRADA
// --------------------------------------------------

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID da entrada inválido.');
}

$id = (int) $_GET['id'];


// --------------------------------------------------
// 2. OBTER DADOS DA ENTRADA
// --------------------------------------------------

$saidaController = new SaidaController();

$ficha = $saidaController->FichaById($id);
$config = $saidaController->Confi();

if (empty($ficha)) {
    die('Ficha de entrada não encontrada.');
}


// --------------------------------------------------
// 3. CONFIGURAR DOMPDF
// --------------------------------------------------

$options = new Options();

$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);


// --------------------------------------------------
// 4. HTML DA FICHA
// --------------------------------------------------

$html = '
<!DOCTYPE html>
<html lang="pt">
<head>

<meta charset="UTF-8">

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

.section {
    border: 1.2px solid #1d5a8d;
    margin-top: 7px;
}

.section-title {
    background: #164f80;
    color: white;
    font-size: 11px;
    font-weight: bold;
    padding: 6px 9px;
}

.section-body {
    padding: 7px;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 5px;
}

.field {
    vertical-align: top;
}

.field label {
    display: block;
    font-weight: bold;
    margin-bottom: 2px;
    color: #164f80;
}

.value {
    min-height: 20px;
    background: #eef5fa;
    padding: 5px 7px;
    color: #193e61;
}

.declaration {
    border: 1px solid #a9bfd2;
    margin-top: 10px;
    padding: 7px;
    text-align: center;
    font-weight: bold;
}

.signatures {
    width: 100%;
    margin-top: 20px;
}

.signature {
    width: 31%;
    display: inline-block;
    text-align: center;
    vertical-align: top;
    margin-right: 2%;
}

.signature:last-child {
    margin-right: 0;
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

    <!-- CABEÇALHO -->

    <div class="header">

        <div class="brand">
            <div class="hospital">
                ' . htmlspecialchars($config['nome'] ?? 'DESCONHECIDO/A') . '
            </div>

            <div class="service">
                SERVIÇO DE GESTÃO DA MORGUE
            </div>

            <div class="motto">
                Saúde ao serviço da vida
            </div>
        </div>

        <div class="code-box">

            <div class="code-label">
                Código da Saída
            </div>

            <div class="code">
                ' . htmlspecialchars($ficha['codigo'] ?? 'DESCONHECIDO/A') . '
            </div>

            <div class="code-label">
                Data da Saída
            </div>

            <div>
                ' . htmlspecialchars($ficha['saida'] ?? 'DESCONHECIDO / A') . '
            </div>

        </div>

        <div class="clear"></div>

    </div>


    <!-- TÍTULO -->

    <div class="title">
        FICHA DE SAIDA DE FALECIDO
    </div>


    <!-- IDENTIFICAÇÃO -->

    <div class="section">

        <div class="section-title">
            1. IDENTIFICAÇÃO DO FALECIDO
        </div>

        <div class="section-body">

            <table>

                <tr>
                    <td colspan="3" class="field">
                        <label>Nome Completo</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['falecido'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>
                </tr>

                <tr>

                    <td class="field">
                        <label>Sexo</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['sexo'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>

                    <td class="field">
                        <label>Idade</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['idade'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>

                    <td class="field">
                        <label>Estado Civil</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['estado_civil'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>

                </tr>

                <tr>

                    <td class="field">
                        <label>Data de Nascimento</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['data_nascimento'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>

                    <td class="field">
                        <label>Nacionalidade</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['nacionalidade'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>

                    <td class="field">
                        <label>BI / Documento</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['bi'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>

                </tr>

                <tr>
                    <td colspan="3" class="field">
                        <label>Nome do Pai</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['pai'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="field">
                        <label>Nome da Mãe</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['mae'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="field">
                        <label>Endereço</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['endereco'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>
                </tr>

            </table>

        </div>

    </div>


    <!-- DADOS DA SAIDA -->

    <div class="section">

        <div class="section-title">
            2. DADOS DA SAÍDA
        </div>

        <div class="section-body">

            <table>

                <tr>

                    <td class="field">
                        <label>Data e Hora da SaÍda</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['saida'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>
                    <td class="field">
                        <label>Estado do Corpo</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['estado'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>
                    
                </tr>

                <tr>

                    <td colspan="2" class="field">
                        <label>Operador Responsável</label>
                        <div class="value">'
                            . htmlspecialchars($ficha['operador'] ?? 'DESCONHECIDO / A') .
                        '</div>
                    </td>

                </tr>

            </table>

        </div>

    </div>


    <!-- RECEPTOR -->

    <div class="section">

        <div class="section-title">
            3. DADOS DO RECEPTOR
        </div>

        <div class="section-body">

            <table>

                <tr>
                    <td colspan="3" class="field">

                        <label>Nome Completo</label>

                        <div class="value">'
                            . htmlspecialchars($ficha['receptor'] ?? 'DESCONHECIDO / A') .
                        '</div>

                    </td>
                </tr>

                <tr>

                    <td class="field">

                        <label>BI / Documento</label>

                        <div class="value">'
                            . htmlspecialchars($ficha['bi_receptor'] ?? 'DESCONHECIDO / A') .
                        '</div>

                    </td>

                </tr>

            </table>

        </div>

    </div>


    <!-- DECLARAÇÃO -->

    <div class="declaration">

        Declaro que as informações acima correspondem aos dados
        registados no sistema no momento da saída.

    </div>


    <!-- ASSINATURAS -->

    <div class="signatures">

        <div class="signature">
            <div class="signature-line">
                Responsável pela Saída<br>
                <strong>'
                    . htmlspecialchars($ficha['operador'] ?? 'DESCONHECIDO / A') .
                '</strong>
            </div>
        </div>

        <div class="signature">
            <div class="signature-line">
                Receptor<br>
                <strong>'
                    . htmlspecialchars($ficha['receptor'] ?? 'DESCONHECIDO / A') .
                '</strong>
            </div>
        </div>

        <div class="signature">
            <div class="signature-line">
                Data / Hora<br>
                <strong>'
                    . htmlspecialchars($ficha['saida'] ?? 'DESCONHECIDO / A') .
                '</strong>
            </div>
        </div>

    </div>


    <!-- RODAPÉ -->

    <div class="footer">

        <table>

            <tr>

                <td>
                    <strong>'
                        . htmlspecialchars($config['nome'] ?? 'DESCONHECIDO / A') .
                    '</strong>
                    Serviço de Gestão da Morgue
                </td>

                <td>
                    <strong>Contactos</strong>
                    +244 '
                        . htmlspecialchars($config['telefone'] ?? 'DESCONHECIDO / A') .
                    '
                </td>

                <td>
                    <strong>E-mail</strong>
                    '
                        . htmlspecialchars($config['email'] ?? 'DESCONHECIDO / A') .
                    '
                </td>

                <td>
                    <strong>Localização</strong>
                    '
                        . htmlspecialchars($config['endereco'] ?? 'DESCONHECIDO / A') .
                    '
                </td>

            </tr>

        </table>

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
    'Ficha_Entrada_' . ($ficha['codigo'] ?? $id) . '.pdf',
    [
        'Attachment' => false
    ]
);