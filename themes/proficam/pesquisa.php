<?php
$Search = urldecode($URL[1]);
$SearchPage = urlencode($Search);

if (empty($_SESSION['search']) || !in_array($Search, $_SESSION['search'])):
    $Read->FullRead("SELECT search_id, search_count FROM " . DB_SEARCH . " WHERE search_key = :key", "key={$Search}");
    if ($Read->getResult()):
        $Update = new Update;
        $DataSearch = ['search_count' => $Read->getResult()[0]['search_count'] + 1];
        $Update->ExeUpdate(DB_SEARCH, $DataSearch, "WHERE search_id = :id", "id={$Read->getResult()[0]['search_id']}");
    else:
        $Create = new Create;
        $DataSearch = ['search_key' => $Search, 'search_count' => 1, 'search_date' => date('Y-m-d H:i:s'), 'search_commit' => date('Y-m-d H:i:s')];
        $Create->ExeCreate(DB_SEARCH, $DataSearch);
    endif;
    $_SESSION['search'][] = $Search;
endif;
?>
<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE; ?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Pesquisa</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE; ?>">Início <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="<?= BASE; ?>/artigos">Notícias <i class="ion-ios-arrow-forward"></i></a></span> </p>
            </div>
        </div>
    </div>
</section>
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ftco-animate">
            <?php
            $Page = (!empty($URL[2]) ? $URL[2] : 1);
            $Pager = new Pager(BASE . "/pesquisa/{$SearchPage}/", "<<", ">>", 5);
            $Pager->ExePager($Page, 5);
            $Read->ExeRead(DB_POSTS, "WHERE post_status = 1 AND post_date <= NOW() AND (post_title LIKE '%' :s '%' OR post_subtitle LIKE '%' :s '%') ORDER BY post_date DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}&s={$Search}");
            if (!$Read->getResult()):
                $Pager->ReturnPage();
                echo Erro("Desculpe, mas sua pesquisa para <b>{$Search}</b> não retornou resultados. Talvez você queira utilizar outros termos! Você ainda pode usar nosso menu de navegação para encontrar o que procura!", E_USER_NOTICE);
            else:
                foreach ($Read->getResult() as $Post):
                    extract($Post);
                    ?>
                    <article class="main_blog_post">
                        <a title="Ler mais sobre <?= $post_title; ?>" href="<?= BASE; ?>/artigo/<?= $post_name; ?>">
                            <img title="<?= $post_title; ?>" alt="<?= $post_title; ?>" src="<?= BASE; ?>/uploads/<?= $post_cover; ?>"/>
                        </a>
                        <header>
                            <h1><a title="Ler mais sobre <?= $post_title; ?>" href="<?= BASE; ?>/artigo/<?= $post_name; ?>"><?= $post_title; ?></a></h1>
                            <p class="tagline"><?= $post_subtitle; ?></p>
                        </header>
                    </article>
                    <?php
                endforeach;
            endif;

            $Pager->ExePaginator(DB_POSTS, "WHERE post_status = 1 AND post_date <= NOW() AND (post_title LIKE '%' :s '%' OR post_subtitle LIKE '%' :s '%')", "s={$Search}");
            echo $Pager->getPaginator();
            ?>
        </div>

        <?php require REQUIRE_PATH . '/inc/sidebar.php'; ?>
        <div class="clear"></div>
    </div>
</div>
</section>