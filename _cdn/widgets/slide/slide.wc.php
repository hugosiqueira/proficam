<?php

echo '<div class="workcontroltime" id="' . (!empty($SlideSeconts) ? $SlideSeconts : 3) . '"></div>';
echo '<link rel="stylesheet" href="' . BASE . '/_cdn/widgets/slide/slide.wc.css"/>';


$Read = new Read;
$Read->ExeRead(DB_SLIDES, "WHERE slide_status = 1 AND slide_start <= NOW() AND (slide_end >= NOW() OR slide_end IS NULL) ORDER BY slide_date DESC");
if ($Read->getResult()):
    $i_slide = 1;
    echo "<section class='home-slider owl-carousel'>";
    foreach ($Read->getResult() as $Slide):
        extract($Slide);
        $SlideLink = (strstr($slide_link, 'http') ? $slide_link : BASE . "/{$slide_link}");
        $SlideTarget = (strstr($slide_link, 'http') ? ("target='_blank'") : null);
        echo "<div class='slider-item' style='background-image:url(" . BASE . "/uploads/" . $slide_image. ");'>";
        echo "<div class='overlay'></div>
        <div class='container'>
            <div class='row no-gutters slider-text align-items-center justify-content-start'
                 data-scrollax-parent='true'>
                <div class='col-md-6 ftco-animate'>
                    <h1 class='mb-4'>{$slide_title}</h1>
                    <p>{$slide_desc}</p>
                    <p><a class='btn btn-primary px-4 py-3 mt-3' {$SlideTarget} title='{$slide_title}' href='{$SlideLink}'>Saiba Mais</a></p>
                </div>
            </div>
        </div>
    </div>";
        $i_slide ++;
    endforeach;

   /* if ($Read->getRowCount() > 1):
        echo "<div class='wc_slide_pager'>";
        echo "<span class='active'></span>";
        echo str_repeat("<span></span>", $Read->getRowCount() - 1);
        echo "</div>";
    endif;
    echo "<div class='clear'></div>";*/
    echo "</section>";
endif;