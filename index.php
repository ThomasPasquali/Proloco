<?php
  define('DEF_LANG', 'en');
  
  $lang = NULL;
  $dir = __DIR__;

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
      preg_match_all('/(\W|^)([a-z]{2})([^a-z]|$)/six', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $m, PREG_PATTERN_ORDER);
      $user_langs = $m[2];

      for($i = 0; $i < count($user_langs); $i += 2)
        if(file_exists($dir.DIRECTORY_SEPARATOR.'langs'.DIRECTORY_SEPARATOR.$user_langs[$i].'.json')) {
          $lang = file_get_contents($dir.DIRECTORY_SEPARATOR.'langs'.DIRECTORY_SEPARATOR.$user_langs[$i].'.json');
          setcookie('lang', $user_langs[$i]);
          break;
        }
    }

  }

  //Se nemmeno la lingua del browser c'e' uso quella di default
  if(is_null($lang)) $lang = file_get_contents($dir.DIRECTORY_SEPARATOR.'langs'.DIRECTORY_SEPARATOR.DEF_LANG.'.json');
  
  $lang = json_decode($lang, TRUE);
  
  //DB zone
  include_once 'lib/db.php';
  if(DB::check(['search'], $_REQUEST)) {
    ini_set('display_errors', 0);
    try {
      $db = new DB($dir.'/../db.ini');
    } catch (Exception $e) {
      header('Content-type: text/txt;');
      echo
      'Specificare il file ini per il database in: $dir.\'/../db.ini
  Esempio:
  db = mysql
  host = 127.0.0.1
  port = 3306
  dbName = db
  user = root
  pass = root';
      exit();
    }
    

    

    $types = explode(',', $_REQUEST['search']);
    $results = $db->ql("SELECT * FROM strutture WHERE Tipo IN (?".str_repeat(',?', count($types)-1).')', $types);

}?>
<html>
<head>
    <title>Proloco Canale d'Agordo</title>
    <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
    <script src="bootstrap-4.3.1/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1/js/jquery-3.4.1.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>
    <script src="js/jssor.slider-27.5.0.min.js" type="text/javascript"></script>
    <script src="js/slider.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/slider.css">
</head>
<body>
    <div id="background-img">
        <nav id="menu">
            <div id="title">
                <img src="imgs/logo.jpg" onclick="show('home');">
                <h1 onclick="show('home');">Proloco<br>Canale d'Agordo</h1>
            </div>
            <ul class="nav justify-content-end">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false"><?= $lang['menu_alloggi'] ?></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="?search=Garn%C3%AC,B%26B">Garn&igrave;-B&amp;B</a>
                        <a class="dropdown-item" href="?search=Albergo,Hotel"><?= $lang['menu_alloggi_hotel'] ?></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="files/appartamenti.pdf" target="_blank"><?= $lang['menu_alloggi_appartamenti'] ?></a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false"><?= $lang['menu_cosa_vedere'] ?></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="show('v-d-g');">Valle di Gares - Biotopo</a>
                        <a class="dropdown-item" href="#" onclick="show('v-d-b');">Valle del Biois</a>
                        <a class="dropdown-item" href="#" onclick="show('via-crucis');">Via Crucis Papa Luciani</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="?search=Negozio"><?= $lang['menu_cosa_vedere_negozi'] ?></a>
                        <a class="dropdown-item" href="?search=Locale"><?= $lang['menu_cosa_vedere_locali'] ?></a>
                        <a class="dropdown-item" href="?search=Mostra,Museo"><?= $lang['menu_cosa_vedere_mostre_musei'] ?></a>
                        <a class="dropdown-item" href="?search=Biblioteca"><?= $lang['menu_cosa_vedere_biblioteche'] ?></a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false"><?= $lang['menu_eventi'] ?></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="http://web4.deskline.net/valledelbiois/it/event/list" target="_blank"><?= $lang['menu_cosa_vedere_eventi_in_zona'] ?></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="http://www.casparetha.it" target="_blank">Casparetha</a>
                        <a class="dropdown-item" href="http://www.zinghenesta.it" target="_blank">Zinghenesta</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="show('come-arrivare');"><?= $lang['menu_come_arrivare'] ?></a>
                </li>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false"><?= $lang['menu_lang'] ?></a>
                  <div class="dropdown-menu">
                    <?php
                      $dir = new DirectoryIterator($dir.'/langs');
                      foreach ($dir as $fileinfo)
                        if (!$fileinfo->isDot()){
                          $l = explode('.', $fileinfo->getFilename())[0];
                          echo '<a class="dropdown-item" href="?lang='.$l.'">'.$l.'</a>';
                        }
                    ?>
                  </div>
                </li>

            </ul>
        </nav>
        <div id="content-wrap">
            <div id="content">

                <div id="home">
                  <h1><?= $lang['home_title'] ?></h1>
                  <p><?= $lang['home_p1'] ?></p>
                  <p><?= $lang['home_p2'] ?></p>
                  <p><?= $lang['home_p3'] ?></p>

                  <!-- #region Jssor Slider Start -->
                  <div id="jssor_home" style="position:relative;margin:0 auto;top:0px;left:0px;width:650px;height:380px;overflow:hidden;visibility:hidden;">
                    <!-- Loading Screen -->
                    <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                        <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="imgs/slider/spin.svg" />
                    </div>
                    <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:650px;height:380px;overflow:hidden;">
                        <div><img data-u="image" src="imgs/background.jpg" /></div>
                    </div>
                    <!-- Bullet Navigator -->
                    <div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                        <div data-u="prototype" class="i" style="width:16px;height:16px;">
                            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                            </svg>
                        </div>
                    </div>
                    <!-- Arrow Navigator -->
                    <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                        <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                            <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
                        </svg>
                    </div>
                    <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                        <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                            <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
                        </svg>
                    </div>
                  </div>
                  <!-- #endregion Jssor Slider End -->

                </div>

          <div id="v-d-g" class="hidden">
            <h1>Valle di Gares</h1>
            <p><?= $lang['valle_di_gares_content_p1'] ?></p>
            <p><?= $lang['valle_di_gares_content_p2'] ?></p>
            <p><?= $lang['valle_di_gares_content_p3'] ?></p>
            <p><?= $lang['valle_di_gares_content_p4'] ?></p>
            
            <h1>Biotopo</h1>
            <p><?= $lang['biotopo_content_p1'] ?></p>
            <p><?= $lang['biotopo_content_p2'] ?></p>

            <!-- #region Jssor Slider Start -->
            <div id="jssor_v_d_g" style="position:relative;margin:0 auto;top:0px;left:0px;width:650px;height:380px;overflow:hidden;visibility:hidden;">
              <!-- Loading Screen -->
              <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                  <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="imgs/slider/spin.svg" />
              </div>
              <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:650px;height:380px;overflow:hidden;">
                  <div><img data-u="image" src="imgs/slider/aurora.jpg" /></div>
                  <div><img data-u="image" src="imgs/slider/universo.jpg" /></div>
              </div>
              <!-- Bullet Navigator -->
              <div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                  <div data-u="prototype" class="i" style="width:16px;height:16px;">
                      <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                          <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                      </svg>
                  </div>
              </div>
              <!-- Arrow Navigator -->
              <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                  <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                      <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
                  </svg>
              </div>
              <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                  <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                      <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
                  </svg>
              </div>
            </div>
            <!-- #endregion Jssor Slider End -->
          </div>

          <div id="v-d-b" class="hidden">
            <h1>Valle del Biois</h1>
            <p><?= $lang['valle_del_biois_content_p1'] ?></p>
            <p><?= $lang['valle_del_biois_content_p2'] ?></p>
            <p><?= $lang['valle_del_biois_content_p3'] ?></p>

            <!-- #region Jssor Slider Start -->
            <div id="jssor_v_d_b" style="position:relative;margin:0 auto;top:0px;left:0px;width:650px;height:380px;overflow:hidden;visibility:hidden;">
              <!-- Loading Screen -->
              <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                  <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="imgs/slider/spin.svg" />
              </div>
              <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:650px;height:380px;overflow:hidden;">
                  <div><img data-u="image" src="imgs/slider/aurora.jpg" /></div>
                  <div><img data-u="image" src="imgs/slider/universo.jpg" /></div>
              </div>
              <!-- Bullet Navigator -->
              <div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                  <div data-u="prototype" class="i" style="width:16px;height:16px;">
                      <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                          <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                      </svg>
                  </div>
              </div>
              <!-- Arrow Navigator -->
              <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                  <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                      <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
                  </svg>
              </div>
              <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                  <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                      <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
                  </svg>
              </div>
            </div>
            <!-- #endregion Jssor Slider End -->
          </div>
          
          <div id="via-crucis" class="hidden">
          	<h1>Via Crucis Papa Luciani</h1>
            <p><?= $lang['via_crucis_p1'] ?></p>
            <p><?= $lang['via_crucis_p2'] ?></p>
          </div>

          <div id="search" class="hidden">
            <!-- #region Ricerca -->
            <div class="resultBox">
            <?php
            if(count($results) == 0) echo '<h1 style="color:white;">'.$lang['nessun_risultato'].'</h1>';

            foreach($results as $res){ ?>
              
              <div class="result">
                <h2><?= $res['Nome'] ?></h2>
                <?= $res['Foto']?"<img src=\"imgs/dbImgs/$res[Foto]\">":'' ?>
                <?= $res['Descrizione']?"<p class=\"descrizione\">".$res['Descrizione']."</p>":'' ?>

                <?php if($res['Sito']||$res['Maps']||$res['Email']) { ?>
                <div class="inline-grid">
                  <?= $res['Sito']?"<p class=\"sito\"><a href=\"$res[Sito]\">".$lang['sito']."</a></p>":'' ?>
                  <?= $res['Maps']?"<p class=\"mappa\"><a href=\"$res[Maps]\">".$lang['come_arrivarci']."</a></p>":'' ?>
                  <?= $res['Email']?"<p class=\"mappa\"><a href=\"mailto:$res[Email]\">".$lang['email']."</a></p>":'' ?>
                </div>
                <?php } ?>
                  
              </div>
            <?php } ?>
            </div>
            <!-- #endregion Ricerca End -->
          </div>

            <div id="come-arrivare" class="hidden">

              <div id="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1946.9631544335696!2d11.913474742799066!3d46.36102078420485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4778453599d4a887%3A0x2c95c73b5c456247!2sMuseo%20Albino%20Luciani%20Canale%20d&#39;Agordo!5e0!3m2!1sit!2sit!4v1569776504349!5m2!1sit!2sit"></iframe>
              </div>

              <div id="link_trasporti">
                <h2 data-toggle="tooltip" data-placement="bottom" title="<?= $lang['provincia_di_Belluno'] ?>">
                  <a href="https://dolomitibus.it/files/orari/invernali/extra/Agordino/Linea2_I.pdf" target="_blank">
                    <?= $lang['orari_dolomitibus'] ?>
                  </a>
                </h2>

                <h2 data-toggle="tooltip" data-placement="bottom" title="<?= $lang['fino_a_Belluno'] ?>">
                  <a href="https://www.trenitalia.com" target="_blank">
                    <?= $lang['orari_trenitalia'] ?>
                  </a>
                </h2>

                <h2><a href="files/taxi.pdf" target="_blank"><?= $lang['trasporti_privati'] ?></a></h2>
              </div>

            </div>

				  </div>
          </div>  

          <footer id="footer">
              <div class="container" style="margin-top:auto;margin-bottom:auto;">
                <div class="row">
                  <div class="col-sm">
                    <h4><?= $lang['footer_dove_trovarci'] ?>:<img src="imgs/placeholder.svg" class="icon"></h4>
                    <p><a href="https://goo.gl/maps/n3VBYFqa3E56UAcn8" target="_blank">Piazza Papa Luciani, 4</a></p>
                    <p><a href="https://goo.gl/maps/n3VBYFqa3E56UAcn8" target="_blank">Canale d'Agordo (BL) - 32020</a></p>
                  </div>
                  <div class="col-sm">
                    <h4><?= $lang['footer_come_contattarci'] ?>:</h4>
                    <p><img src="imgs/email.svg" class="icon"><a href="mailto: info@prolococanale.it" target="_blank">info@prolococanale.it</a></p>
                    <p><img src="imgs/telephone.svg" class="icon"><a href="tel: 0437 1948030" target="_blank">0437 1948030</a></p>
                  </div>
                  <div class="col-sm">
                    <h4><?= $lang['footer_orari_ufficio'] ?>:<img src="imgs/info.svg" class="icon"></h4>
                    <p><?= $lang['footer_sabato'] ?><br>9:00-12:00 e 15:00-18:00</p>
                    <p><?= $lang['footer_venerdi'] ?>, <?= $lang['footer_domenica_e_festivi'] ?>:<br>9.00-12.00</p>
                  </div>
                  <div class="col-sm">
                    <h4>Link:</h4>
                    <p><a href="https://www.arpa.veneto.it/previsioni/it/html/meteo_dolomiti.php" target="_blank"><?= $lang['footer_meteo'] ?></a></p>
                    <p><a href="https://www.musal.it/webcam/" target="_blank">Webcam</a></p>
                    <a href="https://www.facebook.com/Pro-Loco-Canale-dAgordo-653270708142524" target="_blank"><img src="imgs/facebook.svg" class="icon"></a>
                  </div>
                </div>
              </div>
            </footer>
      </div>  
    </div>
    <?= isset($results)?'<script>show(\'search\');</script>':'' ?>
    <script src="js/slider.js"></script>
</body>
</html>