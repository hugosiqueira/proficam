<?php
if (!$Read):
    $Read = new Read;
endif;
if($URL[1]):
    $Read->ExeRead(DB_CATEGORIES, "WHERE category_name = :nm", "nm={$URL[1]}");
else:
    $Read->ExeRead(DB_CATEGORIES);
endif;
    if (!$Read->getResult()):
        require REQUIRE_PATH . '/404.php';
        return;
    else:
        extract($Read->getResult()[0]);
    endif;

?>
<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE; ?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Notícias</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE;?>>">Início <i class="ion-ios-arrow-forward"></i></a></span> <span>Notícias <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">

            <?php
            $Page = (!empty($URL[2]) ? $URL[2] : 1);
            $Pager = new Pager(BASE . "/artigos/{$category_name}/", "<<", ">>", 5);
            $Pager->ExePager($Page, 5);
            $Read->ExeRead(DB_POSTS, "WHERE post_status = :status AND post_date <= :date AND (post_category = :ct OR FIND_IN_SET(:ct, post_category_parent)) ORDER BY post_date DESC LIMIT :limit OFFSET :offset", "status=1&date=".date('Y-m-d H:i:s')."&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}&ct={$category_id}");
            if (!$Read->getResult()):
                $Pager->ReturnPage();
                echo Erro("Ainda não existe posts cadastrados. Por favor, volte mais tarde :)", E_USER_NOTICE);
            else:
                foreach ($Read->getResult() as $Post):
                    extract($Post);
                    ?>
                    <div class="col-md-6 col-lg-4 ftco-animate">
                <div class="blog-entry">

                       <?php if(!empty($post_cover)): ?>
                            <a title="Ler mais sobre <?= $post_title; ?>" href="<?= BASE; ?>/artigo/<?= $post_name; ?>" class="block-20 d-flex align-items-end" style="background-image: url('<?= BASE; ?>/uploads/<?= $post_cover; ?>');">
                                <?php else: ?>
                            <a title="Ler mais sobre <?= $post_title; ?>" href="<?= BASE; ?>/artigo/<?= $post_name; ?>" class="block-20 d-flex align-items-end" style="background-image: url('<?= BASE; ?>/uploads/<?= $post_cover; ?>');">
                            <?php endif; ?>
                                <div class="meta-date text-center p-2">
                                    <?php
                                    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                    date_default_timezone_set('America/Sao_Paulo');
                                    $dia = utf8_encode(strftime(' %d', strtotime($post_date)));
                                    $mes = utf8_encode(strftime(' %B', strtotime($post_date)));
                                    $ano = utf8_encode(strftime(' %Y', strtotime($post_date)));
                                    ?>
                                    <span class="day"><?= $dia;?></span>
                                    <span class="mos"><?= $mes;?></span>
                                    <span class="yr"><?= $ano;?></span>
                                </div>
                            </a>
                                <div class="text bg-white p-4">
                                    <h3 class="heading"><a title="Ler mais sobre <?= $post_title; ?>" href="<?= BASE; ?>/artigo/<?= $post_name; ?>"><?= $post_title; ?></a></h3>
                                    <p><?= $post_subtitle;?></p>
                                    <div class="d-flex align-items-center mt-4">
                                        <p class="mb-0"><a title="Ler mais sobre <?= $post_title; ?>" href="<?= BASE; ?>/artigo/<?= $post_name; ?>" class="btn btn-primary">Saiba Mais <span class="ion-ios-arrow-round-forward"></span></a></p>
                                        <p class="ml-auto mb-0">
                                            <a href="#" class="mr-2"><?= $post_author; ?></a>
                                            <!--a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a-->
                                        </p>
                                    </div>
                                </div>
                </div>
            </div>

                    <?php
                endforeach;
            endif;

            $Pager->ExePaginator(DB_POSTS, "WHERE post_status = :status AND post_date <= :date AND (post_category = :ct OR FIND_IN_SET(:ct, post_category_parent))", "status=1&date=".date('Y-m-d H:i:s')."&ct={$category_id}");
            echo $Pager->getPaginator();
            ?>
        </div>

       <!-- insira se necessário a sidebar aqui -->
        <div class="clear"></div>
    </div>
</div>