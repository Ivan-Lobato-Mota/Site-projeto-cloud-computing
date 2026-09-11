<?php
declare(strict_types=1);

require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/layout.php';

render_header('about', 'About Me');
?>

<div class="box">
  <div class="box-titulo">&#9787; about me — quem vos escreve</div>
  <div class="box-corpo">
    <p>Viva e beba, viajante. Meu nome é <b class="c-ouro">Yassif</b>, e se você está lendo isto
    é porque algum terminal do velho mundo ainda lembra de mim. Nasci nos pântanos de vinha-d'água
    ao redor de <b class="c-ciano">Joppa</b>, filho de fazendeiros, neto de fazendeiros, e mutante
    de primeira geração — a estirpe é sempre uma surpresa, dizem as parteiras.</p>

    <p>O acaso me escreveu com mão generosa: tenho <b class="c-verde">quatro braços</b> (dois para
    o trabalho, dois para o mundo), uma <b class="c-verde">pele verde que bebe o sol</b> e faz dele
    almoço, e uma tendência a <b class="c-verde">cochilar em qualquer sombra</b> — a narcolepsia é a
    cobrança da fotossíntese, e explica os intervalos entre as páginas deste diário. Escrevo com os
    braços de cima e seguro o tinteiro com os de baixo. Nenhum escriba de Qud tem melhor ergonomia.</p>

    <p>Fui fazendeiro até o dia em que desenterrei do pântano uma pistola a laser morta, e ela me
    olhou de volta. Naquela noite sonhei com uma agulha costurando o céu à terra, e acordei sabendo
    que meus pés tinham um contrato que minha cabeça ainda não tinha lido. Arrumei a trouxa,
    recebi a bênção do ancião Irudad, e parti — <b class="c-ciano">de Joppa, para o norte, e depois
    para o branco sem fim do Grande Deserto de Sal, o Moghra'yi</b>.</p>

    <p>Atravessei o sal contando dracmas e aprendendo suas leis: caminhar de madrugada, dormir no
    meio-dia, repartir a água com estranhos — porque no deserto todo estranho é um espelho. Reparti a
    minha com uma eremita issachari sob as duas luas e ganhei em troca um oásis e uma lição.
    Cheguei enfim ao <b class="c-ciano">Six Day Stilt</b>, a catedral que anda sobre pernas de cromo,
    onde doei minha pistola ao Poço Sagrado e ouvi os mecanimistas pregarem a paz entre a carne e o
    metal. Ainda não sei no que acredito. Sei que fiquei mais leve.</p>

    <p>Agora encho os odres e confiro o mapa três vezes: os próximos passos vão para o leste,
    cruzando o braço fundo do deserto até a aldeia de <b class="c-ciano">Ezra</b>, empoleirada nos
    penhascos, e dali ao <b class="c-ciano">Condado de Omonporch</b> — onde o <b class="c-ouro">Fuso</b>
    fura as nuvens como um fio de prata esticado por alguém que nunca conheceremos. Dizem que há
    visitantes de armadura branca no condado, e que o Conde anda estranho. Vou assim mesmo.
    Peregrino que só anda em estrada segura é turista.</p>

    <p>Este site é meu caderno de viagem: as <a href="index.php">entradas do diário</a> em ordem
    cronológica, um <a href="wisdom.php">oráculo de sal</a> que recombina os aforismos que coleciono
    na estrada, e o <a href="chef.php">canto do cozinheiro</a> para as receitas de fogueira.
    Leia, copie, discorde — papel de vinha aceita tudo.</p>

    <p class="c-verde">Que tua lâmina fique afiada e tua água fresca. Viva e beba. &#9670; Yassif</p>
  </div>
</div>

<div class="box">
  <div class="box-titulo">&#9760; ficha de personagem</div>
  <div class="box-corpo">
    <table class="ficha">
      <tr><th colspan="2">Yassif de Joppa &mdash; n&iacute;vel 9</th></tr>
      <tr><td>Genótipo</td><td><b>Mutante</b></td></tr>
      <tr><td>Vocação</td><td><b>Fazendeiro de vinha-d'água (aposentado) / Peregrino</b></td></tr>
      <tr><td>Força</td><td><b>16</b></td></tr>
      <tr><td>Agilidade</td><td><b>15</b></td></tr>
      <tr><td>Vigor</td><td><b>18</b></td></tr>
      <tr><td>Inteligência</td><td><b>17</b></td></tr>
      <tr><td>Vontade</td><td><b>19</b></td></tr>
      <tr><td>Ego</td><td><b>14</b></td></tr>
      <tr><td>Mutações</td><td><b>Braços Múltiplos (4), Pele Fotossintética</b></td></tr>
      <tr><td>Defeito</td><td><b>Narcolepsia</b> <span class="mini">(o deserto me nina)</span></td></tr>
      <tr><td>Reputação</td><td><span class="c-verde">+300 mecanimistas</span>, <span class="c-verde">+200 issachari</span>, <span class="c-rosa">&minus;600 snapjaws de Red Rock</span></td></tr>
    </table>
    <p class="mini centro">ficha auditada pelas guardiãs Esther &mdash; valores sujeitos a mutação sem aviso prévio</p>
  </div>
</div>

<?php render_footer(); ?>
