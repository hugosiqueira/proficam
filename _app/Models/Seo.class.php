<?php

/**
 * Seo [ MODEL ]
 * Classe de apoio para o modelo LINK. Pode ser utilizada para gerar SEO para as páginas do sistema!
 * 
 * @copyright (c) 2014, Robson V. Leite UPINSIDE TECNOLOGIA
 */
class Seo {

    private $Pach;
    private $File;
    private $Link;
    private $Key;
    private $Schema;
    private $Title;
    private $Description;
    private $Image;
    private $Data;

    public function __construct($Pach) {
        $this->Pach = explode('/', strip_tags(trim($Pach)));
        $this->File = (!empty($this->Pach[0]) ? $this->Pach[0] : null);
        $this->Link = (!empty($this->Pach[1]) ? $this->Pach[1] : null);
        $this->Key = (!empty($this->Pach[2]) ? $this->Pach[2] : null);

        $this->setPach();
    }

    public function getSchema() {
        return $this->Schema;
    }

    public function getTitle() {
        return $this->Title;
    }

    public function getDescription() {
        return $this->Description;
    }

    public function getImage() {
        return $this->Image;
    }
    
    public function getData() {
        return $this->Data;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    private function setPach() {
        
        if (empty($Read)):
            $Read = new Read;
        endif;

        $Pages = array();
        $Read->FullRead("SELECT page_name FROM " . DB_PAGES);
        if ($Read->getResult()):
            foreach ($Read->getResult() as $SinglePage):
                $Pages[] = $SinglePage['page_name'];
            endforeach;
        endif;

        if (in_array($this->File, $Pages)):
            //PÁGINAS 
            $Read->FullRead("SELECT page_title, page_subtitle, page_cover FROM " . DB_PAGES . " WHERE page_name = :nm", "nm={$this->File}");
            if ($Read->getResult()):
                $Page = $Read->getResult()[0];
                $this->Schema = 'WebSite';
                $this->Title = $Page['page_title'] . " - " . SITE_NAME;
                $this->Description = $Page['page_subtitle'];
                $this->Image = (!empty($Page['page_cover']) ? BASE . "/uploads/{$Page['page_cover']}" : INCLUDE_PATH . '/images/default.jpg');
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'index'):
            //INDEX
            $this->Schema = 'WebSite';
            $this->Title = SITE_NAME . " - " . SITE_SUBNAME;
            $this->Description = SITE_DESC;
            $this->Image = INCLUDE_PATH . '/images/default.jpg';
        elseif ($this->File == 'artigo' && $this->Key == 'amp'):
            //ARTIGO AMP
            $Read->FullRead("SELECT post_title, post_subtitle, post_cover, post_date FROM " . DB_POSTS . " WHERE post_name = :nm AND post_date <= NOW()", "nm={$this->Link}");
            if ($Read->getResult()):
                $Post = $Read->getResult()[0];
                $this->Schema = 'WebSite';
                $this->Title = $Post['post_title'] . " - " . SITE_NAME;
                $this->Description = $Post['post_subtitle'];
                $this->Image = BASE . "/uploads/{$Post['post_cover']}";
                $this->Data = $Post['post_date'];
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'artigo'):
            //ARTIGO 
            $Read->FullRead("SELECT post_title, post_subtitle, post_cover FROM " . DB_POSTS . " WHERE post_name = :nm AND post_date <= NOW()", "nm={$this->Link}");
            if ($Read->getResult()):
                $Post = $Read->getResult()[0];
                $this->Schema = 'WebSite';
                $this->Title = $Post['post_title'] . " - " . SITE_NAME;
                $this->Description = $Post['post_subtitle'];
                $this->Image = BASE . "/uploads/{$Post['post_cover']}";
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'professor'):
            //ARTIGO
            $Read->FullRead("SELECT teacher_name, teacher_resume, teacher_thumb FROM " . DB_TEACHERS . " WHERE teacher_link = :nm", "nm={$this->Link}");
            if ($Read->getResult()):
                $Post = $Read->getResult()[0];
                $this->Schema = 'WebSite';
                $this->Title = $Post['teacher_name'] . " - " . SITE_NAME;
                $this->Description = $Post['teacher_resume'];
                $this->Image = BASE . "/uploads/{$Post['teacher_thumb']}";
            else:
                $this->set404();
            endif;

        elseif ($this->File == 'pesquisa'):
            //PESQUISA
            $this->Schema = 'WebSite';
            $this->Title = "Pesquisa por {$this->Link} em " . SITE_NAME;
            $this->Description = SITE_DESC;
            $this->Image = INCLUDE_PATH . '/images/default.jpg';
        elseif ($this->File == 'conta'):
            //CONTA
            if (ACC_MANAGER):
                $ArrAccountApp = [
                    '' => 'Entrar!',
                    'login' => 'Entrar!',
                    'cadastro' => 'Criar Conta!',
                    'recuperar' => 'Recuperar Senha!',
                    'nova-senha' => 'Criar Nova Senha!',
                    'sair' => 'Sair!',
                    'home' => 'Minha Conta!',
                    'restrito' => 'Acesso Restrito!',
                    'enderecos' => 'Meus Endereços!',
                    'pedidos' => 'Meus Pedidos!',
                    'dados' => 'Atualizar Dados!',
                    'pedido' => 'Pedido #' . str_pad($this->Key, 7, 0, STR_PAD_LEFT)
                ];

                $this->Schema = 'WebSite';
                $this->Title = (!empty($ArrAccountApp[$this->Link]) ? SITE_NAME . " - " . $ArrAccountApp[$this->Link] : 'OPPPSSS!');
                $this->Description = SITE_DESC;
                $this->Image = INCLUDE_PATH . '/images/default.jpg';
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'produto'):
            //PRODUTO 
            $Read->FullRead("SELECT pdt_title, pdt_subtitle, pdt_cover FROM " . DB_PDT . " WHERE pdt_name = :nm", "nm={$this->Link}");
            if ($Read->getResult()):
                $Pdt = $Read->getResult()[0];
                $this->Schema = 'Product';
                $this->Title = $Pdt['pdt_title'] . " - " . SITE_NAME;
                $this->Description = $Pdt['pdt_subtitle'];
                $this->Image = BASE . "/uploads/{$Pdt['pdt_cover']}";
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'produtos'):
            //PRODUTOS
            $Read->FullRead("SELECT cat_title FROM " . DB_PDT_CATS . " WHERE cat_name = :nm", "nm={$this->Link}");
            if ($Read->getResult()):
                $Category = $Read->getResult()[0];
                $this->Schema = 'WebSite';
                $this->Title = $Category['cat_title'] . " - " . SITE_NAME;
                $this->Description = SITE_DESC;
                $this->Image = INCLUDE_PATH . '/images/default.jpg';
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'marca'):
            //MARCAS
            $Read->FullRead("SELECT brand_title FROM " . DB_PDT_BRANDS . " WHERE brand_name = :nm", "nm={$this->Link}");
            if ($Read->getResult()):
                $Brand = $Read->getResult()[0];
                $this->Schema = 'WebSite';
                $this->Title = $Brand['brand_title'] . " - " . SITE_NAME;
                $this->Description = SITE_DESC;
                $this->Image = INCLUDE_PATH . '/images/default.jpg';
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'pedido'):
            //PEDIDO
            $this->Schema = 'WebSite';
            $this->Title = SITE_NAME . " - " . ECOMMERCE_TAG;
            $this->Description = SITE_DESC;
            $this->Image = INCLUDE_PATH . '/images/default.jpg';
        elseif ($this->File == 'imovel'):
            //IMOVEL
            $Read->ExeRead(DB_IMOBI, "WHERE realty_name = :nm", "nm={$this->Link}");
            if ($Read->getResult()):
                $Imobi = $Read->getResult()[0];
                $this->Schema = 'WebSite';
                $this->Title = "{$Imobi['realty_title']} - " . SITE_NAME;
                $this->Description = Check::Chars($Imobi['realty_desc'], 156);
                $this->Image = BASE . "/uploads/{$Imobi['realty_cover']}";
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'imoveis'):
            //IMÓVEIS
            $Link = (!empty($this->Link) && $this->Link != 'indiferente' ? ucwords($this->Link) . " " : '');
            $this->Schema = 'WebSite';
            $this->Title = $Link . "Imóveis - " . SITE_NAME;
            $this->Description = SITE_DESC;
            $this->Image = INCLUDE_PATH . '/images/default.jpg';
        elseif ($this->File == 'filtro'):
            //FILTRO
            $this->Schema = 'WebSite';
            $this->Title = "Filtrar Imóveis - " . SITE_NAME;
            $this->Description = SITE_DESC;
            $this->Image = INCLUDE_PATH . '/images/default.jpg';
        elseif ($this->File == 'campus'):
            switch ($this->Link):
                case '':
                case 'home':
                    if (!empty($_SESSION['userLogin'])):
                        $this->Title = SITE_NAME . " | Minha Conta!";
                    else:
                        $this->Title = SITE_NAME . " | Entrar!";
                    endif;
                    break;
                case 'login':
                    $this->Title = SITE_NAME . " | Entrar!";
                    break;
                case 'senha':
                case 'nova-senha':
                    $this->Title = SITE_NAME . " | Recuperar Senha!";
                    break;
                case 'ativar':
                    $this->Title = SITE_NAME . " | Ativar Conta!";
                    break;
                case 'curso':
                    $Read->FullRead("SELECT course_title FROM " . DB_EAD_COURSES . " WHERE course_name = :name", "name={$this->Key}");
                    $this->Title = ($Read->getResult() ? "Curso {$Read->getResult()[0]['course_title']}" : "Meu Curso") . " - " . SITE_NAME . "!";
                    break;
                case 'tarefa':
                    $Read->FullRead("SELECT class_title FROM " . DB_EAD_CLASSES . " WHERE class_name = :name", "name={$this->Key}");
                    $this->Title = ($Read->getResult() ? "Aula {$Read->getResult()[0]['class_title']}" : "Minha Aula") . " - " . SITE_NAME . "!";
                    break;
                case 'imprimir':
                    $this->Title = "Imprimir Certificado | " . SITE_NAME;
                    break;
                default:
                    $this->Title = SITE_NAME . " | " . SITE_SUBNAME;
            endswitch;

            $this->Schema = 'WebSite';
            $this->Description = SITE_DESC;
            $this->Image = INCLUDE_PATH . '/images/default.jpg';
        elseif ($this->File == 'curso'):
            //CURSO 
            $Read->FullRead("SELECT course_title, course_headline, course_cover FROM " . DB_EAD_COURSES . " WHERE course_name = :nm", "nm={$this->Link}");
            if ($Read->getResult()):
                $Course = $Read->getResult()[0];
                $this->Schema = 'WebSite';
                $this->Title = $Course['course_title'] . " | " . SITE_NAME;
                $this->Description = $Course['course_headline'];
                $this->Image = BASE . "/uploads/{$Course['course_cover']}";
            else:
                $this->set404();
            endif;
        elseif($this->File == 'artigos'):
            $this->Schema = 'WebSite';
            $this->Title =  "Notícias - " . SITE_NAME;
            $this->Description = "Veja as últimas novidades do PROFICAM.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'corpo-docente'):
                $this->Schema = 'WebSite';
                $this->Title =  "Corpo Docente - " . SITE_NAME;
                $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
                $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'corpo-discente'):
            $this->Schema = 'WebSite';
            $this->Title =  "Corpo Discente - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'pos-doutorandos'):
            $this->Schema = 'WebSite';
            $this->Title =  "Pós-Doutorandos - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'egressos'):
            $this->Schema = 'WebSite';
            $this->Title =  "Egressos - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'secretaria'):
            $this->Schema = 'WebSite';
            $this->Title =  "Secretaria - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'coordenacao'):
            $this->Schema = 'WebSite';
            $this->Title =  "Coordenação / Colegiado - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'historico'):
            $this->Schema = 'WebSite';
            $this->Title =  "Histórico - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'linhas-de-pesquisa'):
            $this->Schema = 'WebSite';
            $this->Title =  "Linhas de Pesquisa - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'area-de-concentracao'):
            $this->Schema = 'WebSite';
            $this->Title =  "Área de Concentração - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'estrutura-curricular'):
            $this->Schema = 'WebSite';
            $this->Title =  "Estrutura Currícular - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'disciplinas'):
            $this->Schema = 'WebSite';
            $this->Title =  "Disciplinas - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'integracao-com-a-industria'):
            $this->Schema = 'WebSite';
            $this->Title =  "Integração com a Indústria - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'biblioteca'):
            $this->Schema = 'WebSite';
            $this->Title =  "Biblioteca - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'laboratorios'):
            $this->Schema = 'WebSite';
            $this->Title =  "Laboratórios - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'normas-e-procedimentos'):
            $this->Schema = 'WebSite';
            $this->Title =  "Normas e Procedimentos - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'cronograma'):
            $this->Schema = 'WebSite';
            $this->Title =  "Cronograma - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'quadro-de-horarios'):
            $this->Schema = 'WebSite';
            $this->Title =  "Quadro de Horários - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'formularios'):
            $this->Schema = 'WebSite';
            $this->Title =  "Formulários - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'materiais'):
            $this->Schema = 'WebSite';
            $this->Title =  "Materiais - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'processo-seletivo'):
            $this->Schema = 'WebSite';
            $this->Title =  "Processo Seletivo - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'processo-seletivo-anteriores'):
            $this->Schema = 'WebSite';
            $this->Title =  "Processos Seletivos Anteriores - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'inscricao'):
            $this->Schema = 'WebSite';
            $this->Title =  "Inscrição - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'defesas'):
            $this->Schema = 'WebSite';
            $this->Title =  "Defesas - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'perguntas-frequentes'):
            $this->Schema = 'WebSite';
            $this->Title =  "Perguntas Frequentes - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';
        elseif($this->File == 'fale-conosco'):
            $this->Schema = 'WebSite';
            $this->Title =  "Fale Conosco - " . SITE_NAME;
            $this->Description = "Nossos docentes possui qualificação e experiência comprovada para te ensinar as melhores e atuais tecnologias do mercado.";
            $this->Image =  INCLUDE_PATH . '/images/default.jpg';


        else:
            //404
            $this->set404();
        endif;
    }

    private function set404() {
        $this->Schema = 'WebSite';
        $this->Title = "Oppsss, nada encontrado! - " . SITE_NAME;
        $this->Description = SITE_DESC;
        $this->Image = INCLUDE_PATH . '/images/default.jpg';
    }

}
