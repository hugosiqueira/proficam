<?php
if (!$Read):
    $Read = new Read;
endif;

$Email = new Email;

$Read->ExeRead(DB_PAGES, "WHERE page_name = :nm", "nm={$URL[0]}");
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
                    <h1 class="mb-2 bread"><?= $page_title; ?></h1>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section">
        <div class="container">
			<div class="row">
                <div class="col-lg-8 ftco-animate">
                    <h2 class="mb-2"><?= $page_title; ?></h2>

                    <div class="htmlchars text-justify">
                        <?php if($page_audio): ?>
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
                        if($page_gallery && ($page_gallery_position == 'top')):
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
                                        $Read->FullRead("SELECT * FROM ".DB_GALLERY." p LEFT JOIN " .DB_GALLERY_IMAGES. " s ON p.gallery_id = s.gallery_id WHERE p.gallery_id = :id", "id={$page_gallery}");
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

                        <?= $page_content; ?>
                    </div>
                    <?php
                    if($page_gallery && ($page_gallery_position == 'bottom')):
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
                                    $Read->FullRead("SELECT * FROM ".DB_GALLERY." p LEFT JOIN " .DB_GALLERY_IMAGES. " s ON p.gallery_id = s.gallery_id WHERE p.gallery_id = :id", "id={$page_gallery}");
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


                    <div class="clear"></div>
                </div>
                <?php require REQUIRE_PATH . '/inc/sidebar_pag.php'; ?>
                <div class="clear"></div>
            </div>
        </div>
    </section>
<?php if (APP_COMMENTS && COMMENT_ON_PAGES): ?>
    <div class="container" style="background: #fff; padding: 20px 0;">
        <div class="content">
            <?php
            $CommentKey = $page_id;
            $CommentType = 'page';
            require '_cdn/widgets/comments/comments.php';
            ?>
            <div class="clear"></div>
        </div>
    </div>
<?php endif; ?>