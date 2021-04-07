
<footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="ftco-footer-widget mb-5">
                    <h2 class="ftco-heading-2">Onde Estamos</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li><span class="icon icon-map-marker"></span><span class="text"><?= SITE_ADDR_ADDR; ?></span>
                            </li>
                            <li><a href="#"><span class="icon icon-phone"></span><span
                                    class="text"><?= SITE_ADDR_PHONE_A; ?></span></a></li>
                            <li><a href="#"><span class="icon icon-envelope"></span><span class="text"><?= SITE_ADDR_EMAIL; ?></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="ftco-footer-widget mb-5">
                    <h2 class="ftco-heading-2">Última Notícia</h2>
                    <?php

                    $Read->ExeRead(DB_POSTS, "WHERE post_category <> :category AND post_status = :status AND post_date <= :date ORDER BY post_date DESC LIMIT :limit", "category=4&status=1&date=".date('Y-m-d H:i:s')."&limit=1}");
                    if (!$Read->getResult()):
                        $Pager->ReturnPage();
                        echo Erro("Ainda Não existe posts cadastrados. Favor volte mais tarde :)", E_USER_NOTICE);
                    else:

                    foreach ($Read->getResult() as $Post):
                    extract($Post);

                    ?>
                    <div class="block-21 mb-4 d-flex">
                        <a  href="<?= BASE; ?>/artigo/<?= $post_name; ?>" class="blog-img mr-4"><img src="<?= BASE; ?>/uploads/<?= $post_cover; ?>" alt="<?=$post_title;?>"/></a>
                        <div class="text">
                            <h3 class="heading"><a href="<?= BASE; ?>/artigo/<?= $post_name; ?>"><?= $post_title; ?></a></h3>
                            <div class="meta">
                                <?php
                                setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                date_default_timezone_set('America/Sao_Paulo');
                                $dia = utf8_encode(strftime(' %d', strtotime($post_date)));
                                $mes = utf8_encode(strftime(' %B', strtotime($post_date)));
                                $ano = utf8_encode(strftime(' %Y', strtotime($post_date)));
                                ?>
                                <div><a href="#"><span class="icon-calendar"></span><?= $dia .' de '. $mes . ' de ' . $ano?></a></div>

                            </div>
                        </div>
                    </div>
                    <?php
                    endforeach;  endif;?>

                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="ftco-footer-widget mb-5 ml-md-4">
                    <h2 class="ftco-heading-2">Importantes</h2>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE ;?>"><span class="ion-ios-arrow-round-forward mr-2"></span>Início</a></li>
                        <li><a href="<?= BASE ;?>/historico"><span class="ion-ios-arrow-round-forward mr-2"></span>Histórico</a></li>
                        <li><a href="<?= BASE ;?>/corpo-docente"><span class="ion-ios-arrow-round-forward mr-2"></span>Corpo Docente</a></li>
                        <li><a href="<?= BASE ;?>/normas-e-procedimentos"><span class="ion-ios-arrow-round-forward mr-2"></span>Normas e Procedimentos</a></li>
                        <li><a target="_blank" rel="noopener" href="https://www.repositorio.ufop.br/handle/123456789/10028"><span class="ion-ios-arrow-round-forward mr-2"></span>Repositório de Dissertações</a></li>
                        <li><a href="<?= BASE ;?>/defesas"><span class="ion-ios-arrow-round-forward mr-2"></span>Próximas Defesas</a></li>
                        <li><a href="<?= BASE ;?>/artigos"><span class="ion-ios-arrow-round-forward mr-2"></span>Notícias</a></li>
                        <li><a href="<?= BASE ;?>/fale-conosco"><span class="ion-ios-arrow-round-forward mr-2"></span>Fale Conosco</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="ftco-footer-widget mb-5">
                    <h2 class="ftco-heading-2">Receba as novidades!</h2>
                    <form action="#" class="subscribe-form">
                        <div class="form-group">
                            <input class="form-control mb-2 text-center" placeholder="Digite seu e-mail" type="text">
                            <input class="form-control submit px-3" type="submit" value="Cadastre-se">
                        </div>
                    </form>
                </div>
            </div>
            <!--div class="col-md-6 col-lg-3">
                <div class="ftco-footer-widget mb-5 ml-md-4">
                    <h2 class="ftco-heading-2 mb-0">Redes Socias</h2>
                    <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                        <li class="ftco-animate"><a href="<?=SITE_SOCIAL_YOUTUBE;?>"><span class="icon-youtube"></span></a></li>
                        <li class="ftco-animate"><a href="<?= SITE_SOCIAL_FB;?>"><span class="icon-facebook"></span></a></li>
                        <li class="ftco-animate"><a href="<?=SITE_SOCIAL_INSTAGRAM;?>"><span class="icon-instagram"></span></a></li>
                    </ul>
                </div>
            </div-->
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <p>
                    Copyright &copy;<?=date('Y')?>
                    Todos direitos reservados | <?= SITE_NAME; ?> | UFOP / ITV
                </p>
            </div>
        </div>
    </div>
</footer>


<!-- loader -->
<div class="show fullscreen" id="ftco-loader">
    <svg class="circular" height="48px" width="48px">
        <circle class="path-bg" cx="24" cy="24" fill="none" r="22" stroke="#eeeeee" stroke-width="4"/>
        <circle class="path" cx="24" cy="24" fill="none" r="22" stroke="#F96D00" stroke-miterlimit="10"
                stroke-width="4"/>
    </svg>
</div>
<script src="<?= BASE; ?>/_cdn/js/jquery-migrate-3.0.1.min.js"></script>
<script src="<?= BASE; ?>/_cdn/js/popper.min.js"></script>
<script src="<?= BASE; ?>/_cdn/js/bootstrap.min.js"></script>
<script src="<?= BASE; ?>/_cdn/js/jquery.easing.1.3.js"></script>
<script src="<?= BASE; ?>/_cdn/js/jquery.waypoints.min.js"></script>
<script src="<?= BASE; ?>/_cdn/js/jquery.stellar.min.js"></script>
<script src="<?= BASE; ?>/_cdn/js/owl.carousel.min.js"></script>
<script src="<?= BASE; ?>/_cdn/js/jquery.magnific-popup.min.js"></script>
<script src="<?= BASE; ?>/_cdn/js/aos.js"></script>
<script src="<?= BASE; ?>/_cdn/js/jquery.animateNumber.min.js"></script>
<script src="<?= BASE; ?>/_cdn/js/scrollax.min.js"></script>
<!--script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="<?= BASE; ?>/_cdn/js/google-map.js"></script-->
<script src="<?= BASE; ?>/_cdn/js/main.js"></script>

<!-- O Javascript deve vir depois -->

<script>
    var comboGoogleTradutor = null; //Varialvel global

    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'pt',
            includedLanguages: 'es,en,pt',
            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
        }, 'google_translate_element');

        comboGoogleTradutor = document.getElementById("google_translate_element").querySelector(".goog-te-combo");
    }

    function changeEvent(el) {
        if (el.fireEvent) {
            el.fireEvent('onchange');
            document.querySelector("body").style.top ="0px";
        } else {
            var evObj = document.createEvent("HTMLEvents");

            evObj.initEvent("change", false, true);
            el.dispatchEvent(evObj);
            document.querySelector("body").style.top ="0px";
        }
    }

    function trocarIdioma(sigla) {
        if (comboGoogleTradutor) {
            comboGoogleTradutor.value = sigla;
            changeEvent(comboGoogleTradutor);//Dispara a troca
            document.querySelector("body").style.top ="0px";

        }

    }
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

