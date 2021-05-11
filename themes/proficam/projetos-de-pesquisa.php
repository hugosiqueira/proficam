<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE;?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Projetos de Pesquisa</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE;?>">Início <i class="ion-ios-arrow-forward"></i></a></span> <span>Projetos de Pesquisas <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>

<?php
if (!$Read):
    $Read = new Read;
endif;
if($URL[1]):

$Read->ExeRead(DB_PROJECTS, "WHERE project_link = :nm  AND project_status = :status ", "nm=".$URL[1]."&status=1");
if (!$Read->getResult()):
    require REQUIRE_PATH . '/404.php';
    return;
else:
    extract($Read->getResult()[0]);
endif;

?>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ftco-animate">
                <div class=" heading-section ftco-animate">
                    <h3 class="mb-4"><span>Projeto de Pesquisa</span> </h3>
                </div>
                <div>
                    <p><strong>Título: </strong><?=$project_title;?></p>
                    <p><strong>Linha de Pesquisa: </strong><?=$project_research_line;?></p>
                    <?=($project_members ? "<p><strong>Membros: </strong>$project_members</p>" : "")?>
                    <?=($project_financiers ? "<p><strong>Financiadores: </strong>$project_financiers</p>" : "" );?>
                    <p><strong>Resumo:</strong></p>
                    <?= $project_description; ?>
                </div>
                <div class="clear"></div>
            </div>

            <?php require REQUIRE_PATH . '/inc/sidebar_pag.php'; ?>
            <div class="clear"></div>
        </div>
    </div>
</section>
    <?php
    else:
    ?>
<section class="ftco-section bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 ftco-animate">
                <div class=" heading-section ftco-animate">
                    <h3 class="mb-4"><span>Projetos de Pesquisa</span> </h3>
                </div>
                <div class ="row">
                    <table class='styled-table'>

                        <tbody>
                        <?php
                        $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
                        $Page = ($getPage ? $getPage : 1);
                        $Pager = new Pager("dashboard.php?wc=projetos/home&page=", "<<", ">>", 5);
                        $Pager->ExePager($Page, 100);
                        $Read->FullRead("SELECT * FROM ". DB_PROJECTS." WHERE project_status= :status ORDER BY project_title ASC LIMIT :limit OFFSET :offset", "status=1&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                        if (!$Read->getResult()):
                            $Pager->ReturnPage();
                            echo Erro("<span class='al_center icon-notification'>Ainda não existem projetos de pesquisa cadastrados {$Admin['user_name']}. Comece agora mesmo cadastrando um novo projeto de pesquisa!</span>", E_USER_NOTICE);
                        else:
                            foreach ($Read->getResult() as $Projects):
                                extract($Projects);
                                echo "
                    
                    <tr>
                    <td>{$project_title}</td>
     
                    <td><a href='projetos-de-pesquisa/{$project_link}' class=' btn btn-primary'> Detalhes</a></td>
              
                    </tr>
                    
                ";
                            endforeach;
                            $Pager->ExePaginator(DB_PROJECTS);
                            echo $Pager->getPaginator();
                        endif;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php require REQUIRE_PATH . '/inc/sidebar_pag.php'; ?>
            <div class="clear"></div>
        </div>
    </div>
</section>
<?php endif;?>
