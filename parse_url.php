<?php
// setzt MP4-Link direkt aus dem Videocampus-Link zusammen
?>
<form class="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <input type="text" name="url" placeholder="https://videocampus.sachsen.de/..">
  <button type="submit">Eingaben absenden</button>
</form>

<?php
  if (isset($_POST["url"]) AND $_POST["url"]!=='' AND parse_url($_POST["url"], PHP_URL_HOST)=='videocampus.sachsen.de') {
    $url = $_POST["url"];

      //URL in Segemente unterteilen (für später)
        $urlSegmente = explode("/", parse_url($url, PHP_URL_PATH));

      //letztes URL-Segment auswählen
        $letztesUrlSegment = array_pop($urlSegmente);

    if ($urlSegmente['1']=='category') {
      //für den Fall, dass das Video in einer Kategorie einsortiert war
      //https://videocampus.sachsen.de/category/video/VL5-Clip3mp4/b29587bc055c44edfd769f98a1e497b3/114

      //vorletztes URL-Segment auswählen
        $vorletztesUrlSegment = $urlSegmente[count($urlSegmente)-1];

      //Beispiel:
        //https://videocampus.sachsen.de/category/114/getMedium/b29587bc055c44edfd769f98a1e497b3.mp4

        echo $mp4 = 'https://videocampus.sachsen.de/category/'. $letztesUrlSegment . '/getMedium/' . $vorletztesUrlSegment . '.mp4';

    }else {
      //für denn Fall, dass das Video nicht in einer Kategorie einsortiert war
      //https://videocampus.sachsen.de/video/Videokonferenz-Zugang-zum-Konferenzraum-mit-Raumcode-beschraenken/2c8c7052423c4635f75b9189cd71ea68

      //Beispiel:
        //https://videocampus.sachsen.de/getMedium/2c8c7052423c4635f75b9189cd71ea68.mp4

        echo $mp4 = 'https://videocampus.sachsen.de/getMedium/' . $letztesUrlSegment . '.mp4';

    }
  }elseif(isset($_POST["url"])) {
    echo 'Kein gültiger \'videocampus.sachsen.de\'-Link.';
  }
?>
