<?php
if (!$Read):
    $Read = new Read;
endif;

$Read->ExeRead(DB_POSTS, "WHERE post_name = :nm AND post_date <= :date AND post_status = :status", "nm={$URL[1]}&date=".date('Y-m-d H:i:s')."&status=1");
if (!$Read->getResult()):
    require REQUIRE_PATH . '/404.php';
    return;
else:
    extract($Read->getResult()[0]);
    $Update = new Update;
    $UpdateView = ['post_views' => $post_views + 1, 'post_lastview' => date('Y-m-d H:i:s')];
    $Update->ExeUpdate(DB_POSTS, $UpdateView, "WHERE post_id = :id", "id={$post_id}");

    $Read->ExeRead(DB_CATEGORIES, "WHERE category_id = :cat", "cat={$post_category}");
    if ($Read->getResult()):
        $Category = $Read->getResult()[0];
    endif;
endif;
?>
    <section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE; ?>/_cdn/images/bg_1.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread">Notícias</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE; ?>">Início <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="<?= BASE; ?>/artigos">Últimas Notícias <i class="ion-ios-arrow-forward"></i></a></span> </p>
                </div>
            </div>
        </div>
    </section>
<section class="ftco-section">
	<div class="container">
		<div class="row">
            <div class="col-lg-8 ftco-animate">
                <h2 class="mb-3"><?= $post_title; ?></h2>
                <?php if($post_audio): ?>
                <div id="audimaWidget"></div>
                <script src="//audio.audima.co/audima-widget.js"></script>
                <style>
                    #audimaWidget{
                     height: 70px !important;
                    }
                    div[id ~="audima-banner"] {
                      display:none !important;
                    }
                </style>
                <?php endif; ?>
                <?php
                    if($post_gallery && ($post_gallery_position == 'top')):
                ?>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
                    <div class="lightbox-gallery">
                        <div class="container">

                            <div class="row photos">
                                <?php
                                $Read->FullRead("SELECT * FROM ".DB_GALLERY." p LEFT JOIN " .DB_GALLERY_IMAGES. " s ON p.gallery_id = s.gallery_id WHERE p.gallery_id = :id", "id={$post_gallery}");
                                foreach($Read->getResult() as $Images):
                                    extract($Images);
                                ?>
                                <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="<?= BASE . "/uploads/" . $gallery_image_file;?>" data-lightbox="photos"><img class="img-fluid" src="<?= BASE . "/tim.php?src=uploads/" . $gallery_image_file."&w=200&h=200";?>"></a></div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                    <?php
                    endif;
                    ?>
                <?php
                if ($post_video):
                    echo "<div class='embed-container'>";
                    echo "<iframe id='mediaview' width='640' height='360' src='https://www.youtube.com/embed/{$post_video}?rel=0&amp;showinfo=0&autoplay=0&origin=" . BASE . "' frameborder='0' allowfullscreen></iframe>";
                    echo "</div>";
                else:
                    echo "<img class='cover' title='{$post_title}' alt='{$post_title}' src='" . BASE . "/uploads/{$post_cover}'/>";
                endif;
                ?>

                <?php
                $WC_TITLE_LINK = $post_title;
                $WC_SHARE_HASH = "ITV/UFOP";
                $WC_SHARE_LINK = BASE . "/artigo/{$post_name}";
                //require './_cdn/widgets/share/share.wc.php';
                ?>
                <!--h2 class="tagline"><?= $post_subtitle; ?></-->
                <div class="htmlchars">
                <!-- Start Audima Widget Injection -->

                    <?= $post_content; ?>
                </div>
                <?php
                    if($post_gallery && ($post_gallery_position == 'bottom')):
                    ?>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
                    <div class="lightbox-gallery">
                        <div class="container">
                            <div class="intro">
                                <h4 class="text-center"></h4>
                            </div>
                            <div class="row photos">
                                <?php
                                $Read->FullRead("SELECT * FROM ".DB_GALLERY." p LEFT JOIN " .DB_GALLERY_IMAGES. " s ON p.gallery_id = s.gallery_id WHERE p.gallery_id = :id", "id={$post_gallery}");
                                foreach($Read->getResult() as $Images):
                                    extract($Images);
                                ?>
                                <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="<?= BASE . "/uploads/" . $gallery_image_file;?>" data-lightbox="photos"><img class="img-fluid" src="<?= BASE . "/tim.php?src=uploads/" . $gallery_image_file."&w=200&h=200";?>"></a></div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                    <?php
                    endif;
                    ?>
                <?php
                require './_cdn/widgets/share/share.wc.php';


                ?>
                <div class="clear"></div>
            </div>


        <?php require REQUIRE_PATH . '/inc/sidebar.php'; ?>
        <div class="clear"></div>
    </div>
</div>

<?php if (APP_COMMENTS && COMMENT_ON_POSTS): ?>
    <div class="container" style="background: #fff; padding: 20px 0;">
        <div class="content">
            <?php
            $CommentKey = $post_id;
            $CommentType = 'post';
            require '_cdn/widgets/comments/comments.php';
            ?>
            <div class="clear"></div>
        </div>
    </div>
<?php endif; ?>