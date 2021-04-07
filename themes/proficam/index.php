<?php
echo "<link rel='stylesheet' href='" . BASE . "/_cdn/widgets/contact/contact.wc.css'/>";
echo "<script src='" . BASE . "/_cdn/widgets/contact/contact.wc.js'></script>";
if (APP_SLIDE):
    $SlideSeconts = 3;
    require '_cdn/widgets/slide/slide.wc.php';

endif;
?>
<section class="ftco-services ftco-no-pb">
    <div class="container-wrap">
        <div class="row no-gutters">
            <div class="col-md-3 d-flex services align-self-stretch py-5 px-4 ftco-animate bg-primary">
                <div class="media block-6 d-block text-center">
                    <div class="icon d-flex justify-content-center align-items-center">
                        <span class="flaticon-teacher"></span>
                    </div>
                    <div class="media-body p-2 mt-3">
                        <a href="corpo-docente">
                            <h3 class="heading">Corpo Docente</h3>
                            <p class="text-light">Nosso programa conta com professores qualificados para te orientar com um
                                conteúdo atualizado.</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex services align-self-stretch py-5 px-4 ftco-animate bg-darken">
                <div class="media block-6 d-block text-center">
                    <div class="icon d-flex justify-content-center align-items-center">
                        <span class="flaticon-jigsaw"></span>
                    </div>
                    <div class="media-body p-2 mt-3">
                        <a href="integracao-com-a-industria">
                            <h3 class="heading">Integração com a Indústria</h3>
                            <p class="text-light">Nossos alunos saem preparados para atuar diretamente na indústria,
                                veja alguns cases.</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex services align-self-stretch py-5 px-4 ftco-animate bg-primary">
                <div class="media block-6 d-block text-center">
                    <div class="icon d-flex justify-content-center align-items-center">
                        <span class="flaticon-diploma"></span>
                    </div>
                    <div class="media-body p-2 mt-3">
                        <a target="_blank" rel="noopener" href="https://www.repositorio.ufop.br/handle/123456789/10028">
                            <h3 class="heading">Dissertações</h3>
                            <p class="text-light">Veja todas dissertações que já foram apresentadas em nosso programa.
                            </p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex services align-self-stretch py-5 px-4 ftco-animate bg-darken">
                <div class="media block-6 d-block text-center">
                    <div class="icon d-flex justify-content-center align-items-center">
                        <span class="flaticon-security"></span>
                    </div>
                    <div class="media-body p-2 mt-3">
                        <a href="laboratorios">
                            <h3 class="heading">Infraestrutura</h3>
                            <p class="text-light">Nossos laboratórios contam com as mais novas tecnologias existentes e
                                nossa biblioteca com todo material necessário para sua pesquisa.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <h2 class="mb-4"><span>Últimas</span> Notícias</h2>
                <p>Saiba as últimas novidades sobre nosso programa</p>
            </div>
        </div>
        <div class="row">
            <?php
            $Page = (!empty($URL[1]) ? $URL[1] : 1);
            $Pager = new Pager(BASE . "/index/", "<<", ">>", 5);
            $Pager->ExePager($Page, 3);
            $Read->ExeRead(DB_POSTS, "WHERE post_category <> :category AND post_status = :status AND post_date <= :date ORDER BY post_date DESC LIMIT :limit OFFSET :offset", "category=4&status=1&date=".date('Y-m-d H:i:s')."&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
            if (!$Read->getResult()):
                $Pager->ReturnPage();
                echo Erro("Ainda Não existe posts cadastrados. Favor volte mais tarde :)", E_USER_NOTICE);
            else:

                foreach ($Read->getResult() as $Post):
                    extract($Post);

                    ?>
                    <div class="col-md-6 col-lg-4 ftco-animate">
                        <div class="blog-entry">
                            <a class="block-20 d-flex align-items-end img" href="<?= BASE; ?>/artigo/<?= $post_name; ?>"
                               style="background-image: url('<?= BASE; ?>/uploads/<?= $post_cover; ?>');width: 350px;height: 255px;">
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
                                <h3 class="heading">
                                    <a title="Ler mais sobre <?= $post_title; ?>"
                                       href="<?= BASE; ?>/artigo/<?= $post_name; ?>"><?= $post_title; ?></a>
                                </h3>
                                <p class="text-justify"><?= limita_caracteres($post_subtitle, 253, '...'); ?></p>
                                <div class="d-flex align-items-center mt-4">
                                    <p class="mb-0">
                                        <a title="Ler mais sobre <?= $post_title; ?>" class="btn btn-primary"
                                           href="<?= BASE; ?>/artigo/<?= $post_name; ?>">
                                            Saiba Mais
                                            <span class="ion-ios-arrow-round-forward"></span>
                                        </a>
                                    </p>
                                    <p class="ml-auto mb-0">
                                        <!--a class="mr-2" href="#">Proficam</a>
                                                <a class="meta-chat" href="#"><span class="icon-chat"></span> 3</a-->
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php

                endforeach;
            endif;

            $Pager->ExePaginator(DB_POSTS, "WHERE post_status = :status AND post_date <= :date", "status=1&date=".date('Y-m-d H:i:s'));
            //cho $Pager->getPaginator();
            ?>
        </div>
    </div>
</section>


<section class="ftco-section ftco-counter img" data-stellar-background-ratio="0.5" id="section-counter"
         style="background-image: url(<?= BASE; ?>/_cdn/images/bg_3.jpg);">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2 d-flex">
            <div class="col-md-6 align-items-stretch d-flex">
                <div class="img img-video d-flex align-items-center"
                     style="background-image: url(<?= BASE; ?>/_cdn/images/ufop-vista.jpg);">
                    <div class="video justify-content-center">
                        <a class="icon-video popup-vimeo d-flex justify-content-center align-items-center"
                           href="https://vimeo.com/508559903">
                            <span class="ion-ios-play"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 heading-section heading-section-white ftco-animate pl-lg-5 pt-md-0 pt-5">
                <h2 class="mb-4"><?= SITE_NAME; ?></h2>
                <p>O Programa de Pós-Graduação Profissional em Instrumentação, Controle e Automação de Processos de
                    Mineração (PROFICAM), coordenado em associação no âmbito do convênio firmado entre a Universidade
                    Federal de Ouro Preto e o Instituto Tecnológico Vale - UFOP/ITV, visa atender à demanda da empresa
                    do setor mineral e fomentar a sinergia entre o estudo investigativo, o desenvolvimento tecnológico,
                    a inovação, a produção e a indústria.</p>
                <h2 class="mb-4">Público-alvo</h2>
                <p>Profissionais interessados em adquirir uma visão interdisciplinar sobre instrumentação, controle e
                    automação de processos de mineração.</p>
            </div>
        </div>
        <div class="row d-md-flex align-items-center justify-content-center py-4">
            <div class="col-lg-12">
                <div class="row d-md-flex align-items-center">

                    <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="icon"><span class="flaticon-doctor"></span></div>
                            <div class="text">
                                <strong class="number" data-number="1009">300</strong>
                                <span>Publicações Científicas</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="icon"><span class="flaticon-doctor"></span></div>
                            <div class="text">
                                <strong class="number" data-number="29">0</strong>
                                <span>Projetos de Pesquisa</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="icon"><span class="flaticon-doctor"></span></div>
                            <div class="text">
                                <strong class="number" data-number="104">0</strong>
                                <span>Discentes e Egressos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="ftco-section py-5">
    <div class="container px-4">
        <div class="row justify-content-center mb-4 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <h2 class="mb-4"><span>Nossas</span> Linhas de Pesquisa</h2>
                <p>Nosso programa tem como área de concentração Instrumentação, Controle e Automação de Processos de
                    Mineração e possui as seguintes linhas de pesquisa</p>
            </div>
        </div>
        <div class="row">
            <?php
            $Read->ExeRead(DB_RESEARCH, "WHERE research_status = :status ORDER BY research_name ASC", "status=1");
            if (!$Read->getResult()):
                echo Erro("Ainda Não existe linhas de pesquisa cadastradas. Favor volte mais tarde :)", E_USER_NOTICE);
            else:
                foreach ($Read->getResult() as $Pesquisa):
                    extract($Pesquisa);
                    ?>
                    <div class="col-md-3 col-lg-3 course ftco-animate">
                        <div class="img"
                             style="background-image: url(<?= BASE; ?>/uploads/linhas_pesquisa/<?= $research_img ;?>);"></div>
                        <div class="text pt-4">
                            <h3><a href="#"><?= $research_name ;?></a></h3>
                            <p class="text-justify"><?= limita_caracteres( $research_description, 140, false );?></p>

                        </div>
                        <div class="embaixo">
                            <a class="btn btn-primary" href="<?= BASE . "/linhas-de-pesquisa/" .$research_link;?>">Saiba Mais
                                &nbsp;<span class="ion-ios-arrow-round-forward"></span></a>
                        </div>


                    </div>

                <?php endforeach;
            endif;
            ?>
        </div>
    </div>
</section>


<section class="ftco-section ftco-consult py-5" data-stellar-background-ratio="0.5"
         style="background-image: url(<?= BASE; ?>/_cdn/images/palestra.jpg);background-repeat: no-repeat;background-size: cover;">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <h2 class="mb-4 text-light"><span>Próximas</span> Defesas</h2>
                <p class="text-light">Confira as próximas defesas de nosso programa</p>
            </div>
        </div>
        <div class="row">
            <?php
            $Read->FullRead("SELECT * FROM ".DB_INTERVIEW.
                " LEFT JOIN ".DB_STUDENTS." ON interview_student = students_id"
                ." LEFT JOIN " . DB_INTERVIEW_TYPE. " ON interview_type_id = interview_type"
                . " WHERE interview_status = :status ORDER BY interview_date ASC LIMIT :limit", "status=1&limit=3");
            if (!$Read->getResult()):
                $Pager->ReturnPage();
                echo Erro("Ainda Não existe defesas cadastrados. Favor volte mais tarde :)", E_USER_NOTICE);
            else:

                foreach ($Read->getResult() as $Interview):
                    extract($Interview);
                    $interview_date = new DateTime($interview_date);

                    ?>
                    <div class="col-md-6 col-lg-4 ftco-animate">
                        <div class="blog-entry align-content-stretch">
                            <div class="text bg-white p-4" style="border-radius: 16px;">
                                <h5 class="heading" style="font-size: 16px;">
                                    <a title="Detalhes da defesa <?= $students_name; ?>"
                                       href="<?= BASE; ?>/defesa/<?= $interview_link; ?>"> <?= $students_name; ?><br></a>
                                </h5>
                                <p><?=$interview_type_name;?></p>
                                <p><strong>Data:</strong> <?= $interview_date->format('d/m/Y');?> <span
                                            class="ml-4"><strong>Horário:</strong> <?=$interview_date->format('H:i');?></span></p>
                                <p><strong>Local: </strong><?= ($interview_local ? $interview_local : "---");?></p>

                                <div class="d-flex align-items-center mt-4">
                                    <a title="Detalhes da defesa <?= $students_name; ?>" class="btn btn-primary"
                                       href="<?= BASE; ?>/defesas/<?= $interview_link; ?>">
                                        Detalhes &nbsp;
                                        <span class="ion-ios-arrow-round-forward"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;endif;?>

        </div>
        <div class="row justify-content-center mb-5 py-2">
            <div class="col-md-8 text-center heading-section heading-section-white ftco-animate">
                <a href="defesas" class="btn btn-lg btn-primary">Veja Todas as Defesas</a>
            </div>
        </div>

    </div>
</section>

<section class="ftco-section bg-light pb-5">
    <div class="container px-4">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <h2 class="mb-4">Corpo Docente</h2>

            </div>
        </div>
        <div class="row">
            <div class="col-md- col-lg-12 ftco-animate">
                <div class="carousel-teachers owl-carousel py-5">
                    <?php
                    $Read->ExeRead(DB_TEACHERS, "WHERE (teacher_status = :status OR teacher_status = :status2) ORDER BY rand() ", "status=1&status2=2");
                    if (!$Read->getResult()):
                        echo Erro("Ainda Não existe professores. Favor volte mais tarde :)", E_USER_NOTICE);
                    else:
                        foreach ($Read->getResult() as $Professores):
                            extract($Professores);
                            $partes = explode(' ', $teacher_name);
                            $primeiroNome = array_shift($partes);
                            $ultimoNome = array_pop($partes);
                            $teacher_name = $primeiroNome . " ". $ultimoNome;
                            ?>
                            <div class="item">
                                <div class="staff">
                                    <div class="img-wrap d-flex align-items-stretch">
                                        <div class="img-wrap"
                                             style="background-image: url(<?= BASE; ?>/tim.php?src=<?= (!$teacher_thumb ? 'admin/_img/no_avatar.jpg' : 'uploads/'.$teacher_thumb); ?>&w=150&h=150);">
                                        </div>
                                    </div>
                                    <div class="text pt-3 text-center">
                                        <h6><?= ($teacher_social_name ? $teacher_social_name :$teacher_name);?></h6>
                                        <span class="position mb-2"></span>
                                        <div class="faded">

                                            <ul class="ftco-social text-center">
                                                <li class="ftco-animate">
                                                    <a class="btn btn-sm btn-primary"
                                                       href="<?= BASE . "/professor/".$teacher_link;?>">Perfil Completo</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="ftco-section ftco-consult ftco-no-pt ftco-no-pb" data-stellar-background-ratio="0.5"
         style="background-image: url(<?= BASE; ?>/_cdn/images/bg_5.jpg);">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-6 py-5 px-md-5">
                <div class="py-md-5">
                    <div class="heading-section heading-section-white mb-5">
                        <h2 class="mb-4">Fale Conosco</h2>
                        <p>Possui alguma dúvida que não esteja em nosso site? Envie-nos uma mensagem.</p>

                        <div class="wc_contact_error jwc_contact_error"></div>
                        <form action="#" class="jwc_contact_form appointment-form " name="wc_send_contact"
                              method="post" enctype="multipart/form-data">
                            <div class="d-md-flex">
                                <div class="form-group">
                                    <input class="form-control" name="nome" placeholder="Nome" type="text">
                                </div>
                                <div class="form-group ml-md-4">
                                    <input class="form-control" name="email" placeholder="E-mail" type="text">
                                </div>
                            </div>
                            <div class="d-md-flex">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input class="form-control" name="phone" placeholder="Celular" type="text">
                                    </div>
                                </div>
                                <div class="form-group ml-md-4">
                                    <textarea class="form-control" cols="30" name="message" placeholder="Mensagem"
                                              rows="2"></textarea>
                                </div>

                            </div>
                            <div class="d-md-flex">
                                <div class="form-group wc_contact_modal_button">
                                    <input class="btn btn-primary py-3 px-4" type="submit" value="Enviar Mensagem">
                                    <img src="<?= BASE; ?>/_cdn/widgets/contact/images/load.gif"
                                         alt="Aguarde, enviando contato!" title="Aguarde, enviando contato!" width="32px" height="20px"/>
                                </div>
                            </div>
                        </form>
                        <div style="display: none;" class="wc_contant_sended jwc_contant_sended">
                            <p class="h2"><span>&#10003;</span><br>Mensagem enviada com sucesso!</p>
                            <p><b>Prezado(a) <span class="jwc_contant_sended_name">NOME</span>. Obrigado por entrar em
                                    contato,</b></p>
                            <p>Informamos que recebemos sua mensagem, e que vamos responder o mais breve possível.</p>
                            <p><em>Atenciosamente <?= SITE_NAME; ?>.</em></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="ftco-section testimony-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <h2 class="mb-4">O que dizem nossos alunos</h2>
                <p>Veja depoimentos de quem estuda e já estudou conosco</p>
            </div>
        </div>
        <div class="row ftco-animate justify-content-center">
            <div class="col-md-12">
                <div class="carousel-testimony owl-carousel pb-5">
                    <?php
                    $Read->FullRead("SELECT * FROM " .DB_TESTIMONIALS. " LEFT JOIN " .DB_STUDENTS. " ON testimonial_student = students_id WHERE testimonial_status = :status", "status=1");
                    if (!$Read->getResult()):
                        echo Erro("Ainda Não existe depoimentos. :)", E_USER_NOTICE);
                    else:
                        foreach ($Read->getResult() as $Depoimentos):
                            extract($Depoimentos);
                            ?>
                            <div class="item">
                                <div class="testimony-wrap d-flex">
                                    <div class="user-img mr-4"
                                         style="background-image: url(<?= BASE; ?>/uploads/<?=$students_thumb;?>)">
                                    </div>
                                    <div class="text ml-2">
                                <span class="quote d-flex align-items-center justify-content-center">
                                    <i class="icon-quote-left"></i>
                                </span>
                                        <p class="text-justify"><?=$testimonial_text;?></p>
                                        <p class="name"><?=$students_name;?></p>
                                        <span class="position"><?="Turma de ".getStudentsClass($students_class);?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>
<?php
$Read->FullRead("SELECT gallery_image_file FROM " . DB_GALLERY . " s LEFT JOIN ".DB_GALLERY_IMAGES." p ON s.gallery_id = p.gallery_id WHERE gallery_status =:status AND gallery_link = :link", "status=1&link=pagina-inicial");
if ($Read->getResult()):
?>
<section class="ftco-gallery">
    <div class="container-wrap">
        <div class="row no-gutters">
            <?php
            foreach ($Read->getResult() as $Gallery):
                extract($Gallery);
            ?>
            <div class="col-md-3 ftco-animate">
                <h2 style="display:none">Fotos</h2>
                <a class="gallery image-popup img d-flex align-items-center" href="<?= BASE ."/uploads/". $gallery_image_file; ?>"
                   style="background-image: url(<?= BASE ."/uploads/". $gallery_image_file;?>);">
                    <div class="icon mb-4 d-flex align-items-center justify-content-center">
                        <span class="icon-instagram"></span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
<?php endif; ?>

