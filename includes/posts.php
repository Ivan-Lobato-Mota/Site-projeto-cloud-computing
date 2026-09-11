<?php
declare(strict_types=1);

/*
 * Carrega as postagens do diário a partir de arquivos-texto em data/posts/.
 *
 * Formato de cada arquivo:
 *
 *   title: Título do post
 *   date: 2026-07-19
 *   location: Joppa
 *   mood: esperançoso
 *   listening: o coaxar dos sapos
 *   ---
 *   Parágrafos do corpo, separados por linha em branco.
 */

/**
 * @return array<int, array{title:string,date:string,location:string,mood:string,listening:string,paragraphs:string[],slug:string}>
 */
function load_posts(): array
{
    $posts = [];
    foreach (glob(DATA_DIR . '/posts/*.txt') ?: [] as $file) {
        $raw = file_get_contents($file);
        if ($raw === false) {
            continue;
        }
        $raw = str_replace("\r\n", "\n", trim($raw));
        $sep = strpos($raw, "\n---\n");
        if ($sep === false) {
            continue;
        }

        $meta = [];
        foreach (explode("\n", substr($raw, 0, $sep)) as $linha) {
            if (preg_match('/^(\w+):\s*(.+)$/u', trim($linha), $m)) {
                $meta[strtolower($m[1])] = trim($m[2]);
            }
        }

        $corpo = trim(substr($raw, $sep + 5));
        $paragrafos = preg_split('/\n\s*\n/u', $corpo) ?: [];

        $posts[] = [
            'title'      => $meta['title'] ?? 'Sem título',
            'date'       => $meta['date'] ?? '1000-01-01',
            'location'   => $meta['location'] ?? '',
            'mood'       => $meta['mood'] ?? '',
            'listening'  => $meta['listening'] ?? '',
            'paragraphs' => array_map('trim', $paragrafos),
            'slug'       => basename($file, '.txt'),
        ];
    }

    // Ordem cronológica: do início da viagem até hoje.
    usort($posts, fn(array $a, array $b): int => strcmp($a['date'], $b['date']));
    return $posts;
}
