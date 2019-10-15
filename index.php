<?php
include_once 'lib/db.php';
if(DB::check(['cat', 'search'], $_REQUEST)) {
	ini_set('display_errors', 0);
	try {
		$db = new DB(__DIR__.'/../db.ini');
	} catch (Exception $e) {
		header('Content-type: text/txt;');
		echo
		'Specificare il file ini per il database in: __DIR__.\'/../db.ini
Esempio:
db = mysql
host = 127.0.0.1
port = 3306
dbName = db
user = root
pass = root';
		exit();
	}

	//print_r($_REQUEST);

	//TODO
	try {
		if(in_array($_REQUEST['cat'], ['alloggi', 'luoghi'])){

      $types = explode(',', $_REQUEST['search']);
			$results = $db->ql("SELECT * FROM $_REQUEST[cat] WHERE Tipo IN (?".str_repeat(',?', count($types)-1).')', $types);

		}
	} catch (Exception $e) {}
}
?>
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
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false">Alloggi</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="?cat=alloggi&search=Garn%C3%AC,B%26B">Garn&igrave; e B&amp;B</a>
                        <a class="dropdown-item" href="?cat=alloggi&search=Albergo,Hotel">Alberghi e Hotel</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="files/appartamenti.pdf" target="_blank">Appartamenti</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false">Cosa vedere</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="show('v-d-g');">Valle di Gares - Biotopo</a>
                        <a class="dropdown-item" href="#" onclick="show('v-d-b');">Valle del Biois</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="?cat=luoghi&search=Mostra,Museo">Mostre e musei</a>
                        <a class="dropdown-item" href="?cat=luoghi&search=Biblioteca">Biblioteche</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false">Eventi</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="http://web4.deskline.net/valledelbiois/it/event/list" target="_blank">Eventi in zona</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="http://www.casparetha.it" target="_blank">Casparetha</a>
                        <a class="dropdown-item" href="http://www.zinghenesta.it" target="_blank">Zinghenesta</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="show('come-arrivare');">Come arrivare</a>
                </li>

            </ul>
        </nav>
        <div id="content-wrap">
            <div id="content">

                <div id="home">
                  <h1>Il paese</h1>
                  <p>
                    Canale d'Agordo, Forno di Canale fino al 1964 è uno dei paesi che compongono la Valle del Biois, in Agordino, a circa 50 km da Belluno.
                  </p>
                  <p>
                    Il paese è ampliamente noto in quanto paese natale di <a target="_blank" href="https://it.wikipedia.org/wiki/Papa_Giovanni_Paolo_I">Albino Luciani (papa Giovanni Paolo I)</a>, oltre che del paesaggista Giuseppe Zais e del poeta Valerio Da Pos.
                  </p>
                  <p>
                    Circondato da imponenti vette dolomitiche quali il Civetta, il Pelmo, le Pale di San Martino, le Pale di San Lucano, le Cime d'Auta e la Marmolada confina con il Trentino attraverso la splendida Valle di Gares. E l'Altipiano delle Comelle.
                  </p>
                  <p>
                    Canale d'Agordo vanta ben 4 frazioni alte: Gares, Fregona, Feder, Carfon, dove il patrimonio rurale ed edilizio ha tutt'ora mantenuto viva la tipicità dei tabiai di montagna e la tradizione dello sfalcio e della cura del territorio.
                  </p>
                  <!-- #region Jssor Slider Start -->
                  <div id="jssor_home" style="position:relative;margin:0 auto;top:0px;left:0px;width:650px;height:380px;overflow:hidden;visibility:hidden;">
                    <!-- Loading Screen -->
                    <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                        <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="imgs/slider/spin.svg" />
                    </div>
                    <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:650px;height:380px;overflow:hidden;">
                        <div><img data-u="image" src="imgs/background.jpg" /> </div>
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
            <p>
              La Valle di Gares è una valle di origine glaciale che si estende per ben 7 km dal capoluogo di Canale d'Agordo in  direzione delle Pale di San Martino.
            </p>
            <p>
              Meta di escursionismo e frequente visita da parte dei turisti  e non che soggiornano in Valle del Biois, si presta alle più svariate tipologie di pratica sportiva : dalla mountain bike, allo skiroll, dal nordic walking agli sport prettamente invernali come lo sci di fondo e l'arrampicata su ghiaccio.
            </p>
            <p>
              Al termine della Valle, chiusa dalla catena delle Pale di San Martino, sono ben visibili e facilmente accessibili le cascate delle Comelle e diversi rifugi.
            </p>
            <p>
              Qui sorsero tra il 1450 ed il 1748 le miniere del Sass  Negher, dalle quali venivano estratti principalmente rame e ferro. 
              Il nome “Forno di Canale” fu, infatti, attribuito al Paese per la sua importanza come centro minerario e siderurgico dell’ Agordino.
            </p>
            <h1>Biotopo</h1>
            <p>
              In località Pian de Giare (1381 m slm), è possibile passeggiare in prossimità del Laghetto di Gares. Questo lago è presente dal disgelo fino all'inizio della stagione invernale ed offre condizioni idonee per lo sviluppo di comunità idrofitiche, opportunità per la riproduzione degli anfibi e per il nutrimento di altre specie.
            </p>
            <p>
              Un'ambiente che è espressione di un insieme di realtà vegetazionali e faunistiche insediate all'interno di spazi ed ambienti molto vari ed armoniosamente collegati fra di loro: la sorgente, il lago, il torrente, i boschi di conifere, il prato....
            </p>
            <!-- #region Jssor Slider Start -->
            <div id="jssor_v_d_g" style="position:relative;margin:0 auto;top:0px;left:0px;width:650px;height:380px;overflow:hidden;visibility:hidden;">
              <!-- Loading Screen -->
              <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                  <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="imgs/slider/spin.svg" />
              </div>
              <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:650px;height:380px;overflow:hidden;">
                  <div><img data-u="image" src="imgs/slider/aurora.jpg" /> </div>
                  <div><img data-u="image" src="imgs/slider/universo.jpg" /> </div>
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
            <p>
              La Valle del Biois, che si estende per 20 km dal Passo San Pellegrino fino a alla confluenza con il torrente Cordevole, comprende i Comuni di Falcade, Canale d'Agordo, Vallada Agordina e Cencenighe Agordino.
            </p>
            <p>
              Confina con la provincia autonoma di Trento e deve il suo nome al torrente Biois, che ha le proprie sorgenti al Passo di San Pellegrino (Moena).
              La Valle del Biois, nota anche con l'appellativo di  “Valle coi Santi alle Finestre”, è ricca di storia e cultura, di personalità di rilievo in tutti in campi, dalla religione alla medicina, dall'arte allo sport e può vantare un patrimonio naturalistico riconosciuto a livello mondiale dall'UNESCO. I panorami che questi luoghi regalano al visitatore sono, infatti, di straordinaria ed unica bellezza.
              Falcade è il centro sportivo per eccellenza con gli impianti che da località Molino permettono di accedere ai collegamenti sciistici del Comprensorio della Ski Area San Pellegrino, con ben 60 km di piste.
            </p>
            <p>
              Canale d'Agordo, assieme a Vallada Agordina, è il centro culturale della Vallata e, in località Gares può vantare anche un circuito di piste da fondo.
              Cencenighe rappresenta il crocevia dei collegamenti tra la Valle del Biois e la Val Cordevole con il resto dell'Agordino e del Bellunese.
            </p>
            <!-- #region Jssor Slider Start -->
            <div id="jssor_v_d_b" style="position:relative;margin:0 auto;top:0px;left:0px;width:650px;height:380px;overflow:hidden;visibility:hidden;">
              <!-- Loading Screen -->
              <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                  <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="imgs/slider/spin.svg" />
              </div>
              <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:650px;height:380px;overflow:hidden;">
                  <div><img data-u="image" src="imgs/slider/aurora.jpg" /> </div>
                  <div><img data-u="image" src="imgs/slider/universo.jpg" /> </div>
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
            <div class="resultBox">

            <?php
            foreach($results as $res){ ?>
              
              <div class="result">

                <div class="grid-2-cols">
                  <div>
                    <h2><?= $res['Nome'] ?></h2>
                    <?= $res['Descrizione']?"<p class=\"descrizione\">$res[Descrizione]</p>":'' ?>

                    <?php if($res['Sito']||$res['Maps']) { ?>
                    <div class="grid-2-cols">
                      <?= $res['Sito']?"<p class=\"sito\"><a href=\"$res[Sito]\">Sito</a></p>":'' ?>
                      <?= $res['Maps']?"<p class=\"mappa\"><a href=\"$res[Maps]\">Come arrivarci</a></p>":'' ?>
                    </div>
                    <?php } ?>
                  </div>

                  <?= $res['Foto']?"<img src=\"imgs/dbImgs/$res[Foto]\">":'' ?>
                </div>

              </div>
            <?php } ?>
            </div>
            </div>

            <div id="come-arrivare" class="hidden">
              <div id="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1946.9631544335696!2d11.913474742799066!3d46.36102078420485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4778453599d4a887%3A0x2c95c73b5c456247!2sMuseo%20Albino%20Luciani%20Canale%20d&#39;Agordo!5e0!3m2!1sit!2sit!4v1569776504349!5m2!1sit!2sit"></iframe>
              </div>
              <h2><a href="https://dolomitibus.it/files/orari/invernali/extra/Agordino/Linea2_I.pdf" target="_blank">Orari Dolomitibus</a></h2>
            </div>

				  </div>
          </div>  

          <footer id="footer">
              <div class="container" style="margin-top:auto;margin-bottom:auto;">
                <div class="row">
                  <div class="col-sm">
                    <h4>Dove trovarci:<img src="imgs/placeholder.svg" class="icon"></h4>
                    <p><a href="https://goo.gl/maps/n3VBYFqa3E56UAcn8" target="_blank">Piazza Papa Luciani, 4</a></p>
                    <p><a href="https://goo.gl/maps/n3VBYFqa3E56UAcn8" target="_blank">Canale d'Agordo (BL) - 32020</a></p>
                  </div>
                  <div class="col-sm">
                    <h4>Come contattarci:</h4>
                    <p><img src="imgs/email.svg" class="icon"><a href="mailto: info@prolococanale.it" target="_blank">info@prolococanale.it</a></p>
                    <p><img src="imgs/telephone.svg" class="icon"><a href="tel: 0437 1948030" target="_blank">0437 1948030</a></p>
                  </div>
                  <div class="col-sm">
                    <h4>Orari ufficio:<img src="imgs/info.svg" class="icon"></h4>
                    <p>Sabato<br>9:00-12:00 e 15:00-18:00</p>
                    <p>Venerd&igrave;, Domenica e festivi:<br>9.00-12.00</p>
                  </div>
                  <div class="col-sm">
                    <h4>Link:</h4>
                    <p><a href="https://www.arpa.veneto.it/previsioni/it/html/meteo_dolomiti.php" target="_blank">Meteo</a></p>
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
