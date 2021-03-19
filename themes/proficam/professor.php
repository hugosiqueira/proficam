<?php
if (!$Read):
    $Read = new Read;
endif;
$Read->ExeRead(DB_TEACHERS, "WHERE teacher_link = :url", "url={$URL[1]}");
if (!$Read->getResult()):
    echo Erro("Professor não encontrado.)", E_USER_NOTICE);
else:
    foreach ($Read->getResult() as $Professores):
        extract($Professores);
        $partes = explode(' ', $teacher_name);
        $primeiroNome = array_shift($partes);
        $ultimoNome = array_pop($partes);
        $teacher_name_abr = $primeiroNome . " ". $ultimoNome;
    endforeach;

    ?>
<style>
    .site-title {
        font-size: 1.25rem;
        line-height: 2.5rem; }

    .nav-link {
        padding: 0;
        font-size: 1.25rem;
        line-height: 2.5rem;
        color: rgba(0, 0, 0, 0.5); }
    .cover {
        border-radius: 10px; }

    .cover-bg {
        background-color: #FFF;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.12'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        border-radius: 10px 10px 0 0; }

    .avatar {
        max-width: 216px;
        max-height: 216px;
        margin-top: 20px;
        text-align: center;
        margin-left: auto;
        margin-right: auto; }

    .avatar img {
        /* Safari 6.0 - 9.0 */
        filter: grayscale(100%); }

    footer a:not(.nav-link) {
        color: inherit;
        border-bottom: 1px dashed;
        text-decoration: none;
        cursor: pointer; }

    @media (min-width: 48em) {
        .site-title {
            float: left; }
        .site-nav {
            float: right; }
        .avatar {
            margin-bottom: -80px;
            margin-left: 0; } }

    @media print {
        body {
            background-color: #fff; }
        .container {
            width: auto;
            max-width: 100%;
            padding: 0; }
        .cover, .cover-bg {
            border-radius: 0; }
        .cover.shadow-lg {
            box-shadow: none !important; }
        .cover-bg {
            padding: 5rem !important;
            padding-bottom: 10px !important; }
        .avatar {
            margin-top: -10px; }
        .about-section {
            padding: 6.5rem 5rem 2rem !important; }
        .skills-section,
        .work-experience-section,
        .education-section,
        .contant-section {
            padding: 1.5rem 5rem 2rem !important; }
        .page-break {
            padding-top: 5rem;
            page-break-before: always; } }
</style>
<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE; ?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread"><?= ($teacher_social_name ? "$teacher_social_name": $teacher_name_abr);?></h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE; ?>">Início <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="<?= BASE; ?>/corpo-docente">Professores <i class="ion-ios-arrow-forward"></i></a></span> </p>
            </div>
        </div>
    </div>
</section>


<section class="ftco-section">

<div class="page-content">
      <div class="container">
<div class="cover shadow-lg bg-white">
  <div class="cover-bg p-3 p-lg-4 text-white">
    <div class="row">

      <div class="col-lg-4 col-md-5 staff">
        <div class="p-1 ml-5"><img class="perfil" src="<?= BASE; ?>/tim.php?src=<?= (!$teacher_thumb ? 'admin/_img/no_avatar.jpg' : 'uploads/'.$teacher_thumb); ?>&w=300&h=300);" /></div>
      </div>
      <div class="col-lg-8 col-md-7 text-center text-md-start">
        <h2 class="h1 mt-2" data-aos="fade-left" data-aos-delay="0"><?=$teacher_name;?></h2>
        <p class="text-dark"><?= ($teacher_productivity ? $teacher_scholarship: "");?></p>
          <div class="d-print-none" data-aos="fade-left" data-aos-delay="200"><a class="btn btn_blue  shadow-sm mt-1 me-1" href="<?= $teacher_lattes;?>" target="_blank"><span class="icon-cappes btn-icon text-primary"></span>Currículo Lattes</a></div>
      </div>
    </div>
  </div>
  <div class="about-section pt-4 px-3 px-lg-4 mt-1">
    <div class="row">
      <div class="col-md-6">
        <h2 class="h3 mb-3">Resumo</h2>
        <p class="text-justify"><?=$teacher_resume;?></p>
      </div>
      <div class="col-md-5 offset-md-1">
        <div class="row mt-2">
            <div class="col-sm-4">
                <div class="pb-1"><strong>Vínculo:</strong></div>
            </div>
            <div class="col-sm-8">
                <div class="pb-1 text-secondary"><?=getTeacherStatus($teacher_status);?></div>
            </div>
            <div class="col-sm-4">
                <div class="pb-1"><strong>Titulação:</strong></div>
            </div>
            <div class="col-sm-8">
                <div class="pb-1 text-secondary"><?=getTitle($teacher_title) ." ({$teacher_title_year}/".getCountry($teacher_title_country).")";?></div>
            </div>
            <div class="col-sm-4">
                <div class="pb-1"><strong><?=getTitle($teacher_title) . ':'?></strong></div>
            </div>
            <div class="col-sm-8">
                <div class="pb-1 text-secondary"><?=$teacher_title_desc?></div>
            </div>
            <div class="col-sm-4">
                <div class="pb-1"><strong>Área de Atuação:</strong></div>
            </div>
            <div class="col-sm-8">
                <div class="pb-1 text-secondary"><?=$teacher_area;?></div>
            </div>
            <div class="col-sm-4">
                <div class="pb-1"><strong>IES:</strong></div>
            </div>
            <div class="col-sm-8">
                <div class="pb-1 text-secondary"><?=$teacher_university;?></div>
            </div>

          <div class="col-sm-4">
            <div class="pb-1"><strong>E-mail:</strong></div>
          </div>
          <div class="col-sm-8">
            <div class="pb-1 text-secondary"><?=$teacher_email;?></div>
          </div>
          <div class="col-sm-4">
            <div class="pb-1"><strong>Telefone:</strong></div>
          </div>
          <div class="col-sm-8">
            <div class="pb-1 text-secondary"><?= SITE_ADDR_PHONE_A;?></div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <hr class="d-print-none"/>
</div>
      </div>
</div>
</section>
  <!--div class="skills-section px-3 px-lg-4">
    <h2 class="h3 mb-3">Professional Skills</h2>
    <div class="row">
      <div class="col-md-6">
        <div class="mb-2"><span>HTML</span>
          <div class="progress my-1">
            <div class="progress-bar bg-primary" role="progressbar" data-aos="zoom-in-right" data-aos-delay="100" data-aos-anchor=".skills-section" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="mb-2"><span>CSS</span>
          <div class="progress my-1">
            <div class="progress-bar bg-primary" role="progressbar" data-aos="zoom-in-right" data-aos-delay="200" data-aos-anchor=".skills-section" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="mb-2"><span>JavaScript</span>
          <div class="progress my-1">
            <div class="progress-bar bg-primary" role="progressbar" data-aos="zoom-in-right" data-aos-delay="300" data-aos-anchor=".skills-section" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-2"><span>Adobe Photoshop</span>
          <div class="progress my-1">
            <div class="progress-bar bg-success" role="progressbar" data-aos="zoom-in-right" data-aos-delay="400" data-aos-anchor=".skills-section" style="width: 80%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="mb-2"><span>Sketch</span>
          <div class="progress my-1">
            <div class="progress-bar bg-success" role="progressbar" data-aos="zoom-in-right" data-aos-delay="500" data-aos-anchor=".skills-section" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="mb-2"><span>Adobe XD</span>
          <div class="progress my-1">
            <div class="progress-bar bg-success" role="progressbar" data-aos="zoom-in-right" data-aos-delay="600" data-aos-anchor=".skills-section" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr class="d-print-none"/>
  <div class="work-experience-section px-3 px-lg-4">
    <h2 class="h3 mb-4">Work Experience</h2>
    <div class="timeline">
      <div class="timeline-card timeline-card-primary card shadow-sm">
        <div class="card-body">
          <div class="h5 mb-1">Frontend Developer <span class="text-muted h6">at Creative Agency</span></div>
          <div class="text-muted text-small mb-2">May, 2015 - Present</div>
          <div>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition.</div>
        </div>
      </div>
      <div class="timeline-card timeline-card-primary card shadow-sm">
        <div class="card-body">
          <div class="h5 mb-1">Graphic Designer <span class="text-muted h6">at Design Studio</span></div>
          <div class="text-muted text-small mb-2">June, 2013 - May, 2015</div>
          <div>Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.</div>
        </div>
      </div>
      <div class="timeline-card timeline-card-primary card shadow-sm">
        <div class="card-body">
          <div class="h5 mb-1">Junior Web Developer <span class="text-muted h6">at Indie Studio</span></div>
          <div class="text-muted text-small mb-2">Jan, 2011 - May, 2013</div>
          <div>User generated content in real-time will have multiple touchpoints for offshoring. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.</div>
        </div>
      </div>
    </div>
  </div>
  <hr class="d-print-none"/>
  <div class="page-break"></div>
  <div class="education-section px-3 px-lg-4 pb-4">
    <h2 class="h3 mb-4">Education</h2>
    <div class="timeline">
      <div class="timeline-card timeline-card-success card shadow-sm">
        <div class="card-body">
          <div class="h5 mb-1">Masters in Information Technology <span class="text-muted h6">from International University</span></div>
          <div class="text-muted text-small mb-2">2011 - 2013</div>
          <div>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition.</div>
        </div>
      </div>
      <div class="timeline-card timeline-card-success card shadow-sm">
        <div class="card-body">
          <div class="h5 mb-1">Bachelor of Computer Science <span class="text-muted h6">from Regional College</span></div>
          <div class="text-muted text-small mb-2">2007 - 2011</div>
          <div>Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.</div>
        </div>
      </div>
      <div class="timeline-card timeline-card-success card shadow-sm">
        <div class="card-body">
          <div class="h5 mb-1">Science and Mathematics <span class="text-muted h6">from Mt. High Scool</span></div>
          <div class="text-muted text-small mb-2">1995 - 2007</div>
          <div>User generated content in real-time will have multiple touchpoints for offshoring. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.</div>
        </div>
      </div>
    </div>
  </div>
  <hr class="d-print-none"/>
  <div class="contant-section px-3 px-lg-4 pb-4" id="contact">
    <h2 class="h3 text mb-3">Contact</h2>
    <div class="row">
      <div class="col-md-7 d-print-none">
        <div class="my-2"><form action="https://formspree.io/your@email.com"
    method="POST">
  <div class="row">
    <div class="col-6">
      <input class="form-control" type="text" id="name" name="name" placeholder="Your Name" required>
    </div>
    <div class="col-6">
      <input class="form-control" type="email" id="email" name="_replyto" placeholder="Your E-mail" required>
    </div>
  </div>
  <div class="form-group my-2">
    <textarea class="form-control" style="resize: none;" id="message" name="message" rows="4"  placeholder="Your Message" required></textarea>
  </div>
  <button class="btn btn-primary mt-2" type="submit">Send</button>
</form>
        </div>
      </div>
      <div class="col">
        <div class="mt-2">
          <h3 class="h6">Address</h3>
          <div class="pb-2 text-secondary">140, City Center, New York, U.S.A</div>
          <h3 class="h6">Phone</h3>
          <div class="pb-2 text-secondary">+0718-111-0011</div>
          <h3 class="h6">Email</h3>
          <div class="pb-2 text-secondary">Joyce@company.com</div>
        </div>
      </div>
      <div class="col d-none d-print-block">
        <div class="mt-2">
          <div>
            <div class="mb-2">
              <div class="text-dark"><i class="fab fa-twitter mr-1"></i><span>https://twitter.com/templateflip</span>
              </div>
            </div>
            <div class="mb-2">
              <div class="text-dark"><i class="fab fa-facebook mr-1"></i><span>https://www.facebook.com/templateflip</span>
              </div>
            </div>
            <div class="mb-2">
              <div class="text-dark"><i class="fab fa-instagram mr-1"></i><span>https://www.instagram.com/templateflip</span>
              </div>
            </div>
            <div class="mb-2">
              <div class="text-dark"><i class="fab fa-github mr-1"></i><span>https://github.com/templateflip</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div></div>
    </div>
</div-->

<?php endif; ?>