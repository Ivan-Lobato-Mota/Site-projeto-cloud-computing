<?php
declare(strict_types=1);

/*
 * Layout compartilhado: cabeçalho (até a abertura de <main>) e
 * rodapé (sidebar + footer), no melhor espírito PHP de 2004.
 */

function render_header(string $ativo, string $tituloPagina = ''): void
{
    $titulo = $tituloPagina === ''
        ? SITE_NAME
        : $tituloPagina . ' ~*~ ' . SITE_NAME;

    $abas = [
        'index'  => ['index.php',  'Home'],
        'about'  => ['about.php',  'About Me'],
        'wisdom' => ['wisdom.php', "Salt's Wisdom"],
        'chef'   => ['chef.php',   "Carbide Chef's Corner"],
    ];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Diário de viagem de um peregrino mutante atravessando Qud: de Joppa ao Six Day Stilt, rumo a Ezra e Omonporch.">
<title><?= h($titulo) ?></title>
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'><rect width='16' height='16' fill='%230f3b3a'/><text x='8' y='12.5' font-size='12' font-family='monospace' text-anchor='middle' fill='%23e99f10'>@</text></svg>">
<link rel="stylesheet" href="colors.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrap">

<div class="topbar">
  <marquee scrollamount="3">&#9788;&nbsp; Viva e beba, viajante! &nbsp;&#9788;&nbsp; Você sintonizou <b>SAL &amp; CROMO</b>, o diário de um peregrino mutante em Qud &nbsp;&#9788;&nbsp; Atualizado sempre que encontro um terminal funcional &nbsp;&#9788;&nbsp; Melhor visualizado em 800&times;600 &nbsp;&#9788;</marquee>
</div>

<header class="masthead">
  <div class="masthead-glyph">@</div>
  <div>
    <h1 class="site-title"><?= h(SITE_NAME) ?></h1>
    <p class="site-tagline"><?= h(SITE_TAGLINE) ?></p>
  </div>
</header>

<nav class="navbar">
<?php foreach ($abas as $chave => [$href, $rotulo]): ?>
  <a href="<?= h($href) ?>" class="<?= $chave === $ativo ? 'ativo' : '' ?>"><?= h($rotulo) ?></a>
<?php endforeach; ?>
</nav>

<div class="cols">
<main class="conteudo">
<?php
}

function render_footer(): void
{
    $visitas = bump_counter();
?>
</main>

<aside class="sidebar">

  <div class="box">
    <div class="box-titulo">quem escreve</div>
    <div class="box-corpo">
      <pre class="retrato" aria-label="retrato ASCII do peregrino">
  <span class="c-verde">\ | /</span>
  <span class="c-cinza">--</span><span class="c-ouro">(@)</span><span class="c-cinza">--</span>
  <span class="c-ciano">/#|#\</span>
 <span class="c-ciano">//</span> <span class="c-cinza">|</span> <span class="c-ciano">\\</span>
   <span class="c-cinza">/ \</span></pre>
      <p class="retrato-legenda">retrato a carvão feito por<br>um pintor de Joppa (2 dracmas)</p>
      <p><b class="c-ouro">Yassif</b>, mutante de quatro braços, pele que bebe o sol. Peregrino a caminho do Fuso.</p>
      <p><a href="about.php">&raquo; ficha completa</a></p>
    </div>
  </div>

  <div class="box">
    <div class="box-titulo">navegação lateral</div>
    <div class="box-corpo">
      <ul class="lista-links">
        <li>&#9830; <a href="index.php">diário de viagem</a></li>
        <li>&#9830; <a href="wisdom.php">consultar o sal</a></li>
        <li>&#9830; <a href="chef.php">receita do dia</a></li>
        <li>&#9830; <span class="construcao" title="em construção desde o ano 992 dos sultões">livro de visitas</span> <span class="blink c-laranja">[EM OBRAS]</span></li>
      </ul>
    </div>
  </div>

  <div class="box">
    <div class="box-titulo">status do peregrino</div>
    <div class="box-corpo">
      <p>&#9788; humor: <span class="c-verde">esperançoso</span><br>
      &#9834; ouvindo: <span class="c-ciano">hinos mecanimistas</span><br>
      &#9760; HP: <span class="c-verde">47/52</span><br>
      &#9670; dracmas de água: <span class="c-azul">31</span></p>
    </div>
  </div>

  <div class="box">
    <div class="box-titulo">links de estrada</div>
    <div class="box-corpo">
      <ul class="lista-links">
        <li>&#9656; <a href="https://wiki.cavesofqud.com" rel="external">Wiki oficial de Qud</a></li>
        <li>&#9656; <a href="https://www.cavesofqud.com" rel="external">Caves of Qud</a></li>
        <li>&#9656; <a href="https://freeholdgames.com" rel="external">Freehold Games</a></li>
      </ul>
    </div>
  </div>

<?php if ($visitas > 0): ?>
  <div class="box">
    <div class="box-titulo">peregrinos que passaram</div>
    <div class="box-corpo centro">
      <span class="contador"><?php
        foreach (str_split(str_pad((string) $visitas, 6, '0', STR_PAD_LEFT)) as $digito) {
            echo '<span>' . $digito . '</span>';
        }
      ?></span>
      <p class="mini">desde o ano 1000 dos sultões</p>
    </div>
  </div>
<?php endif; ?>

  <div class="badges">
    <span class="badge b1">VIVA &amp;<br>BEBA</span>
    <span class="badge b2">PHP<br>powered</span>
    <span class="badge b3">800&times;600<br>4ever</span>
    <span class="badge b4">QUD<br>NOW!</span>
  </div>

</aside>
</div><!-- /cols -->

<footer class="rodape">
  <div class="webring">
    <span class="webring-nome">~ Anel de Peregrinos WebRing ~</span><br>
    <a href="https://wiki.cavesofqud.com/wiki/Joppa" rel="external">&laquo; anterior</a> &nbsp;&#9670;&nbsp;
    <a href="https://wiki.cavesofqud.com/wiki/Special:Random" rel="external">aleatório</a> &nbsp;&#9670;&nbsp;
    <a href="https://wiki.cavesofqud.com/wiki/Six_Day_Stilt" rel="external">próximo &raquo;</a>
  </div>
  <p>&copy; 1000 dos sultões &mdash; <?= h(SITE_AUTHOR) ?>. Escrito à mão com quatro mãos.<br>
  Melhor visualizado em 800&times;600, num terminal VGA aquecido ao sol do deserto.<br>
  Última atualização: <?= h(LAST_UPDATE) ?> &nbsp;&#9670;&nbsp; hospedado na nuvem (a única chuva que temos por aqui).</p>
  <p class="mini">Fã-site sem afiliação com a Freehold Games. Caves of Qud &eacute; da Freehold Games, LLC.<br>Paleta de cores da wiki oficial. Viva e beba.</p>
</footer>

</div><!-- /wrap -->
</body>
</html>
<?php
}
