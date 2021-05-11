<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE; ?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Processos Seletivos em Andamento</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE; ?>">Início <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="processo-seletivo">Processos Seletivos <i class="ion-ios-arrow-forward"></i></a></span> </p>
            </div>
        </div>
    </div>
</section>
<?php
if (!$Read):
    $Read = new Read;
endif;
$Read->ExeRead(DB_SELECTION_PROCESS, "WHERE selection_process_status = :status", "status=1");
extract($Read->getResult()[0]);
?>

<section class="ftco-section  py-5">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class=" text-center heading-section ftco-animate">
                <h2 class="mb-4"><span>Processo Seletivo</span> <?=$selection_process_year?></h2>
                <p class="text-dark">Confira todos os detalhes do nosso processo seletivo</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="py-4">
                    <div class=" heading-section ftco-animate">
                        <h3 class="mb-4"><span>Calendário do Processo Seletivo</span> </h3>
                    </div>
                    <div class="py-2">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <?php
                                $querySelectionSchedule = "SELECT MONTHNAME(schedule_initial_date) as mes, MONTH(schedule_initial_date) as num_mes  FROM ". DB_SELECTION_PROCESS_SCHEDULE. " p";
                                $querySelectionSchedule .= " LEFT JOIN " . DB_SELECTION_PROCESS . " s ON p.schedule_selection_process = s.selection_process_id";
                                $querySelectionSchedule .= " WHERE s.selection_process_status = :id  GROUP BY MONTH(schedule_initial_date) ORDER BY schedule_initial_date ASC";
                                $Read->FullRead($querySelectionSchedule, "id=1");

                                if ($Read->getResult()):
                                    $i=0;
                                    foreach ($Read->getResult() as $MONTH):
                                        extract($MONTH);
                                        $mes = limita_caracteres($mes,3,'', true);
                                        ?>
                                        <a class="nav-item nav-link <?=($i==0 ? 'active' : '');?>" id="nav-<?=$num_mes?>-tab" data-toggle="tab" href="#nav-<?=$num_mes?>" role="tab" aria-controls="nav-<?=$num_mes?>" aria-selected="true"><?=$mes?></a>
                                    <?php
                                    $i++;
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">
                            <?php
                            $querySelectionSchedule = "SELECT *, MONTHNAME(schedule_initial_date) as mes, MONTH(schedule_initial_date) as num_mes FROM ". DB_SELECTION_PROCESS_SCHEDULE. " p";
                            $querySelectionSchedule .= " LEFT JOIN " . DB_SELECTION_PROCESS . " s ON p.schedule_selection_process = s.selection_process_id";
                            $querySelectionSchedule .= " WHERE s.selection_process_status = :id GROUP BY MONTH(schedule_initial_date) ORDER BY schedule_initial_date ASC ";
                            $Read->FullRead($querySelectionSchedule, "id=1");
                            if ($Read->getResult()):
                                $j=0;
                                foreach ($Read->getResult() as $MONTH):
                                    extract($MONTH);
                                    ?>
                                    <div class="tab-pane fade show <?=($j==0 ? 'active' : '');?>" id="nav-<?=$num_mes?>" role="tabpanel" aria-labelledby="nav-<?=$num_mes?>-tab" >
                                        <table class="styled-table">
                                            <thead>
                                            <tr>
                                                <th>Programação</th>
                                                <th>Data</th>
                                                <th>Local</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $Read->ExeRead(DB_SELECTION_PROCESS_SCHEDULE, " WHERE MONTH(schedule_initial_date) =". $num_mes);
                                            foreach ($Read->getResult() as $Schedule):
                                                extract($Schedule);
                                                ?>
                                                <tr>
                                                    <td><?=$schedule_name;?></td>
                                                    <td><?=($schedule_initial_date ? date('d/m/Y', strtotime($schedule_initial_date)) : "") . ($schedule_final_date&& $schedule_final_date !='0000-00-00 00:00:00' ? " a " . date('d/m/Y', strtotime($schedule_final_date)) : "");?></td>
                                                    <td><?=$schedule_local;?></td>
                                                </tr>
                                            <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php
                                $j++;
                                endforeach;

                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="py-2">
                        <h3 class="mb-1"><span>Informações, Edital e Resultados</span></h3>
                        <table class="styled-table">
                            <thead>
                            <th width="70%">Descrição</th>
                            <th width="120%">Publicação</th>
                            <th width="10%" class="text-center">Arquivo</th>
                            </thead>
                            <tbody>
                            <?php
                            $queryFiles = "SELECT * FROM ". DB_SELECTION_PROCESS_FILES. " p";
                            $queryFiles .= " LEFT JOIN " . DB_SELECTION_PROCESS . " s ON p.sp_files_selection_process = s.selection_process_id";
                            $queryFiles .= " WHERE s.selection_process_id = :id  ORDER BY sp_files_publish DESC";
                            $Read->FullRead($queryFiles, "id={$selection_process_id}");
                            if ($Read->getResult()):
                                foreach ($Read->getResult() as $Files):
                                    extract($Files);
                                    ?>

                                    <tr>
                                        <td><?=$sp_files_name;?></td>
                                        <td><?=($sp_files_publish ? date('d/m/Y', strtotime($sp_files_publish)) : "") ;?></td>
                                        <td class="text-center"><a target="_blank" href="<?= BASE.'/uploads/'.$sp_files_link;?>"><span class="icon-file-pdf"></span></a></td>
                                    </tr>
                                <?php endforeach;
                            endif;
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php require REQUIRE_PATH . '/inc/sidebar_pag.php'; ?>
            <div class="clear"></div>
        </div>
    </div>
</section>
