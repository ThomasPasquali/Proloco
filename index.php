<?php
    define('DEF_LANG', 'IT');

    $lang = NULL;
    $dir = str_replace('\\','/',__DIR__);

    /*TODO uncomment for language control
    //Se settato parametro lang
    if(isset($_REQUEST['lang']) && file_exists($dir.DIRECTORY_SEPARATOR.'langs'.DIRECTORY_SEPARATOR.$_REQUEST['lang'].'.json')) {
    $lang = file_get_contents($dir.DIRECTORY_SEPARATOR.'langs'.DIRECTORY_SEPARATOR.$_REQUEST['lang'].'.json');
    setcookie('lang', $_REQUEST['lang']);
    }

    //Cookie lang check
    if(!$lang && isset($_COOKIE['lang']) && file_exists($dir.DIRECTORY_SEPARATOR.'langs'.DIRECTORY_SEPARATOR.$_COOKIE['lang'].'.json'))
    $lang = file_get_contents($dir.DIRECTORY_SEPARATOR.'langs'.DIRECTORY_SEPARATOR.$_COOKIE['lang'].'.json');

    else {

    //Se lang non è ancora stato inizializzato uso il lang del browser
    if(!$lang) {
        $m = [];
        preg_match_all('/(\W|^)([a-z]{2})([^a-z]|$)/six', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $m, PREG_PATTERN_ORDER);
        $user_langs = $m[2];

        for($i = 0; $i < count($user_langs); $i += 2)
        if(file_exists($dir.DIRECTORY_SEPARATOR.'langs'.DIRECTORY_SEPARATOR.$user_langs[$i].'.json')) {
            $lang = file_get_contents($dir.DIRECTORY_SEPARATOR.'langs'.DIRECTORY_SEPARATOR.$user_langs[$i].'.json');
            setcookie('lang', $user_langs[$i]);
            break;
        }
    }

    }*/

    //Se nemmeno la lingua del browser c'e' uso quella di default
    if(is_null($lang)) $lang = file_get_contents($dir.DIRECTORY_SEPARATOR.'langs'.DIRECTORY_SEPARATOR.DEF_LANG.'.json');

    $lang = json_decode($lang, TRUE);

    //DB zone
    include_once 'lib/db.php';
    ini_set('display_errors', 0);
    try {
        $db = new DB($dir.'/../db.ini');
    } catch (Exception $e) {
        header('Content-type: text/txt;');
        echo 'Specificare il file ini';
        exit();
    }

    //Access log
    $db->dml("INSERT INTO access_log (IP) VALUES ('$_SERVER[REMOTE_ADDR]')");

    if(DB::check(['search'], $_REQUEST)) {
        //Ricerche
        $types = explode(',', $_REQUEST['search']);
        $results = $db->ql("SELECT * FROM strutture WHERE Tipo IN (?".str_repeat(',?', count($types)-1).')', $types);
    }

    $slider_count = 0;
    function createSlider($dirname) {
        $id = 'slider_'.$GLOBALS['slider_count']++; ?>
        <div id="<?= $id ?>" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php $i = 1;
                    while(file_exists("imgs/$dirname/$i.jpg"))
                        echo '<li data-target="#'.$id.'" data-slide-to="'.($i-1).'"'.(($i++)==0?' class="active"':'').'></li>';
                ?>
            </ol>
            <div class="carousel-inner">
                <?php $i = 1;
                    while(file_exists("imgs/$dirname/$i.jpg"))
                        echo '<div class="carousel-item'.($i==1?' active':'').'"><img data-src="imgs/'.$dirname.'/'.($i++).'.jpg" class="d-block w-100"></div>';
                ?>
            </div>
            <a class="carousel-control-prev" href="#<?= $id ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#<?= $id ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div> <?php
    }

?>

<html>

    <head>
        <title>Proloco Canale d'Agordo</title>
        
        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
 
        <!-- Bootsrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- CSS & JS -->
        <link rel="stylesheet" href="css/index.css">
        <script src="js/index.js"></script>
        
    </head>

    <body>

        <!-- BG IMG -->
        <div id="background-img">

            <!-- TOP BAR -->
            <nav id="menu">
                <div id="title">
                    <img src="imgs/logo.jpg" onclick="show('estate-inverno');">
                    <h1 onclick="show('estate-inverno');">Canale d'Agordo<br>Belluno<br>Dolomiti</h1>
                </div>

                <ul class="nav justify-content-end">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false"><?= $lang['menu_alloggi'] ?></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="?search=Garn%C3%AC,B%26B">Garn&igrave; e B&amp;B</a>
                            <a class="dropdown-item" href="?search=Albergo,Hotel"><?= $lang['menu_alloggi_hotel'] ?></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="files/appartamenti_estate.pdf" target="_blank"><?= $lang['menu_alloggi_appartamenti_estate'] ?></a>
                            <a class="dropdown-item" href="files/appartamenti_inverno.pdf" target="_blank"><?= $lang['menu_alloggi_appartamenti_inverno'] ?></a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false"><?= $lang['menu_cosa_vedere'] ?></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="show('paese');"><?= $lang['menu_cosa_vedere_il_paese'] ?></a>
                            <a class="dropdown-item" href="#" onclick="show('v-d-g');"><?= $lang['menu_cosa_vedere_valle_di_gares'] ?></a>
                            <a class="dropdown-item" href="#" onclick="show('v-d-b');"><?= $lang['menu_cosa_vedere_valle_del_biois'] ?></a>
                            <a class="dropdown-item" href="#" onclick="show('via-crucis');"><?= $lang['menu_cosa_vedere_via_crucis'] ?></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="?search=Mostra,Museo"><?= $lang['menu_cosa_vedere_mostre_musei'] ?></a>
                            <a class="dropdown-item" href="?search=Chiesa"><?= $lang['menu_cosa_vedere_chiese'] ?></a>
                            <a class="dropdown-item" href="?search=Negozio"><?= $lang['menu_cosa_vedere_negozi'] ?></a>
                            <a class="dropdown-item" href="?search=Locale"><?= $lang['menu_cosa_vedere_locali'] ?></a>
                            <a class="dropdown-item" href="?search=Biblioteca"><?= $lang['menu_cosa_vedere_biblioteche'] ?></a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false"><?= $lang['menu_eventi'] ?></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="show('eventi-canale');"><?= $lang['menu_eventi_a_canale'] ?></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="http://web4.deskline.net/valledelbiois/it/event/list" target="_blank"><?= $lang['menu_eventi_in_zona'] ?></a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="show('come-arrivare');"><?= $lang['menu_come_arrivare'] ?></a>
                    </li>

                    <!-- TODO delete for language selection
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false"><?= $lang['menu_lang'] ?></a>
                    <div class="dropdown-menu">
                        <?php
                        /*$dir = new DirectoryIterator($dir.'/langs');
                        foreach ($dir as $fileinfo)
                            if (!$fileinfo->isDot()){
                            $l = explode('.', $fileinfo->getFilename())[0];
                            echo '<a class="dropdown-item" href="?lang='.$l.'">'.$l.'</a>';
                            }*/
                        ?>
                    </div>
                    </li> -->

                </ul>
            </nav>
            <!-- END TOP BAR -->
            
            <div id="content-wrap">
                <!-- CONTENTS -->
                <div id="content">
                    
                    <!-- PAGINA PRINCIPALE -->
                    <div id="estate-inverno">
                        <div id="estate" onclick="estate();">
                            <img src="imgs/Home/Estate.jpg" class="image">
                            <div class="middle hover-text"><?= $lang['home_estate']?></div>
                        </div>

                        <div id="inverno" onclick="inverno();">
                            <img src="imgs/Home/Inverno.jpg" class="image">
                            <div class="middle hover-text"><?= $lang['home_inverno']?></div>
                        </div>
                    </div>
                    <!-- END PAGINA PRINCIPALE -->

                    <!-- PAGINA ESTATE -->
                    <div id="home-estate" class="hidden subpage home">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <h1 style="text-decoration: underline;"><?= $lang['estate_titolo_sx'] ?></h1>
                                    <?php
                                    $i = 1;
                                    while(isset($lang['estate_sub_sx_'.$i])) {
                                        echo '<h2 class="collapsible">'.$lang['estate_sub_sx_'.($i)].'</h2>';
                                        echo '<div class="collapsible-content"><p>'.($lang['estate_cont_sx_'.($i++)]??'').'</p></div>';
                                    }
                                    ?>
                                </div>

                                <div class="col">
                                    <h1 style="text-decoration: underline;"><?= $lang['estate_titolo_dx'] ?></h1>
                                    <?php
                                    $i = 1;
                                    while(isset($lang['estate_sub_dx_'.$i])) {
                                        echo '<h2 class="collapsible">'.$lang['estate_sub_dx_'.($i)].'</h2>';
                                        echo '<div class="collapsible-content"><p>'.($lang['estate_cont_dx_'.($i++)]??'').'</p></div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="row"><?php createSlider('Home/Estate'); ?></div>
                        </div>
                    </div>
                    <!-- END PAGINA ESTATE -->

                    <!-- PAGINA INVERNO -->
                    <div id="home-inverno" class="hidden subpage home">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <h1 style="text-decoration: underline;"><?= $lang['inverno_titolo_sx'] ?></h1>
                                    <?php
                                    $i = 1;
                                    while(isset($lang['inverno_sub_sx_'.$i])) {
                                        echo '<h2 class="collapsible">'.$lang['inverno_sub_sx_'.($i)].'</h2>';
                                        echo '<div class="collapsible-content"><p>'.($lang['inverno_cont_sx_'.($i++)]??'').'</p></div>';
                                    }
                                    ?>
                                </div>

                                <div class="col">
                                    <h1 style="text-decoration: underline;"><?= $lang['inverno_titolo_dx'] ?></h1>
                                    <?php
                                    $i = 1;
                                    while(isset($lang['inverno_sub_dx_'.$i])) {
                                        echo '<h2 class="collapsible">'.$lang['inverno_sub_dx_'.($i)].'</h2>';
                                        echo '<div class="collapsible-content"><p>'.($lang['inverno_cont_dx_'.($i++)]??'').'</p></div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="row"><?php createSlider('Home/Inverno'); ?></div>
                        </div>
                    </div>
                    <!-- END PAGINA INVERNO -->

                    <!-- PAGINA VALLE DI GARES -->
                    <div id="v-d-g" class="hidden subpage">
                        <h1>Valle di Gares</h1>
                        <p><?= $lang['valle_di_gares_content_p1'] ?></p>
                        <p><?= $lang['valle_di_gares_content_p2'] ?></p>
                        <p><?= $lang['valle_di_gares_content_p3'] ?></p>
                        <p><?= $lang['valle_di_gares_content_p4'] ?></p>

                        <h1>Le cascate</h1>
                        <p><?= $lang['cascate_content_p1'] ?></p>
                        <p><?= $lang['cascate_content_p2'] ?></p>
                        
                        <h1>Biotopo</h1>
                        <p><?= $lang['biotopo_content_p1'] ?></p>
                        <p><?= $lang['biotopo_content_p2'] ?></p>

                        <?php createSlider('ValleDiGares'); ?>
                    </div>
                    <!-- END PAGINA VALLE DI GARES -->

                    <!-- PAGINA VALLE DEL BIOIS -->
                    <div id="v-d-b" class="hidden subpage">
                        <h1>Valle del Biois</h1>
                        <p><?= $lang['valle_del_biois_content_p1'] ?></p>
                        <p><?= $lang['valle_del_biois_content_p2'] ?></p>
                        <p><?= $lang['valle_del_biois_content_p3'] ?></p>
                        
                        <?php createSlider('ValleDelBiois'); ?>
                    </div>
                    <!-- END PAGINA VALLE DEL BIOIS -->
            
                    <!-- PAGINA VIA CRUCIS -->
                    <div id="via-crucis" class="hidden subpage">
                        <h1>Via Crucis</h1>
                        <p><?= $lang['via_crucis_p1'] ?></p>
                        <p><?= $lang['via_crucis_p2'] ?></p>
                        <?php createSlider('ViaCrucis'); ?>
                    </div>
                    <!-- END PAGINA VIA CRUCIS -->

                    <!-- PAGINA EVENTI -->
                    <div id="eventi-canale" class="hidden subpage">
                        <div id="eventi">
                            <div class="evento">
                                <img data-src="imgs/Eventi/Casparetha.jpg"/>
                                <h1><?= $lang['eventi_casparetha'] ?></h1>
                                <p><?= $lang['eventi_descrizione_casparetha'] ?></p>
                            </div>
                        
                            <div class="evento">
                                <img data-src="imgs/Eventi/Zinghenesta.jpg"/>
                                <h1><?= $lang['eventi_zinghenesta'] ?></h1>
                                <p><?= $lang['eventi_descrizione_zinghenesta'] ?></p>
                            </div>              	
                            
                            <div class="evento">
                                <img data-src="imgs/Eventi/Cacciatori.jpg"/>
                                <h1><?= $lang['eventi_festa_del_cacciatore'] ?></h1>
                                <p><?= $lang['eventi_descrizione_festa_del_cacciatore'] ?></p>
                            </div>
                            
                            <div class="evento">
                                <img data-src="imgs/Eventi/SanGiovanni.jpg"/>
                                <h1><?= $lang['eventi_san_giovanni'] ?></h1>
                                <p><?= $lang['eventi_descrizione_san_giovanni'] ?></p>
                            </div>
                            
                            <div class="evento">
                                <img data-src="imgs/Eventi/Trator.jpg"/>
                                <h1><?= $lang['eventi_di_del_trator'] ?></h1>
                                <p><?= $lang['eventi_descrizione_di_del_trator'] ?></p>
                            </div>
                            
                            <div class="evento">
                                <img data-src="imgs/Eventi/Feder.jpg"/>
                                <h1><?= $lang['eventi_sagra_feder'] ?></h1>
                                <p><?= $lang['eventi_descrizione_sagra_feder'] ?></p>
                            </div>
                            
                            <div class="evento">
                                <img data-src="imgs/Eventi/Fregona.jpg"/>
                                <h1><?= $lang['eventi_sagra_fregona'] ?></h1>
                                <p><?= $lang['eventi_descrizione_sagra_fregona'] ?></p>
                            </div>

                            <div class="evento">
                                <img data-src="imgs/Eventi/Gares.jpg"/>
                                <h1><?= $lang['eventi_sagra_gares'] ?></h1>
                                <p><?= $lang['eventi_descrizione_sagra_gares'] ?></p>
                            </div>
                            
                            <div class="evento">
                                <img data-src="imgs/Eventi/Mercatini.jpg"/>
                                <h1><?= $lang['eventi_mercatini'] ?></h1>
                                <p><?= $lang['eventi_descrizione_mercatini'] ?></p>
                            </div>

			                <div class="evento">
                                <img data-src="imgs/Eventi/Papa.jpg"/>
                                <h1><?= $lang['eventi_papa'] ?></h1>
                                <p><?= $lang['eventi_descrizione_papa'] ?></p>
                            </div>

                            <div class="evento">
                                <img data-src="https://www.prolocobellunesi.it/wp-content/uploads/2020/12/PRESEPE_CANALE_AGORDO-2020_Pagina_1-2048x1447.jpg"/>
                                <h1><?= $lang['eventi_presepi'] ?></h1>
                                <p><?= $lang['eventi_descrizione_presepi'] ?></p>
                            </div>
                            
                        </div>
                    </div>
                    <!-- END PAGINA EVENTI -->
                    
                    <!-- PAGINA PAESE -->
                    <div id="paese" class="hidden subpage">
                        <h1><?= $lang['paese_title'] ?></h1>
                        <?php 
                            $i = 1;
                            while(isset($lang["paese_p$i"]))
                                echo '<p>'.$lang['paese_p'.($i++)].'</p>';
                            createSlider('Paese');
                        ?>
                    </div>
                    <!-- END PAGINA PAESE -->

                    <!-- RICERCA -->
                    <div id="search" class="hidden">
                        <div class="resultBox">

                        <?php
                        if(count($results) == 0) echo '<h1 style="color:white;">'.$lang['nessun_risultato'].'</h1>';

                        foreach($results as $res){ ?>
                        <div class="result">
                            <h2><?= $res['Nome'] ?></h2>
                            <?= $res['Foto']?"<img src=\"imgs/dbImgs/$res[Foto]\">":'' ?>
                            <?= $res['Descrizione']?"<p class=\"descrizione justifyed\">".$res['Descrizione']."</p>":'' ?>

                            <?php if($res['Sito']||$res['Maps']||$res['Email']||$res['Telefono']) { ?>
                                    <div class="inline-grid">
                                    <?= $res['Sito']?"<p class=\"sito\"><a href=\"$res[Sito]\" target=\"_blank\">".$lang['sito']."</a></p>":'' ?>
                                    <?= $res['Maps']?"<p class=\"mappa\"><a href=\"$res[Maps]\" target=\"_blank\">".$lang['come_arrivarci']."</a></p>":'' ?>
                                    <?= $res['Email']?"<p class=\"email\"><a href=\"mailto: $res[Email]\">".$lang['email']."</a></p>":'' ?>
                                    <?= $res['Telefono']?"<p class=\"telefono\"><a href=\"tel: $res[Telefono]\">".$lang['telefono'].$res['Telefono']."</a></p>":'' ?>
                                    </div> <?php
                                } ?>
                            
                        </div> <?php 
                        } ?>
                        
                        </div>
                    </div>
                    <!-- END RICERCA -->

                    <!-- COME ARRIVARE -->
                    <div id="come-arrivare" class="hidden">

                        <div id="map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1946.9631544335696!2d11.913474742799066!3d46.36102078420485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4778453599d4a887%3A0x2c95c73b5c456247!2sMuseo%20Albino%20Luciani%20Canale%20d&#39;Agordo!5e0!3m2!1sit!2sit!4v1569776504349!5m2!1sit!2sit"></iframe>
                        </div>

                        <div id="link_trasporti">
                            <h2 data-toggle="tooltip" data-placement="bottom" title="<?= $lang['provincia_di_Belluno'] ?>">
                            <a href="https://dolomitibus.it/it/linee-extraurbane-invernali-coronavirus" target="_blank">
                                <?= $lang['orari_dolomitibus'] ?>
                            </a>
                            </h2>

                            <h2 data-toggle="tooltip" data-placement="bottom" title="<?= $lang['fino_a_Belluno'] ?>">
                            <a href="https://www.trenitalia.com" target="_blank">
                                <?= $lang['orari_trenitalia'] ?>
                            </a>
                            </h2>

                            <h2 data-toggle="tooltip" data-placement="bottom" title="<?= $lang['da_per_venezia'] ?>">
                            <a href="files/brusutti.pdf" target="_blank">
                                <?= $lang['brusutti'] ?>
                            </a>
                            </h2>

                            <h2><a href="files/taxi.pdf" target="_blank"><?= $lang['trasporti_privati'] ?></a></h2>
                        </div>

                    </div>
                    <!-- END COME ARRIVARE -->

                </div>
                <!-- END CONTENTS -->
            </div>

        </div>
        <!-- END BG IMG -->

        <footer id="footer" >
            <div class="container ">
                <div class="row">
                  <div class="col">
                    <h4><?= $lang['footer_dove_trovarci'] ?>:<img src="imgs/placeholder.svg" class="icon"></h4>
                    <p><a href="https://goo.gl/maps/n3VBYFqa3E56UAcn8" target="_blank">Piazza Papa Luciani, 4</a></p>
                    <p><a href="https://goo.gl/maps/n3VBYFqa3E56UAcn8" target="_blank">Canale d'Agordo (BL) - 32020</a></p>
                    <p>P.IVA 00838420255</p>
                    <p>C.F. 80009980253</p>
                  </div>
                  
                  <div class="col">
                    <h4><?= $lang['footer_orari_ufficio_titolo'] ?>:<img src="imgs/info.svg" class="icon"></h4>
                    <p><?= $lang['footer_orari_ufficio'] ?></p>
                  </div>

                  <div class="col">
                    <h4><?= $lang['footer_come_contattarci'] ?>:</h4>
                    <p><img src="imgs/telephone.svg" class="icon"><a href="tel: 0437 1948030" target="_blank">+39 0437 1948030</a></p>
                    <p><img src="imgs/email.svg" class="icon"><a href="mailto: info@prolococanale.it" target="_blank">info@prolococanale.it</a></p>
                    <p>Facebook: <a href="https://it-it.facebook.com/pages/category/Community/Pro-Loco-Canale-dAgordo-653270708142524/" target="_blank">Proloco Canale d'Agordo</a></p>
                  </div>
                </div>

                <p style="font-size: 13px;">Made By Thomas P.</p>
            </div>
        </footer>

        <?= (isset($results))?'<script>show(\'search\');</script>':'' ?>
    </body>
</html>