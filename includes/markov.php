<?php
declare(strict_types=1);

/*
 * Salt's Wisdom — gerador de texto por cadeia de Markov.
 *
 * Os livros de Caves of Qud são gerados com cadeias de Markov treinadas
 * sobre um corpus de textos do jogo. Aqui fazemos o mesmo, em escala de
 * fogueira: uma cadeia de ordem 2 (bigrama -> próxima palavra) treinada
 * sobre data/corpus.txt, um caderno de aforismos coletados na estrada.
 *
 * Toda a aleatoriedade usa mt_rand(), então um mt_srand($semente) antes
 * de gerar torna cada fragmento reproduzível por número.
 */

final class MarkovChain
{
    /** @var array<string, string[]> bigrama ("w1 w2") -> possíveis próximas palavras */
    private array $chain = [];

    /** @var string[] bigramas que iniciam frases no corpus */
    private array $starts = [];

    public function __construct(string $corpus)
    {
        $palavras = preg_split('/\s+/u', trim($corpus), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $total = count($palavras);
        if ($total < 3) {
            return;
        }

        for ($i = 0; $i < $total - 2; $i++) {
            $w1 = $palavras[$i];
            $w2 = $palavras[$i + 1];
            $w3 = $palavras[$i + 2];

            $chave = $w1 . ' ' . $w2;
            $this->chain[$chave][] = $w3;

            // Um bigrama inicia frase se vem depois de pontuação final
            // (ou se abre o corpus) e começa com maiúscula.
            $anterior = $i > 0 ? $palavras[$i - 1] : '.';
            if (preg_match('/[.!?]["»]?$/u', $anterior) && preg_match('/^\p{Lu}/u', $w1)) {
                $this->starts[] = $chave;
            }
        }

        if ($this->starts === []) {
            $this->starts = array_keys($this->chain);
        }
    }

    /**
     * Gera um trecho de texto com tamanho aproximado em palavras.
     * Caminha pela cadeia até fechar uma frase depois do mínimo pedido.
     */
    public function gerar(int $minPalavras = 30, int $maxPalavras = 70): string
    {
        if ($this->chain === []) {
            return 'O sal ficou em silêncio.';
        }

        $chave = $this->starts[mt_rand(0, count($this->starts) - 1)];
        $saida = explode(' ', $chave);

        while (count($saida) < $maxPalavras) {
            $opcoes = $this->chain[$chave] ?? null;
            if ($opcoes === null) {
                // Beco sem saída: recomeça de outro início de frase.
                $ultima = $saida[count($saida) - 1];
                if (!preg_match('/[.!?]$/u', $ultima)) {
                    $saida[count($saida) - 1] = rtrim($ultima, ',;:') . '.';
                }
                if (count($saida) >= $minPalavras) {
                    break;
                }
                $chave = $this->starts[mt_rand(0, count($this->starts) - 1)];
                array_push($saida, ...explode(' ', $chave));
                continue;
            }

            $proxima = $opcoes[mt_rand(0, count($opcoes) - 1)];
            $saida[] = $proxima;

            $fimDeFrase = (bool) preg_match('/[.!?]["»]?$/u', $proxima);
            if ($fimDeFrase && count($saida) >= $minPalavras) {
                break;
            }

            $anterior = $saida[count($saida) - 2];
            $chave = $anterior . ' ' . $proxima;
        }

        $texto = implode(' ', $saida);
        if (!preg_match('/[.!?]["»]?$/u', $texto)) {
            $texto = rtrim($texto, ',;: ') . '.';
        }
        return $texto;
    }
}

/**
 * Gera um título de tomo no estilo dos livros impressos no Six Day Stilt.
 */
function gerar_titulo_de_tomo(): string
{
    $temas = [
        'do Sal', 'da Água', 'do Cromo', 'da Poeira', 'do Deserto',
        'das Duas Luas', 'da Ferrugem', 'dos Sultões', 'do Peregrino',
        'do Fuso', 'das Dunas', 'da Sede', 'dos Caminhos', 'do Aço Vivo',
    ];
    $formas = [
        'Aforismos %s',
        'O Livro %s',
        'Cânticos %s',
        'Salmos %s',
        'Provérbios %s',
        'O Evangelho Apócrifo %s',
        'Fragmentos %s',
        'Meditações %s',
        'Sobre a Natureza %s',
        'As Parábolas %s',
    ];
    $sufixos = ['', '', '', ', vol. II', ', vol. VII', ', vol. XIX', ' (edição do bazar)', ' (cópia de cópia)'];

    $titulo = sprintf(
        $formas[mt_rand(0, count($formas) - 1)],
        $temas[mt_rand(0, count($temas) - 1)]
    );
    return $titulo . $sufixos[mt_rand(0, count($sufixos) - 1)];
}
