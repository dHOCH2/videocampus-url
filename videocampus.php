<form class="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <input type="text" name="url" placeholder="https://videocampus.sachsen.de/..">
  <button type="button" name="button">abschicken</button>
</form>
<?php
  if (isset($_POST["url"]) AND $_POST["url"]!=='') {
    $url = $_POST["url"];

      //Seitenqelltext einlesen
        $homepage = file_get_contents($url);

      //URL in Segemente unterteilen (für später)
        $urlSegmente = explode("/", parse_url($url, PHP_URL_PATH));

      //letztes URL-Segment auswählen
        $letztesUrlSegment = array_pop($urlSegmente);

      //vorletztes URL-Segment auswählen
        $vorletztesUrlSegment = $urlSegmente[count($urlSegmente)-1];

      //sucht im Quelltext nach dem letzten URL-Segment inkl. Unterstrich
      // gibt den Text danach in neue Variable "pos"
        $pos = strstr($homepage, $letztesUrlSegment .'_');

      //sucht im übrigen Quelltext nach '_sprites.jpg' & löscht alles ab diesem String
        $pos = strstr($pos, '_sprites.jpg', true);



    if ($pos == "") { //Abfrage, ob Variable ggf. leer
      //Beispiel:
        //https://videocampus.sachsen.de/category/108/getMedium/d024eb6cef17f32e3763280c28a88142.mp4

      //da 'pos' leer ist, wird der MP4-Link zusammengesetzt
      $mp4 = 'https://videocampus.sachsen.de/category/'. $letztesUrlSegment . '/getMedium/' . $vorletztesUrlSegment . '.mp4';

      //zur Sicherheit wird der MP4-Link noch im Quelltext gesucht
        $new = strstr($homepage, $mp4);

        echo $mp4;

        //wenn 'new'-Variable leer ist, wird ein Hinweis ausgegeben
        if ($new == "") {
          echo '<br>';
          echo 'Link möglicherweise nicht nutzbar.';
        }


    }else { //wenn Variable 'pos' nicht leer, setzt es den m3u8-Link zusammen und gibt diesen aus
      echo 'https://videocampus.sachsen.de/media/hlsMedium/key/' . $letztesUrlSegment . '/format/auto/ext/mp4/learning/0/path/' . $pos . '_mp4.m3u8';
    }
  }
?>
