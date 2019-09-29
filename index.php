<?php
if(isset($_REQUEST['search'])) {
	include_once 'lib/db.php';
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
	$search = [];
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
                        <a class="dropdown-item" href="?cat=Alloggi&search=Garn%C3%AC,B%26B">Garn&igrave; e B&amp;B</a>
                        <a class="dropdown-item" href="?cat=Alloggi&search=Albergo,Hotel">Alberghi e Hotel</a>
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
                        <a class="dropdown-item" href="?cat=Luoghi&search=Mostra,Museo">Mostre e musei</a>
                        <a class="dropdown-item" href="?cat=Luoghi&search=Biblioteca">Biblioteche</a>
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
                
                	<div id="estate"></div>
                	<div id="inverno"></div>
                
                	<div id="slideshow">
	                	<!-- Slideshow container -->
						<div class="slideshow-container">
						
						  <!-- Full-width images with number and caption text -->
						  <div class="mySlides fade">
						    <div class="numbertext">1 / 3</div>
						    <img src="imgs/slider/aurora.jpg" style="width:100%">
						    <div class="text">Caption Text</div>
						  </div>
						
						  <div class="mySlides fade">
						    <div class="numbertext">2 / 3</div>
						    <img src="imgs/slider/ghiaccio.jpg" style="width:100%">
						    <div class="text">Caption Two</div>
						  </div>
						
						  <div class="mySlides fade">
						    <div class="numbertext">3 / 3</div>
						    <img src="imgs/slider/universo.jpg" style="width:100%">
						    <div class="text">Caption Three</div>
						  </div>
						
						  <!-- Next and previous buttons -->
						  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
						  <a class="next" onclick="plusSlides(1)">&#10095;</a>
						</div>
						<br>
						
						<!-- The dots/circles -->
						<div style="text-align:center">
						  <span class="dot" onclick="currentSlide(1)"></span>
						  <span class="dot" onclick="currentSlide(2)"></span>
						  <span class="dot" onclick="currentSlide(3)"></span>
						</div>
					</div>
					
                </div>
				
				<div id="v-d-g" class="hidden">
					<h1>Valle di Gares</h1>
				</div>
				
				<div id="v-d-b" class="hidden">
					<h1>Valle del Biois</h1>
				</div>
				
				<div id="search" class="hidden">
					<h1>Ricerca</h1>
				</div>
				
				<div id="come-arrivare" class="hidden">
					<div id="map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1946.9631544335696!2d11.913474742799066!3d46.36102078420485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4778453599d4a887%3A0x2c95c73b5c456247!2sMuseo%20Albino%20Luciani%20Canale%20d&#39;Agordo!5e0!3m2!1sit!2sit!4v1569776504349!5m2!1sit!2sit"></iframe>
					</div>
					<h2><a href="https://dolomitibus.it/files/orari/invernali/extra/Agordino/Linea2_I.pdf" target="_blank">Orari Dolomitibus</a></h2>
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
                    <p>Sabato: 9:00-12:00 e 15:00-18:00</p>
                    <p>Venerd&igrave;, Domenica e festivi: 9.00-12.00</p>
                  </div>
                  <div class="col-sm">
                    <h4>Social:</h4>
                    <a href="https://www.facebook.com/Pro-Loco-Canale-dAgordo-653270708142524" target="_blank"><img src="imgs/facebook.svg" class="icon"></a>
                  </div>
                </div>
              </div>
            </footer>
        </div>
    </div>
    <?= isset($search)?'<script>show(\'search\');</script>':'' ?>
    <script src="js/slider.js"></script>
</body>
</html>
