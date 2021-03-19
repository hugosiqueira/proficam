<?php
echo "<link rel='stylesheet' href='" . BASE . "/_cdn/widgets/contact/contact.wc.css'/>";
echo "<script src='" . BASE . "/_cdn/widgets/contact/contact.wc.js'></script>";
?>
<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE;?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Fale Conosco</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE;?>">Início <i class="ion-ios-arrow-forward"></i></a></span> <span>Fale Conosco <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section contact-section">
    <div class="container">
        <div class="row d-flex contact-info">
            <div class="col-md-3 d-flex">
                <div class="bg-light align-self-stretch box p-4 text-center">
                    <h3 class="mb-4">Endereço</h3>
                    <p><?= SITE_ADDR_ADDR . '<br />' . SITE_ADDR_DISTRICT . ' - ' . SITE_ADDR_CITY. '/'.SITE_ADDR_UF.'<br/>'. SITE_ADDR_COUNTRY;?></p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="bg-light align-self-stretch box p-4 text-center">
                    <h3 class="mb-4">Telefone</h3>
                    <p><a href="tel://<?= SITE_ADDR_PHONE_A;?>"><?= SITE_ADDR_PHONE_A;?></a></p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="bg-light align-self-stretch box p-4 text-center">
                    <h3 class="mb-4">E-mail</h3>
                    <p><a href="mailto:<?= SITE_ADDR_EMAIL;?>"><?= SITE_ADDR_EMAIL;?></a></p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="bg-light align-self-stretch box p-4 text-center">
                    <h3 class="mb-4">Website</h3>
                    <p><a href="#"><?=SITE_ADDR_SITE;?></a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pt ftco-no-pb contact-section" style="padding-top: 5rem;">
    <div class="container">
        <div class="row d-flex align-items-stretch no-gutters">
            <div class="col-md-6 p-4 p-md-5 order-md-last bg-light">
                <div class="wc_contact_error jwc_contact_error"></div>
                <form action="" class="jwc_contact_form" name="wc_send_contact" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" name="nome" placeholder="Nome Completo" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="E-mail" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control formPhone" name="phone" placeholder="Celular" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" rows="7" placeholder="Deixe uma mensagem:" required></textarea>
                    </div>
                    <div class="form-group wc_contact_modal_button">
                        <input type="submit" value="Enviar Mensagem" class="btn btn-primary py-3 px-5">
                        <img src="<?= BASE; ?>/_cdn/widgets/contact/images/load.gif" alt="Aguarde, enviando contato!" title="Aguarde, enviando contato!"/>
                    </div>
                </form>
                <div style="display: none;" class="wc_contant_sended jwc_contant_sended">
                    <p class="h2"><span>&#10003;</span><br>Mensagem enviada com sucesso!</p>
                    <p><b>Prezado(a) <span class="jwc_contant_sended_name">NOME</span>. Obrigado por entrar em contato,</b></p>
                    <p>Informamos que recebemos sua mensagem, e que vamos responder o mais breve possível.</p>
                    <p><em>Atenciosamente <?= SITE_NAME; ?>.</em></p>

                </div>
            </div>

            <div class="col-md-6 d-flex align-items-stretch">
                <div style="height: 600px;"><iframe  style="height: 520px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14958.632045739945!2d-43.5017342!3d-20.3969858!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x1edf875fece12593!2sInstituto%20Tecnol%C3%B3gico%20Vale%20(ITV%20MI)!5e0!3m2!1spt-BR!2sbr!4v1615047879160!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe></div>
            </div>
        </div>
    </div>
</section>