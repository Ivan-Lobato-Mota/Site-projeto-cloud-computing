<?php
declare(strict_types=1);

/*
 * Carbide Chef's Corner — gerador de receitas de fogueira.
 *
 * Os ingredientes e efeitos abaixo vêm da wiki oficial
 * (https://wiki.cavesofqud.com/wiki/Cooking): cada ingrediente pertence a
 * um domínio culinário; um domínio fornece efeitos básicos e, quando
 * combinado com outro, pode formar um efeito disparado — um ingrediente
 * dá a condição de gatilho ("Sempre que...") e o outro dá o resultado.
 *
 * Toda a aleatoriedade usa mt_rand(); com mt_srand($semente) a mesma
 * receita pode ser reproduzida pelo número.
 */

/** Domínios culinários: efeitos básicos, condição de gatilho e efeitos disparados. */
const DOMINIOS = [
    'regeneração e cura' => [
        'basicos' => [
            '+10–15% na taxa de cura natural',
            '+8–12 em testes de resistência contra Sangramento',
        ],
        'gatilho' => 'Sempre que você usar uma salve ou um injetor de ubernostrum,',
        'disparados' => [
            'você ganha +100% na taxa de cura natural por 50 turnos.',
            'você fecha todas as feridas abertas e para de sangrar.',
        ],
    ],
    'regeneração poderosa' => [
        'basicos' => ['+100% na taxa de cura natural'],
        'gatilho' => 'Sempre que você tomar dano, há 30–40% de chance de que',
        'disparados' => ['você recupere imediatamente 3d6 pontos de vida.'],
    ],
    'HP' => [
        'basicos' => ['+10–15% de HP máximo'],
        'gatilho' => 'Sempre que você cair abaixo de 20% do HP,',
        'disparados' => ['você ganha +20% de HP máximo por 50 turnos.'],
    ],
    'calor e fogo' => [
        'basicos' => [
            'Pode usar Mãos Flamejantes no nível 1–2 (se já tiver, é aprimorada em 2–3 níveis)',
            'Pode usar Sopro de Fogo no nível 1–2 (se já tiver, é aprimorado em 2–3 níveis)',
            'Pode usar Pirocinese no nível 1–2 (se já tiver, é aprimorada em 2–3 níveis)',
            '+10–15 de Resistência a Calor',
        ],
        'gatilho' => 'Sempre que você causar dano de fogo, há 10% de chance de que',
        'disparados' => [
            'você lance chamas como Mãos Flamejantes no nível 5–6.',
            'você aqueça o ar ao redor como Pirocinese no nível 4–5.',
        ],
    ],
    'elétrico' => [
        'basicos' => [
            'Pode usar Pulso Eletromagnético no nível 2–3 (se já tiver, é aprimorado em 3–4 níveis)',
            'Pode usar Geração Elétrica no nível 1–2 (se já tiver, é aprimorada em 2–3 níveis)',
            '+10–15 de Resistência Elétrica',
        ],
        'gatilho' => 'Sempre que você causar dano elétrico, há 25% de chance de que',
        'disparados' => ['você descarregue um arco voltaico como Geração Elétrica no nível 5–6.'],
    ],
    'frio' => [
        'basicos' => [
            '+10–15 de Resistência a Frio',
            'Pode usar Mãos Congelantes no nível 1–2 (se já tiver, é aprimorada em 2–3 níveis)',
            'Pode usar Criocinese no nível 1–2 (se já tiver, é aprimorada em 2–3 níveis)',
        ],
        'gatilho' => 'Sempre que você causar dano de frio, há 25% de chance de que',
        'disparados' => [
            'você emita um raio de gelo como Mãos Congelantes no nível 5–6.',
            'você ganhe 125–175 de Resistência a Frio por 50 turnos.',
        ],
    ],
    'agilidade' => [
        'basicos' => ['+4 de Agilidade'],
        'gatilho' => 'Sempre que você acertar um golpe crítico,',
        'disparados' => [
            'você apunhala seu oponente.',
            'você ganha +8 de Agilidade por 50 turnos.',
        ],
    ],
    'força' => [
        'basicos' => [
            '+4 de Força',
            'Pode usar Intimidar (se já tiver, +2 no teste de Ego ao intimidar)',
        ],
        'gatilho' => 'Sempre que você cair abaixo de 30% do HP,',
        'disparados' => ['você ganha +8 de Força por 50 turnos.'],
    ],
    'vontade' => [
        'basicos' => ['+4 de Vontade'],
        'gatilho' => null,
        'disparados' => [],
    ],
    'amor e lealdade' => [
        'basicos' => [
            '+4 de Ego',
            'Pode usar Fascinar no nível 1–2 (se já tiver, é aprimorada em 2–3 níveis)',
        ],
        'gatilho' => 'Sempre que você ganhar um novo seguidor,',
        'disparados' => ['você e seus seguidores curam 3d6 pontos de vida.'],
    ],
    'medo' => [
        'basicos' => [
            '+2 de MA',
            'Pode usar Intimidar (se já tiver, +2 no teste de Ego ao intimidar)',
        ],
        'gatilho' => 'Sempre que você ficar com medo,',
        'disparados' => ['você exala uma nuvem apavorante e todos ao redor fogem por 10 turnos.'],
    ],
    'escuridão' => [
        'basicos' => ['+4 de DV'],
        'gatilho' => null,
        'disparados' => [],
    ],
    'faseamento' => [
        'basicos' => [
            'Sempre que você tomar dano, há 15–20% de chance de fasear por 8–10 turnos',
            'Pode usar Faseamento no nível 1–2 (se já tiver, é aprimorado em 2–3 níveis)',
            'Efeitos de fase duram o dobro',
        ],
        'gatilho' => 'Sempre que você fasear para fora,',
        'disparados' => ['você ganha +6% de Velocidade de Movimento por 20 turnos.'],
    ],
    'teleporte' => [
        'basicos' => [
            'Pode usar Teleportar Outro no nível 1–2 (se já tiver, é aprimorado em 2–3 níveis)',
            'Sempre que você tomar dano, há 20–25% de chance de se teleportar para um ponto aleatório do mapa',
        ],
        'gatilho' => 'Sempre que você se teleportar,',
        'disparados' => ['você deixa para trás uma nuvem de gás confusor.'],
    ],
    'reflexão de dano' => [
        'basicos' => [
            'Pode usar Espinhos no nível 5–6 (se já tiver, é aprimorada em 3–4 níveis)',
            'Reflete 3–4% do dano de volta aos atacantes, arredondado para cima',
        ],
        'gatilho' => 'Sempre que você tomar dano, há 8–10% de chance de que',
        'disparados' => [
            'você expila espinhos como a mutação Espinhos no nível 8–9.',
            'você reflita 100% do dano na próxima vez que tomar dano em 50 turnos.',
        ],
    ],
    'reflexão poderosa' => [
        'basicos' => ['Reflete 15–18% do dano de volta aos atacantes, arredondado para cima'],
        'gatilho' => 'Sempre que você refletir dano,',
        'disparados' => ['você reflete 100% do dano na próxima vez que tomar dano em 50 turnos.'],
    ],
    'armadura' => [
        'basicos' => ['+2 de AV'],
        'gatilho' => 'Sempre que você sofrer uma penetração física de 2× ou mais,',
        'disparados' => ['você ganha +6 de AV por 50 turnos.'],
    ],
    'borracha' => [
        'basicos' => [
            'Sempre que você pular, pode pular de novo imediatamente',
            '+10–15 de Resistência Elétrica',
            'Dano de queda reduzido em 50%',
        ],
        'gatilho' => 'Sempre que você pular,',
        'disparados' => ['você quica: pode pular mais duas vezes imediatamente.'],
    ],
    'fungo' => [
        'basicos' => [
            '+300 de reputação com fungos',
            '75% de chance de a coceira na pele não virar infecção fúngica',
        ],
        'gatilho' => 'Sempre que você comer um cogumelo,',
        'disparados' => ['esporos amigáveis brotam ao seu redor e lutam ao seu lado.'],
    ],
    'planta' => [
        'basicos' => [
            'Pode usar Brotamento no nível 1–2 (se já tiver, é aprimorado em 2–3 níveis)',
            '+100 de reputação com flores, raízes, suculentas, árvores, vinhas e o Consórcio de Phyta',
        ],
        'gatilho' => 'Sempre que você tomar dano de uma planta,',
        'disparados' => ['a vegetação se desculpa e floresce: você cura 2d6 pontos de vida.'],
    ],
    'artefato' => [
        'basicos' => ['Pode usar Psicometria no nível 1–2 (se já tiver, é aprimorada em 3–4 níveis)'],
        'gatilho' => 'Sempre que você identificar um artefato,',
        'disparados' => ['você identifica todos os artefatos do mapa local.'],
    ],
    'doença' => [
        'basicos' => [
            '+3 em testes de resistência contra Doença',
            'Você só fica Enfermo por 1/10 do tempo normal',
        ],
        'gatilho' => 'Sempre que você beber mel,',
        'disparados' => ['você é curado de todas as enfermidades menores.'],
    ],
    'água e sede' => [
        'basicos' => ['Você sente sede na metade do ritmo normal'],
        'gatilho' => 'Sempre que você beber água doce, há 25% de chance de que',
        'disparados' => ['você não gaste o gole: a água doce é devolvida ao cantil.'],
    ],
    'rapidez' => [
        'basicos' => ['+4–5 de Rapidez'],
        'gatilho' => null,
        'disparados' => [],
    ],
    'língua' => [
        'basicos' => ['Pode usar Língua Pegajosa no nível 4–5 (se já tiver, é aprimorada em 4–5 níveis)'],
        'gatilho' => 'Sempre que você ficar preso, há 50% de chance de que',
        'disparados' => ['você se puxe para fora com a língua, elegantemente.'],
    ],
    'atributo incerto' => [
        'basicos' => ['25% de chance de ganhar +1 de Força, Agilidade, Vigor, Inteligência, Vontade e Ego permanentemente'],
        'gatilho' => null,
        'disparados' => [],
    ],
    'densidade volátil' => [
        'basicos' => ['+1 de AV permanentemente. Pequena chance de colapso gravitacional'],
        'gatilho' => null,
        'disparados' => [],
    ],
    'clonagem' => [
        'basicos' => ['Faz você se multiplicar de 1 a 3 vezes'],
        'gatilho' => null,
        'disparados' => [],
    ],
    'segredo' => [
        'basicos' => ['Revela um segredo para você'],
        'gatilho' => null,
        'disparados' => [],
    ],
    'gostoso' => [
        'basicos' => ['Refeição garantidamente saborosa se comida com fome (bônus extra de sabor)'],
        'gatilho' => null,
        'disparados' => [],
    ],
];

/** Ingredientes da wiki, com nome exibido e domínio culinário. */
const INGREDIENTES = [
    ['geleia de starapple', 'regeneração e cura'],
    ['unguento coagulado', 'regeneração e cura'],
    ['coalhada de alma', 'regeneração poderosa'],
    ['charque de cabra', 'HP'],
    ['charque de urso', 'HP'],
    ['charque de crocodilo', 'HP'],
    ['charque de scorpiock', 'HP'],
    ['charque de besouro', 'HP'],
    ['pasta de gáster de formiga-de-fogo', 'calor e fogo'],
    ['cauda curada de dawnglider', 'calor e fogo'],
    ['blaze coagulado', 'calor e fogo'],
    ['lava (uma concha)', 'calor e fogo'],
    ['plasma de carrapato-faísca', 'elétrico'],
    ['hoarshrooms liofilizados', 'frio'],
    ['skulk coagulado', 'agilidade'],
    ['mel de hulk coagulado', 'força'],
    ['purê de lag', 'vontade'],
    ['amor coagulado', 'amor e lealdade'],
    ['pétalas secas de lah', 'medo'],
    ['pétalas secas de vanta', 'escuridão'],
    ['óleo de sombra coagulado', 'faseamento'],
    ['seda de fase', 'faseamento'],
    ['pasta de glândula de voider', 'teleporte'],
    ['yondercane fermentado', 'teleporte'],
    ['geleia de fruta-espinho', 'reflexão de dano'],
    ['pó de espelho', 'reflexão poderosa'],
    ['farinha de osso', 'armadura'],
    ['goma-elástica coagulada', 'borracha'],
    ['bochecha de bop fatiada', 'borracha'],
    ['cogumelos em conserva', 'fungo'],
    ['verduras Ekuemekiyyen', 'planta'],
    ['musgo de túmulo triturado', 'planta'],
    ['banana seca ao sol', 'artefato'],
    ['talo de yuckwheat fermentado', 'doença'],
    ['mel', 'doença'],
    ['picles', 'água e sede'],
    ['feixe de vinewafer', 'água e sede'],
    ['cidra', 'rapidez'],
    ['língua fermentada', 'língua'],
    ['gota de néctar', 'atributo incerto'],
    ['fluxo de nêutrons', 'densidade volátil'],
    ['poção de clonagem', 'clonagem'],
    ['pasta de glândula psíquica', 'segredo'],
    ['sal', 'gostoso'],
    ['naco de pão casca-dura', 'gostoso'],
    ['chip de salthopper', 'gostoso'],
];

/**
 * Gera uma receita aleatória de fogueira.
 *
 * @return array{nome:string, ingredientes:string[], efeitos:string[], nota:string, perigosa:bool}
 */
function gerar_receita(): array
{
    // 2 ou 3 ingredientes de domínios distintos, como manda a wiki
    // (repetir domínio na mesma receita não tem efeito).
    $quantos = mt_rand(1, 100) <= 55 ? 2 : 3;

    $indices = range(0, count(INGREDIENTES) - 1);
    $escolhidos = [];
    $dominiosUsados = [];
    while (count($escolhidos) < $quantos && $indices !== []) {
        $pos = mt_rand(0, count($indices) - 1);
        $idx = $indices[$pos];
        array_splice($indices, $pos, 1);
        [$nome, $dominio] = INGREDIENTES[$idx];
        if (in_array($dominio, $dominiosUsados, true)) {
            continue;
        }
        $escolhidos[] = ['nome' => $nome, 'dominio' => $dominio];
        $dominiosUsados[] = $dominio;
    }

    $efeitos = [];
    $restantes = $escolhidos;

    // Com 2+ ingredientes há chance de um efeito disparado: o jogo sorteia
    // qual ingrediente fornece a condição de gatilho e qual fornece o
    // resultado — então tentamos os dois pareamentos possíveis.
    if (count($escolhidos) >= 2 && mt_rand(1, 100) <= 65) {
        $a = $escolhidos[0]['dominio'];
        $b = $escolhidos[1]['dominio'];
        $pares = mt_rand(0, 1) === 0 ? [[$a, $b], [$b, $a]] : [[$b, $a], [$a, $b]];
        foreach ($pares as [$domGatilho, $domEfeito]) {
            $gatilho = DOMINIOS[$domGatilho]['gatilho'];
            $resultados = DOMINIOS[$domEfeito]['disparados'];
            if ($gatilho !== null && $resultados !== []) {
                $efeitos[] = $gatilho . ' ' . $resultados[mt_rand(0, count($resultados) - 1)];
                $restantes = array_slice($escolhidos, 2);
                break;
            }
        }
    }

    // Os demais ingredientes contribuem com um efeito básico cada.
    foreach ($restantes as $ing) {
        $basicos = DOMINIOS[$ing['dominio']]['basicos'];
        $efeitos[] = $basicos[mt_rand(0, count($basicos) - 1)] . '.';
    }

    $nomes = array_column($escolhidos, 'nome');

    return [
        'nome'         => nome_do_prato($nomes),
        'ingredientes' => $nomes,
        'efeitos'      => $efeitos,
        'nota'         => nota_de_rodape(),
        'perigosa'     => in_array('fluxo de nêutrons', $nomes, true),
    ];
}

/** @param string[] $ingredientes */
function nome_do_prato(array $ingredientes): string
{
    $preparos = [
        'Ensopado', 'Guisado', 'Mingau', 'Assado', 'Espetinho', 'Caldo',
        'Escondidinho', 'Torrada', 'Farofa', 'Moqueca', 'Cuscuz', 'Paçoca',
    ];
    $estilos = [
        'à moda de Joppa', 'do Six Day Stilt', 'à issachari', 'barathrumita',
        'dos hindren', 'do peregrino', 'de Kyakukya', 'dos mecanimistas',
        'das dunas', 'da estrada de sal',
    ];

    $prep = $preparos[mt_rand(0, count($preparos) - 1)];
    $principal = $ingredientes[0];

    if (count($ingredientes) >= 2 && mt_rand(1, 100) <= 50) {
        return sprintf('%s de %s com %s', $prep, $principal, $ingredientes[1]);
    }
    if (mt_rand(1, 100) <= 25) {
        return sprintf('Surpresa de %s %s', $principal, $estilos[mt_rand(0, count($estilos) - 1)]);
    }
    return sprintf('%s de %s %s', $prep, $principal, $estilos[mt_rand(0, count($estilos) - 1)]);
}

function nota_de_rodape(): string
{
    $notas = [
        'Serve dois mutantes famintos.',
        'Melhor apreciado sob as duas luas.',
        'Acompanha um dracma de água doce (não incluso).',
        'Receita lembrada graças à habilidade Carbide Chef.',
        'Cozinhe apenas em fogueira acesa; forno de barro é luxo.',
        'Se sobrar, não sobra: os snapjaws sentem o cheiro.',
        'Aprovada por três em cada quatro dromedários mercadores.',
        'Mexa com o terceiro braço para não perder o ponto.',
        'O segredo é a paciência. E o sal. Principalmente o sal.',
        'Não recomendada antes do ritual da água.',
    ];
    return $notas[mt_rand(0, count($notas) - 1)];
}
