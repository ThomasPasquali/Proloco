<?php
  define('DEF_LANG', 'IT');
  
  $lang = NULL;
  $dir = __DIR__;

  /*TODO uncommento for language control
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
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div id="background-img">
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
                        <a class="dropdown-item" href="files/appartamenti.pdf" target="_blank"><?= $lang['menu_alloggi_appartamenti'] ?></a>
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
                        <a class="dropdown-item" href="?search=Negozio"><?= $lang['menu_cosa_vedere_negozi'] ?></a>
                        <a class="dropdown-item" href="?search=Locale"><?= $lang['menu_cosa_vedere_locali'] ?></a>
                        <a class="dropdown-item" href="?search=Mostra,Museo"><?= $lang['menu_cosa_vedere_mostre_musei'] ?></a>
                        <a class="dropdown-item" href="?search=Biblioteca"><?= $lang['menu_cosa_vedere_biblioteche'] ?></a>
                        <a class="dropdown-item" href="#" onclick="show('chiese');"><?= $lang['menu_cosa_vedere_chiese'] ?></a>
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
                </li>
                -->

            </ul>
        </nav>
        <div id="content-wrap">
            <div id="content">

            <div id="home-estate" class="hidden subpage home">
              <div class="container">
                <div class="row">
                  <div class="col">
                    <h1><?= $lang['estate_titolo_sx'] ?></h1>
                    <?php
                    $i = 1;
                    while(isset($lang['estate_sub_sx_'.$i])) {
                      echo '<h2>'.$lang['estate_sub_sx_'.($i)].'</h2>';
                      echo '<p>'.($lang['estate_cont_sx_'.($i++)]??'').'</p>';
                    }
                    ?>
                  </div>

                  <div class="col">
                    <h1><?= $lang['estate_titolo_dx'] ?></h1>
                    <?php
                    $i = 1;
                    while(isset($lang['estate_sub_dx_'.$i])) {
                      echo '<h2>'.$lang['estate_sub_dx_'.($i)].'</h2>';
                      echo '<p>'.($lang['estate_cont_dx_'.($i++)]??'').'</p>';
                    }
                    ?>
                  </div>
                </div>
                
              </div>
				
				      <!-- #region Jssor Slider Start -->
	            <div id="jssor_estate" style="position:relative;margin:0 auto;top:0px;left:0px;width:650px;height:380px;overflow:hidden;visibility:hidden;">
	              <!-- Loading Screen -->
	              <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
	                  <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="imgs/spin.svg" />
	              </div>
	              <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:650px;height:380px;overflow:hidden;">
	                  <div><img data-u="image" src="imgs/Home/Estate/1.JPG"/></div>
	                  <div><img data-u="image" src="imgs/Home/Estate/2.JPG"/></div>
                    <div><img data-u="image" src="imgs/Home/Estate/3.JPG"/></div>
                    <div><img data-u="image" src="imgs/Home/Estate/4.JPG"/></div>
                    <div><img data-u="image" src="imgs/Home/Estate/5.JPG"/></div>
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
          
          <div id="home-inverno" class="hidden subpage home">

            <h1><?= $lang['inverno_titolo_1'] ?></h1>
            <h2><?= $lang['inverno_sub_1_1'] ?></h2>
            <h2><?= $lang['inverno_sub_1_2'] ?></h2>
            <h2><?= $lang['inverno_sub_1_3'] ?></h2>
          
            <h1><?= $lang['inverno_titolo_2'] ?></h1>
            <h2><?= $lang['inverno_sub_2_1'] ?></h2>
            <h2><?= $lang['inverno_sub_2_2'] ?></h2>
            <h2><?= $lang['inverno_sub_2_3'] ?></h2>
            <h2><?= $lang['inverno_sub_2_4'] ?></h2>
				
            <!-- #region Jssor Slider Start -->
            <div id="jssor_inverno" style="position:relative;margin:0 auto;top:0px;left:0px;width:650px;height:380px;overflow:hidden;visibility:hidden;">
              <!-- Loading Screen -->
              <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                  <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="imgs/spin.svg" />
              </div>
              <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:650px;height:380px;overflow:hidden;">
                  <div><img data-u="image" src="imgs/Home/Inverno/1.JPG"/></div>
                  <div><img data-u="image" src="imgs/Home/Inverno/2.JPG"/></div>
                  <div><img data-u="image" src="imgs/Home/Inverno/3.JPG"/></div>
                  <div><img data-u="image" src="imgs/Home/Inverno/4.JPG"/></div>
                  <div><img data-u="image" src="imgs/Home/Inverno/5.JPG"/></div>
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
          
          <div id="estate-inverno">
            <div id="estate" onclick="estate();">
              <img src="imgs/Home/Estate.jpg" class="image">
              <div class="middle">
                <div class="hover-text"><?= $lang['home_estate']?></div>
              </div>
            </div>
            <div id="inverno" onclick="inverno();">
              <img src="imgs/Home/Inverno.jpg" class="image">
              <div class="middle">
                <div class="hover-text"><?= $lang['home_inverno']?></div>
              </div>
            </div>
          </div>

          <!--
                <h4><?= $lang['footer_link_utili'] ?>:</h4>
                <div class="row">
                	<div class="col"><a href="https://www.arpa.veneto.it/previsioni/it/html/meteo_dolomiti.php" target="_blank"><?= $lang['footer_sito_meteo'] ?></a></div>
                  <div class="col"><a href="https://www.musal.it/webcam/" target="_blank">Webcam</a></div>
                  <div class="col"><a href="https://www.facebook.com/Pro-Loco-Canale-dAgordo-653270708142524" target="_blank"><img src="imgs/facebook.svg" class="icon"></a></div>
                </div>
                <div class="row" style="margin-top: 10px;">
                	<div class="col"><a href="http://www.comune.canaledagordo.bl.it/myportal/C_B574/home" target="_blank"><?= $lang['footer_sito_comune'] ?></a></div>
                	<div class="col"><a href="http://www.musal.it/" target="_blank"><?= $lang['footer_sito_musal'] ?></a></div>
                	<div class="col"><a href="http://www.parrocchiacanaledagordo.it" target="_blank"><?= $lang['footer_sito_parrocchia'] ?></a></div>
                </div>
                <div class="row" style="margin-top: 10px;">
                	<div class="col"><a href="https://www.prolocobellunesi.it/consorzio-pro-loco-dellagordino/" target="_blank"><?= $lang['footer_sito_proloco_agordino'] ?></a></div>
                	<div class="col"><a href="https://www.skiareasanpellegrino.it/" target="_blank"><?= $lang['footer_sito_ski'] ?></a></div>
                	<div class="col"><a href="http://www.agordino.bl.it/myportal/CM_AGORD/comuni-agordini" target="_blank"><?= $lang['footer_sito_comunita_montana'] ?></a></div>
                </div>
                      
          <div id="links">
            <p><?= $lang['link_utili'] ?></p>
            <ul>
              <li><a href="https://www.arpa.veneto.it/previsioni/it/html/meteo_dolomiti.php" target="_blank"><?= $lang['link_utili_meteo'] ?></a></li>
              <li><a href="https://www.skiareasanpellegrino.it/" target="_blank"><?= $lang['link_utili_impianti'] ?></a></li>
              <li><a href="https://www.musal.it/webcam/" target="_blank"><?= $lang['link_utili_webcam'] ?></a></li>
              <li><a href="http://www.comune.canaledagordo.bl.it/myportal/C_B574/home" target="_blank"><?= $lang['link_utili_comune'] ?></a></li>
            </ul>
          </div>-->

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

            <!-- #region Jssor Slider Start -->
            <div id="jssor_v_d_g" style="position:relative;margin:0 auto;top:0px;left:0px;width:650px;height:380px;overflow:hidden;visibility:hidden;">
              <!-- Loading Screen -->
              <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                  <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="imgs/spin.svg" />
              </div>
              <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:650px;height:380px;overflow:hidden;">
                  <div><img data-u="image" src="imgs/ValleDiGares/1.JPG"/></div>
                  <div><img data-u="image" src="imgs/ValleDiGares/2.JPG"/></div>
                  <div><img data-u="image" src="imgs/ValleDiGares/3.JPG"/></div>
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

          <div id="v-d-b" class="hidden subpage">
            <h1>Valle del Biois</h1>
            <p><?= $lang['valle_del_biois_content_p1'] ?></p>
            <p><?= $lang['valle_del_biois_content_p2'] ?></p>
            <p><?= $lang['valle_del_biois_content_p3'] ?></p>

            <!-- #region Jssor Slider Start -->
            <div id="jssor_v_d_b" style="position:relative;margin:0 auto;top:0px;left:0px;width:650px;height:380px;overflow:hidden;visibility:hidden;">
              <!-- Loading Screen -->
              <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                  <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="imgs/spin.svg" />
              </div>
              <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:650px;height:380px;overflow:hidden;">
                  <div><img data-u="image" src="imgs/ValleDelBiois/1.JPG" /></div>
                  <div><img data-u="image" src="imgs/ValleDelBiois/2.JPG" /></div>
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
          
          <div id="via-crucis" class="hidden subpage">
          	<h1>Via Crucis</h1>
            <p><?= $lang['via_crucis_p1'] ?></p>
            <p><?= $lang['via_crucis_p2'] ?></p>
            <img src="imgs/ViaCrucis/ViaCrucis.jpg"/>
          </div>

          <div id="chiese" class="hidden subpage">
            <h1>Chiese della Valle del Biois</h1>
          </div>
          
          <div id="eventi-canale" class="hidden subpage">
          	<div id="eventi">
          		<div class="evento">
              		<img src="imgs/Eventi/Casparetha.jpg"/>
              		<h1><?= $lang['eventi_casparetha'] ?></h1>
              		<p><?= $lang['eventi_descrizione_casparetha'] ?></p>
          		</div>
          	
              	<div class="evento">
              		<img src="imgs/Eventi/Zinghenesta.jpg"/>
              		<h1><?= $lang['eventi_zinghenesta'] ?></h1>
              		<p><?= $lang['eventi_descrizione_zinghenesta'] ?></p>
              	</div>              	
              	
              	<div class="evento">
              		<img src="imgs/Eventi/Cacciatori.jpg"/>
              		<h1><?= $lang['eventi_festa_del_cacciatore'] ?></h1>
              		<p><?= $lang['eventi_descrizione_festa_del_cacciatore'] ?></p>
              	</div>
              	
              	<div class="evento">
              		<img src="imgs/Eventi/SanGiovanni.jpg"/>
              		<h1><?= $lang['eventi_san_giovanni'] ?></h1>
              		<p><?= $lang['eventi_descrizione_san_giovanni'] ?></p>
              	</div>
              	
              	<div class="evento">
              		<img src="imgs/Eventi/Trator.jpg"/>
              		<h1><?= $lang['eventi_di_del_trator'] ?></h1>
              		<p><?= $lang['eventi_descrizione_di_del_trator'] ?></p>
              	</div>
              	
              	<div class="evento">
              		<img src="imgs/Eventi/Feder.jpg"/>
              		<h1><?= $lang['eventi_sagra_feder'] ?></h1>
              		<p><?= $lang['eventi_descrizione_sagra_feder'] ?></p>
              	</div>
              	
              	<div class="evento">
              		<img src="imgs/Eventi/Fregona.jpg"/>
              		<h1><?= $lang['eventi_sagra_fregona'] ?></h1>
              		<p><?= $lang['eventi_descrizione_sagra_fregona'] ?></p>
              	</div>

                <div class="evento">
              		<img src="imgs/Eventi/Gares.jpg"/>
              		<h1><?= $lang['eventi_sagra_gares'] ?></h1>
              		<p><?= $lang['eventi_descrizione_sagra_gares'] ?></p>
              	</div>
              	
              	<div class="evento">
              		<img src="imgs/Eventi/Mercatini.jpg"/>
              		<h1><?= $lang['eventi_mercatini'] ?></h1>
              		<p><?= $lang['eventi_descrizione_mercatini'] ?></p>
              	</div>
              	
          	</div>
          </div>
          
          <div id="paese" class="hidden subpage">
          	  <h1><?= $lang['paese_title'] ?></h1>
              <?php $i = 1; while(isset($lang["paese_p$i"])) echo '<p>'.$lang["paese_p$i"].'</p>'; ?>
    
              <!-- #region Jssor Slider Start -->
              <div id="jssor_home" style="position:relative;margin:0 auto;top:0px;left:0px;width:650px;height:380px;overflow:hidden;visibility:hidden;">
                <!-- Loading Screen -->
                <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                    <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="imgs/spin.svg" />
                </div>
                <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:650px;height:380px;overflow:hidden;">
                    <div><img data-u="image" src="imgs/Paese/1.jpg"/></div>
                    <div><img data-u="image" src="imgs/Paese/2.jpg"/></div>
                    <div><img data-u="image" src="imgs/Paese/3.jpg"/></div>
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

                <?php if($res['Sito']||$res['Maps']||$res['Email']||$res['Telefono']) { ?>
                <div class="inline-grid">
                  <?= $res['Sito']?"<p class=\"sito\"><a href=\"$res[Sito]\">".$lang['sito']."</a></p>":'' ?>
                  <?= $res['Maps']?"<p class=\"mappa\"><a href=\"$res[Maps]\">".$lang['come_arrivarci']."</a></p>":'' ?>
                  <?= $res['Email']?"<p class=\"email\"><a href=\"mailto:$res[Email]\">".$lang['email']."</a></p>":'' ?>
                  <?= $res['Telefono']?"<p class=\"telefono\"><a href=\"tel:$res[Telefono]\">".$lang['telefono'].$res['Telefono']."</a></p>":'' ?>
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

		  	</div>
          </div>
       </div>

          <footer id="footer">
              <div class="container">

                <div class="row">
                  <div class="col">
                    <h4><?= $lang['footer_dove_trovarci'] ?>:<img src="imgs/placeholder.svg" class="icon"></h4>
                    <p><a href="https://goo.gl/maps/n3VBYFqa3E56UAcn8" target="_blank">Piazza Papa Luciani, 4</a></p>
                    <p><a href="https://goo.gl/maps/n3VBYFqa3E56UAcn8" target="_blank">Canale d'Agordo (BL) - 32020</a></p>
                    <p>P.IVA 00838420255</p>
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
    <?= isset($results)?'<script>show(\'search\');</script>':'' ?>
    <script src="js/slider.js"></script>
</body>
</html>