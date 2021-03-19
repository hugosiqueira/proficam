<?php
/******************************************
************* Funções Gerais **************
******************************************/

/*
 * Recupera Categorias das Galerias (APP Galeria de Imagens)
 */
function getGalleryCat($Category = null)
{
    $GalleryCat = [
        1 => 'Categoria 1', 
        2 => 'Categoria 2',
        3 => 'Categoria 3',
    ];
    if (!empty($Category)):
        return $GalleryCat[$Category];
    else:
        return $GalleryCat;
    endif;
} 

/*
 * Categoria dos Tutoriais (APP Tutoriais)
 */
function getTutorialCat($Category = null)
{
    $TutorialCat = [
        1 => 'Tutoriais do Site',
        2 => 'Tutoriais do Sistema',
        3 => 'Tutoriais de Configurações',
        4 => 'Outros Tutoriais'
    ];
    if (!empty($Category)):
        return $TutorialCat[$Category];
    else:
        return $TutorialCat;
    endif;
} 

/*
 * Dias da Semana (Geral do Sistema)
 */
function getWeekDays($Days = null)
{
    $WeekDays = [
        1 => 'Segunda-Feira',
        2 => 'Terça-Feira',
        3 => 'Quarta-Feira',
        4 => 'Quinta-Feira',
        5 => 'Sexta-Feira',
        6 => 'Sábado',
        7 => 'Domingo'
    ];
    if (!empty($Days)):
        return $WeekDays[$Days];
    else:
        return $WeekDays;
    endif;
} 

/*
 * Meses do Ano (Geral do Sistema)
 */
function getMonthYear($Month = null)
{
    $MonthYear = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    ];
    if (!empty($Month)):
        return $MonthYear[$Month];
    else:
        return $MonthYear;
    endif;
} 

/*
 * Anos (Geral do Sistema)
 */
function getYear($Year = null)
{
    $Years = [
        1 => '2019',
        2 => '2020',
        3 => '2021',
        4 => '2022',
        5 => '2023',
        6 => '2024',
        7 => '2025'
    ];
    if (!empty($Year)):
        return $Years[$Year];
    else:
        return $Years;
    endif;
} 

/*****************************************
 ************** Education ****************
 *****************************************/
/*
 * Categoria do Curso (Cadastro do Curso)
 */
function getCategoryCourses($Categories = null)
{
    $CategoryCourses = [
        1 => 'IT & Software',
        2 => 'Marketing',
        3 => 'Development',
        4 => 'Photography',
        5 => 'Health & Fitness',
        6 => 'Music'
    ];
    if (!empty($Categories)):
        return $CategoryCourses[$Categories];
    else:
        return $CategoryCourses;
    endif;
}

/*
 * Nível do Curso (Cadastro do Curso)
 */
function getLevelCourses($Level = null)
{
    $LevelCourses = [
        1 => 'Iniciante',
        2 => 'Intermediário',
        3 => 'Avançado'
    ];
    if (!empty($Level)):
        return $LevelCourses[$Level];
    else:
        return $LevelCourses;
    endif;
}

/*
 * Língua do Curso (Cadastro do Curso)
 */
function getLanguageCourses($Language = null)
{
    $LanguageCourses = [
        1 => 'Português',
        2 => 'Inglês',
        3 => 'Espanhol',
        4 => 'Francês',
        5 => 'Alemão',
        6 => 'Italiano'
    ];
    if (!empty($Language)):
        return $LanguageCourses[$Language];
    else:
        return $LanguageCourses;
    endif;
}

/*
 * Tipo de Duração do Curso (Cadastro do Curso)
 */
function getDurationType($Type = null)
{
    $DurationType = [
        1 => 'Dia(s)',
        2 => 'Semana(s)',
        3 => 'Mês(es)',
        4 => 'Ano(s)'
    ];
    if (!empty($Type)):
        return $DurationType[$Type];
    else:
        return $DurationType;
    endif;
}

/*
 * Tipo de Aula (Cadastro do Curso)
 */
function getClassType($Type = null)
{
    $ClassType = [
        1 => 'Aula',
        2 => 'Material',
        3 => 'Exercício'
    ];
    if (!empty($Type)):
        return $ClassType[$Type];
    else:
        return $ClassType;
    endif;
}

/*
 * Especialidades dos Professores (Cadastro de Professores)
 */
function getCategoryTeachers($Category = null)
{
    $CategoryTeachers = [
        1 => 'Psychology',
        2 => 'Economics',
        3 => 'Geology & Geophysics',
        4 => 'Graphic Design'
    ];
    if (!empty($Category)):
        return $CategoryTeachers[$Category];
    else:
        return $CategoryTeachers;
    endif;
}

function getCountry($country){
    $Read = new Read;
    $Read->ExeRead( DB_COUNTRY, "WHERE codigo = {$country}");
    $class = $Read->getResult()[0];
    return $class['nome'];
}
function getTeacherStatus($status){
    $StatusTeachers = [
        1 => 'Permanente',
        2 => 'Colaborador',
        3 => 'Inativo'

    ];
    if (!empty($status)):
        return $StatusTeachers[$status];
    else:
        return $StatusTeachers;
    endif;
}
