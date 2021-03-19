
<style>
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        content: "e072"; /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
    .card-block {
        padding: 25px;
    }
</style>
<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE;?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Perguntas Frequentes</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE;?>">Início <i class="ion-ios-arrow-forward"></i></a></span> <span>Perguntas Frequentes <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>
<section class="ftco-section bg-light py-5">
<div class="container">
    <div class="row">
        <div class="col col-lg-8 ftco-animate">
            <div class ="row">

                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    Nesta página você encontrará as principais perguntas relacionadas ao nosso programa. Caso você não encontre resposta para sua dúvida,
                    entre em <strong><a href="<?=BASE.'/fale-conosco';?>">contato</a></strong> conosco.
                </div>

                <div class="" id="accordion">
                    <?php
                    $Read->ExeRead(DB_FAQ_CATEGORY, "WHERE faq_category_status = :status ORDER BY faq_category_id ASC ", "status=1");
                    if (!$Read->getResult()):
                        echo Erro("Ainda não existe pergunta cadastrada. Favor volte mais tarde :)", E_USER_NOTICE);
                    else:

                    foreach ($Read->getResult() as $FaqCategory):
                    extract($FaqCategory);
                    ?>
                    <div class="faqHeader"><?= $faq_category_name; ?></div>
                    <?php
                    $Read->ExeRead(DB_FAQ, "WHERE faq_category = :category AND faq_status = :status ORDER BY faq_question ASC ", "category=".$faq_category_id."&status=1");
                    if (!$Read->getResult()):
                        echo Erro("Ainda não existe pergunta cadastrada nessa categoria. Favor volte mais tarde :)", E_USER_NOTICE);
                    else:

                    foreach ($Read->getResult() as $Faq):
                    extract($Faq);
                    ?>

                    <div class="card">
                        <a class="accordion-toggle <?=($faq_id == 1 ? "" : "collapsed");?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$faq_id;?>">
                        <div class="card-header">
                            <h6 class="card-header">
                                <?=$faq_question;?>
                            </h6>
                        </div>
                        </a>
                        <div id="collapse<?=$faq_id?>" class="panel-collapse <?=($faq_id == 1 ? "collapse in" : "collapse");?>">
                            <div class="card-block text-justify">
                                <?=$faq_answer;?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; endif;?>
                    <?php endforeach; endif;?>
                </div>

            </div>

        </div>

        <?php require REQUIRE_PATH . '/inc/sidebar_pag.php'; ?>
        <div class="clear"></div>
    </div>
</div>
</section>