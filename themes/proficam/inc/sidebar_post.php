<div class="col-lg-4 sidebar ftco-animate">
    <div class="sidebar-box main-sidebar">
        <form class="search-form" name="search" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <span class="icon icon-search"></span>
                <input type="text" name="s" class="form-control" placeholder="Pesquisar..."/>
            </div>
        </form>
    </div>
    <div class="sidebar-box ftco-animate">
        <h3>Categorias</h3>
        <ul class="categories">
            <?php

            $Read->ExeRead(DB_CATEGORIES);
            if (!$Read->getResult()):
                echo Erro("Ainda não existe posts cadastrados. Por favor, volte mais tarde :)", E_USER_NOTICE);
            else:
            foreach ($Read->getResult() as $Cat):

            ?>
            <li><a href="<?= BASE;?>/artigos/<?=$Cat['category_name'];?>"><?=$Cat['category_title'];?></a></li>
            <?php endforeach; endif;?>
        </ul>
    </div>

    <div class="sidebar-box ftco-animate">
        <h3>Últimas Notícias</h3>
        <?php
        $Read->ExeRead(DB_POSTS, "WHERE post_status = 1 AND post_date <= NOW() ORDER BY post_views DESC, post_date DESC LIMIT 5");
        if (!$Read->getResult()):
            echo Erro("Ainda não existe posts cadastrados. Por favor, volte mais tarde :)", E_USER_NOTICE);
        else:
            foreach ($Read->getResult() as $Post):
                ?>
                <div class="block-21 mb-4 d-flex">
                    <a class="blog-img mr-4" style="background-image: url(<?= BASE; ?>/tim.php?src=uploads/<?= $Post['post_cover']; ?>&w=<?= IMAGE_W / 2; ?>&h=<?= IMAGE_H / 2; ?>);"></a>
                    <div class="text">
                        <h3 class="heading"><a title="Ler mais sobre <?= $Post['post_title']; ?>" href="<?= BASE; ?>/artigo/<?= $Post['post_name']; ?>"><?= $Post['post_title']; ?></a></h3>
                    </div>
                </div>
            <?php endforeach; endif; ?>
    </div>



</div><!-- END COL -->
