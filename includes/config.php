<?php
declare(strict_types=1);

/*
 * Sal & Cromo — diário de um peregrino mutante em Qud
 * Configuração global do site.
 */

define('ROOT_DIR', dirname(__DIR__));
define('DATA_DIR', ROOT_DIR . '/data');

const SITE_NAME     = 'Sal & Cromo';
const SITE_TAGLINE  = 'diário de peregrinação de Yassif de Joppa — mutante, escriba, quatro braços';
const SITE_AUTHOR   = 'Yassif de Joppa';
const LAST_UPDATE   = '11 de setembro de 2026';

/** Escapa texto para HTML. */
function h(?string $s): string
{
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Contador de visitas em arquivo, no melhor estilo anos 2000.
 * Se o arquivo não puder ser escrito (hospedagem somente leitura),
 * devolve 0 e o layout esconde o contador.
 */
function bump_counter(): int
{
    $file = DATA_DIR . '/counter.txt';
    $fp = @fopen($file, 'c+');
    if ($fp === false) {
        return 0;
    }
    $n = 0;
    if (flock($fp, LOCK_EX)) {
        $n = (int) stream_get_contents($fp) + 1;
        rewind($fp);
        ftruncate($fp, 0);
        fwrite($fp, (string) $n);
        fflush($fp);
        flock($fp, LOCK_UN);
    }
    fclose($fp);
    return $n;
}

/** Formata uma data ISO (aaaa-mm-dd) por extenso, em português. */
function data_por_extenso(string $iso): string
{
    $meses = [
        1 => 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho',
        'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro',
    ];
    $partes = explode('-', $iso);
    if (count($partes) !== 3) {
        return $iso;
    }
    [$ano, $mes, $dia] = array_map('intval', $partes);
    $nomeMes = $meses[$mes] ?? '?';
    return sprintf('%d de %s de %d', $dia, $nomeMes, $ano);
}
