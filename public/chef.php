<?php
declare(strict_types=1);

require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/layout.php';
require __DIR__ . '/../includes/recipes.php';

// Mesma mecânica do oráculo: uma semente numérica identifica a receita.
$semente = isset($_GET['receita'])
    ? max(1, min(999999, (int) $_GET['receita']))
    : random_int(1, 999999);
mt_srand($semente);

$receita = gerar_receita();
$proxima = random_int(1, 999999);

render_header('chef', "Carbide Chef's Corner");
?>

<div class="box">
  <div class="box-titulo">&#9836; carbide chef's corner — cozinha de fogueira</div>
  <div class="box-corpo">
    <p>Todo acampamento tem duas fogueiras: uma para o frio e outra para a alma — e a segunda
    é a panela. Quando a inspiração desce (os cozinheiros do Stilt chamam isso de
    <b class="c-ouro">Carbide Chef</b>), invento um prato novo e anoto aqui antes que a memória
    evapore. Os ingredientes vêm da minha trouxa e dos bazares do caminho; os efeitos, quem
    explica é a <a href="https://wiki.cavesofqud.com/wiki/Cooking" rel="external">wiki dos peregrinos</a>.</p>
    <p class="mini">&#9670; combinar dois ingredientes pode gerar um efeito disparado: um dá o gatilho
    ("sempre que..."), o outro dá o resultado. Repetir domínio culinário não faz efeito — a panela sabe.</p>
  </div>
</div>

<div class="receita">
  <h2 class="receita-nome"><?= h($receita['nome']) ?></h2>

  <div class="receita-secao">
    <h3>ingredientes</h3>
    <ul class="receita-ingredientes">
      <?php foreach ($receita['ingredientes'] as $ing): ?>
      <li><?= h($ing) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div class="receita-secao">
    <h3>efeitos da refeição</h3>
    <div class="receita-efeitos">
      <?php foreach ($receita['efeitos'] as $efeito): ?>
      <p>&#9670; <?= h($efeito) ?></p>
      <?php endforeach; ?>
    </div>
  </div>

  <?php if ($receita['perigosa']): ?>
  <div class="receita-aviso">
    &#9888; AVISO DO ESCRIBA: cozinhar com fluxo de nêutrons pode causar
    <b>colapso gravitacional</b>. O autor deste diário não se responsabiliza
    por crateras, singularidades ou vizinhos achatados.
  </div>
  <?php endif; ?>

  <p class="receita-nota">&#9998; <?= h($receita['nota']) ?></p>
</div>

<p class="centro" style="margin: 14px 0;">
  <a class="botao" href="chef.php?receita=<?= $proxima ?>">&#9836; cozinhar outro prato</a>
</p>

<div class="box">
  <div class="box-corpo centro mini">
    <p>receita n&ordm; <?= $semente ?> &mdash; link permanente:
    <a href="chef.php?receita=<?= $semente ?>">chef.php?receita=<?= $semente ?></a><br>
    despensa atual do peregrino: <?= count(INGREDIENTES) ?> ingredientes catalogados da wiki.</p>
  </div>
</div>

<?php render_footer(); ?>
