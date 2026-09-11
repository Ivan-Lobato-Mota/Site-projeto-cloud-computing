<?php
declare(strict_types=1);

require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/layout.php';
require __DIR__ . '/../includes/posts.php';

$posts = load_posts();
$maisRecente = $posts !== [] ? count($posts) - 1 : -1;

render_header('index', 'Home');
?>

<div class="box">
  <div class="box-titulo">&#9788; bem-vindo, viajante [teste 123]</div>
  <div class="box-corpo">
    <p>Este é o diário público da minha peregrinação por Qud: <?= count($posts) ?> entradas até agora,
    copiadas à mão para este terminal sempre que encontro um com as teclas funcionando.
    As páginas seguem em <b class="c-ouro">ordem cronológica</b> — comece do topo,
    como toda viagem começa do primeiro passo.</p>
    <p class="mini">&#9670; tinta: nanquim de tinteiro-de-cromo &nbsp;&#9670; suporte: papel de vinha prensada &nbsp;&#9670; erros de grafia: do escriba</p>
  </div>
</div>

<?php foreach ($posts as $i => $post): ?>
<article class="post" id="<?= h($post['slug']) ?>">
  <div class="post-cabecalho">
    <span class="post-data">[<?= h($post['date']) ?>]</span>
    <h2 class="post-titulo"><?= h($post['title']) ?></h2>
    <?php if ($i === $maisRecente): ?><span class="new-badge blink">NOVO!</span><?php endif; ?>
  </div>
  <div class="post-meta">
    &#9737; local: <span class="valor"><?= h($post['location']) ?></span>
    <?php if ($post['mood'] !== ''): ?> &nbsp;&#9829; humor: <span class="valor"><?= h($post['mood']) ?></span><?php endif; ?>
    <?php if ($post['listening'] !== ''): ?> &nbsp;&#9834; ouvindo: <span class="valor"><?= h($post['listening']) ?></span><?php endif; ?>
  </div>
  <div class="post-corpo">
    <?php foreach ($post['paragraphs'] as $paragrafo): ?>
    <p><?= h($paragrafo) ?></p>
    <?php endforeach; ?>
  </div>
</article>
<?php if ($i !== $maisRecente): ?>
<div class="divisor">&#9552;&#9552;&#9552;&#9552;&#9552;&#9552; &#9830; &#9552;&#9552;&#9552;&#9552;&#9552;&#9552;</div>
<?php endif; ?>
<?php endforeach; ?>

<div class="box">
  <div class="box-corpo centro">
    <p class="c-verde">&#9788; fim das entradas &#9788;</p>
    <p class="mini">a próxima página será escrita na estrada para Ezra — volte após a lua cheia de Nívvis</p>
  </div>
</div>

<?php render_footer(); ?>
