<html>
    <head>
        <title>
        <?php
            include_once 'session.php';
            $db = new pdo('mysql:host=localhost;dbname=raspi_connect', 'root', 'password');
            $url = "SELECT url, statut FROM media WHERE statut = 'lecture' OR statut = 'stop'";
            $request = $db->prepare($url);
            $request->execute();
            if (($result = $request->fetch(PDO::FETCH_ASSOC)) && ($result['statut']!='stop')) {
                if (file_exists($result['url']))
                    echo 'http://localhost/RaspiConnect/' . str_replace("%2F", "/", rawurlencode($result['url']));
                else
                    echo $result['url'];
            } else echo 'http://localhost/RaspiConnect/vinyl.jpg';
        ?>
        </title>
    </head>
    <body>
    </body>
</html>
