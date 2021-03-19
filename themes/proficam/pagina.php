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
                    <h2 class="mb-3"><?= $page_title; ?></h2>
                    <div class="htmlchars text-justify">
                        <?= $page_content; ?>
                    </div>

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