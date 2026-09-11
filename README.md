# Sal & Cromo — Site do projeto de Cloud Computing

Blog pessoal estilo anos 2000, escrito em PHP puro (sem framework nem banco de dados),
ambientado no mundo de [Caves of Qud](https://www.cavesofqud.com): o diário de viagem de
**Yassif**, um peregrino mutante indo de Joppa, pelo Grande Deserto de Sal, até o
Six Day Stilt — e dali rumo a Ezra e Omonporch.

## Páginas

| Página | Arquivo | Descrição |
| --- | --- | --- |
| Home | `public/index.php` | Entradas do diário em ordem cronológica (flat-file, sem banco) |
| About Me | `public/about.php` | Apresentação em primeira pessoa + ficha de personagem |
| Salt's Wisdom | `public/wisdom.php` | Gerador de "livros" por cadeia de Markov (ordem 2), como os tomos do jogo |
| Carbide Chef's Corner | `public/chef.php` | Receitas aleatórias com ingredientes e efeitos da wiki oficial |

Salt's Wisdom e o Carbide Chef usam uma **semente numérica** na URL
(`wisdom.php?fragmento=N`, `chef.php?receita=N`), então todo texto/receita gerado tem
link permanente e reproduzível.

## Estética

- Paleta de cores do terminal do jogo, conforme a wiki oficial: `public/colors.css`
- Título em **ITC Serif Gothic Heavy** (a fonte do logo do jogo)
- Corpo em **WebPlus IBM EGA 9×14** (fonte de terminal, tamanho nativo 14px)
- Marquee, contador de visitas, badges 88×31, webring, scanlines de CRT — como manda 2004

## Como rodar localmente

Requer apenas PHP >= 8.0 (testado em 8.5):

```sh
php -S localhost:8000 -t public
```

e abra <http://localhost:8000>.

Em produção (Apache/nginx + PHP-FPM), aponte o *document root* para `public/`.
O contador de visitas escreve em `data/counter.txt`; se o diretório não for gravável,
o contador simplesmente não aparece (o resto do site não depende de escrita).

## Estrutura

```
public/     docroot: páginas, CSS e fontes (.woff)
includes/   config, layout compartilhado, loader de posts, Markov, receitas
data/
  posts/    uma entrada do diário por arquivo .txt (front matter simples + parágrafos)
  corpus.txt  corpus de aforismos que treina a cadeia de Markov
```

Para publicar uma nova entrada no diário, basta criar um `data/posts/aaaa-mm-dd-slug.txt`:

```
title: Título da entrada
date: 2026-09-12
location: Ezra
mood: aliviado
listening: o vento nos penhascos
---
Parágrafos do texto, separados por linha em branco.
```

---

Fã-site sem afiliação com a Freehold Games. Caves of Qud © Freehold Games, LLC.
Dados de culinária extraídos da [wiki oficial](https://wiki.cavesofqud.com/wiki/Cooking). Viva e beba.
