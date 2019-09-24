<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <style type="text/css">
            body{
                font-family: "Comic Sans MS";
                font-size: 150%;
            }
            #page-content{
                display: block;
                justify-content: center;
                height: 100%;
            }
            .container{
                border-style: solid;
                border-width: medium
            }
        </style>
        <script>
            function changeContent(res){
                var content='';
                if(res === 'orari'){
                    content=<?php
                                $file = fopen("orari.txt", "r") or exit("Unable to open file!");
                                echo '"<div class=\"container\" style=\"margin-top: 20px;\">';
                                $rows = explode('|', fgets($file));
                                foreach($rows as $row){
                                    $items = explode(' ', $row);
                                    $td = '';
                                    foreach($items as $item){
                                        $td = $td.'<div class=\"col-sm\">'.$item.'</div>';
                                    }
                                    echo '<div class=\"row\">'.$td.'</div>';
                                }
                                echo '</div>"';
                                fclose($file);
                            ?>;
                     content+="<div style=\"text-align: center; margin-top: 50px;\"> <p><b>Tel.</b> 0437 1948030</p> <p><b>Email</b> info@prolococanale.it</p> </div>"; 
                }else if(res === 'appartamenti')
                    content = "<iframe src=\"alloggi.pdf\" style=\"width:100%;height:100%;\"></iframe>";
                else;
                document.getElementById("page-content").innerHTML = content;
            }
        </script>
    </head>
    
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
         
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
             
              <li class="nav-item active">
                <a class="nav-link" href="#" onclick="changeContent('bubu');">Luoghi</a>
              </li>
             
              <li class="nav-item active">
                <a class="nav-link" href="#" onclick="changeContent('appartamenti');">Alloggi</a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link" href="#">Servizi</a>
              </li>
              
             <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 Cosa fare
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Estate</a>
                  <a class="dropdown-item" href="#">Inverno</a>
                </div>
              </li>
              
              <li class="nav-item">
                <a class="nav-link" href="#">Eventi</a>
              </li>
              
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 Altro
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#" onclick="changeContent('orari');">Orari</a>
                  <a class="dropdown-item" href="https://www.musal.it/webcam/">Webcam</a>
                  <a class="dropdown-item" href="http://www.arpa.veneto.it/previsioni/it/html/meteo_dolomiti.php">Meteo</a>
                </div>
              </li>
              
            </ul>
          </div>
          
        </nav>
        
        <div id="page-content">
            
        </div>
    </body>
</html>