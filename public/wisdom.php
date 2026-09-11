<?php
declare(strict_types=1);

require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/layout.php';
require __DIR__ . '/../includes/markov.php';

// Cada fragmento é identificado por um número-semente: a mesma semente
// gera sempre o mesmo texto, então cada tomo tem link permanente.
$semente = isset($_GET['fragmento'])
    ? max(1, min(999999, (int) $_GET['fragmento']))
    : random_int(1, 999999);
mt_srand($semente);

$corpus = (string) @file_get_contents(DATA_DIR . '/corpus.txt');
$markov = new MarkovChain($corpus);

$titulo = gerar_titulo_de_tomo();
$paragrafos = [];
$quantos = mt_rand(2, 3);
for ($i = 0; $i < $quantos; $i++) {
    $paragrafos[] = $markov->gerar(28, 65);
}

$proximo = random_int(1, 999999);

render_header('wisdom', "Salt's Wisdom");
?>

<div class="box">
  <div class="box-titulo">&#9788; salt's wisdom — o oráculo do sal</div>
  <div class="box-corpo">
    <p>Nas prensas dos livreiros do Six Day Stilt, os tomos são cópias de cópias de cópias,
    e a cada cópia o texto muda um pouco — até que nenhum livro é de autor nenhum, e todos
    são do sal. Esta página faz o mesmo: alimentei a máquina com os aforismos do meu caderno
    de estrada e deixo o acaso encaderná-los de novo a cada visita.</p>
    <p class="mini">&#9670; nota do escriba-técnico: cadeia de Markov de ordem 2, treinada sobre o corpus
    de aforismos em cada carregamento da página. A semente numérica torna cada fragmento reproduzível.</p>
  </div>
</div>

<div class="tomo">
  <h2 class="tomo-titulo"><?= h($titulo) ?></h2>
  <p class="tomo-sub">fragmento n&ordm; <?= $semente ?> &mdash; recuperado das prensas do Stilt &mdash; autoria dissolvida no sal</p>
  <div class="tomo-texto">
    <?php foreach ($paragrafos as $p): ?>
    <p><?= h($p) ?></p>
    <?php endforeach; ?>
  </div>
  <p class="tomo-fim">&#9552;&#9552;&#9552; fim do fragmento &#9552;&#9552;&#9552;</p>
</div>

<p class="centro" style="margin: 14px 0;">
  <a class="botao" href="wisdom.php?fragmento=<?= $proximo ?>">&#9788; consultar o sal novamente</a>
</p>

<div class="box">
  <div class="box-corpo centro mini">
    <p>link permanente deste fragmento:
    <a href="wisdom.php?fragmento=<?= $semente ?>">wisdom.php?fragmento=<?= $semente ?></a><br>
    guarde o número como se guarda um verso: ele sempre reabre a mesma página do mesmo livro.</p>
  </div>
</div>

<?php render_footer(); ?>
