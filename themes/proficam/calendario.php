<style>
    .project-tab {
        padding: 10%;
        margin-top: -8%;
    }
    .project-tab #tabs{
        background: #007b5e;
        color: #eee;
    }
    .project-tab #tabs h6.section-title{
        color: #eee;
    }
    .project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #0D1128;
        background-color: transparent;
        border-color: transparent transparent #f3f3f3;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bold;
    }
    .project-tab .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        color: #0D1128;
        font-size: 16px;
        font-weight: 600;
    }
    .project-tab .nav-link:hover {
        border: none;
    }
    .project-tab thead{
        background: #f3f3f3;
        color: #333;
    }
    .project-tab a{
        text-decoration: none;
        color: #333;
        font-weight: 600;
    }
</style>
<section id="tabs" class="project-tab">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center heading-section ftco-animate">
                <h3 class="mb-4"><span>Calendário do Processo Seletivo</span> </h3>
            </div>
            <div class="col-md-12 py-2">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">

                    <?php

                    $querySelectionSchedule = "SELECT MONTHNAME(schedule_initial_date) as mes, MONTH(schedule_initial_date) as num_mes  FROM ". DB_SELECTION_PROCESS_SCHEDULE. " p";
                    $querySelectionSchedule .= " LEFT JOIN " . DB_SELECTION_PROCESS . " s ON p.schedule_selection_process = s.selection_process_id";
                    $querySelectionSchedule .= " WHERE s.selection_process_id = :id  GROUP BY MONTH(schedule_initial_date) ORDER BY schedule_initial_date ASC";
                    $Read->FullRead($querySelectionSchedule, "id=1");
                    if ($Read->getResult()):
                        foreach ($Read->getResult() as $MONTH):
                            extract($MONTH);
                    ?>

                            <a class="nav-item nav-link" id="nav-<?=$num_mes?>-tab" data-toggle="tab" href="#nav-<?=$num_mes?>" role="tab" aria-controls="nav-<?=$num_mes?>" aria-selected="true"><?=$mes?></a>

                    <?php
                    endforeach;
                    endif;
                    ?>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                <?php
                $querySelectionSchedule = "SELECT *, MONTHNAME(schedule_initial_date) as mes, MONTH(schedule_initial_date) as num_mes FROM ". DB_SELECTION_PROCESS_SCHEDULE. " p";
                $querySelectionSchedule .= " LEFT JOIN " . DB_SELECTION_PROCESS . " s ON p.schedule_selection_process = s.selection_process_id";
                $querySelectionSchedule .= " WHERE s.selection_process_id = :id GROUP BY MONTH(schedule_initial_date) ORDER BY schedule_initial_date ASC ";
                $Read->FullRead($querySelectionSchedule, "id=1");
                if ($Read->getResult()):
                    foreach ($Read->getResult() as $MONTH):
                        extract($MONTH);
                ?>

                    <div class="tab-pane fade show" id="nav-<?=$num_mes?>" role="tabpanel" aria-labelledby="nav-<?=$num_mes?>-tab">
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
                    endforeach;

                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>