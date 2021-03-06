<div class="container">

    <br>
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-xs-10 col-xs-offset-1">
            <form role="form" method="post" action="index.php">
                <div class="form-group">
                    <button name="deconnexion" type="submit" class="btn btn-primary btn-lg btn-block" value="">
                        <span class="button-text-lg">Déconnexion</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-5 col-lg-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading" style="font-family: zekton">
                Lecture en cours
            </div>
            <marquee behavior='scroll' direction='left'>
                <span class="titre">
                    <?php
                        $db = new pdo('mysql:host=localhost;dbname=raspi_connect', 'root', 'password');
                        $titre = "SELECT titre FROM media WHERE statut = 'lecture' OR statut = 'stop'";
                        $request = $db->prepare($titre);
                        $request->execute();
                        $result = $request->fetch(PDO::FETCH_ASSOC);
                        echo $result['titre'];
                    ?>
                </span>
            </marquee>
        </div>
        <div class="panel panel-default panel-body">
            <script>
                function prec() {
                    document.getElementById('event').value = "prec";
                }
                function stop() {
                    document.getElementById('event').value = "stop";
                }
                function suiv() {
                    document.getElementById('event').value = "suiv";
                }
            </script>
            <center>
                <form method="post" action="lecteur.php">
                    <div class="visible-xs">
                        <button id="prec-xs" class="btn btn-media-xs glyphicon glyphicon-backward" type="submit" onclick="prec()"></button>
                        <button id="stop-xs" class="btn btn-media-xs glyphicon
                            <?php
                                $db = new pdo('mysql:host=localhost;dbname=raspi_connect', 'root', 'password');
                                $class = "SELECT id FROM media WHERE statut = 'lecture'";
                                $request = $db->prepare($class);
                                $request->execute();
                                if ($result = $request->fetch(PDO::FETCH_ASSOC))
                                    echo ' glyphicon-stop';
                                else echo ' glyphicon-play';
                            ?>
                        " type="submit" onclick="stop()"></button>
                        <button id="suiv-xs" class="btn btn-media-xs glyphicon glyphicon-forward" type="submit" onclick="suiv()"></button>
                    </div>
                    <div class="visible-lg visible-md visible-sm">
                        <button id="prec-lg" class="btn btn-media-lg glyphicon glyphicon-backward" type="submit" onclick="prec()"></button>
                        <button id="stop-lg" class="btn btn-media-lg glyphicon
                            <?php
                                $db = new pdo('mysql:host=localhost;dbname=raspi_connect', 'root', 'password');
                                $class = "SELECT id FROM media WHERE statut = 'lecture'";
                                $request = $db->prepare($class);
                                $request->execute();
                                if ($result = $request->fetch(PDO::FETCH_ASSOC))
                                    echo ' glyphicon-stop';
                                else echo ' glyphicon-play';
                            ?>
                        " type="submit" onclick="stop()"></button>
                        <button id="suiv-lg" class="btn btn-media-lg glyphicon glyphicon-forward" type="submit" onclick="suiv()"></button>
                    </div>
                    <input type="hidden" id="event" name="event" value="" />
                </form>
            </center>
            <br>
            <button class="btn btn-lg btn-block btn-success btn-swag-green" style="font-family: zekton" data-toggle='collapse' data-target='#ajouter'>Ajouter un média</button>
            <div id="ajouter" class="collapse" style="font-family: zekton">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#adresse">Ajouter une adresse</a></li>
                    <li><a data-toggle="tab" href="#fichier">Ajouter un fichier</a></li>
                </ul>
                
                <script>
                function title1(url) {
                    document.getElementById('titre_preview').src='title.php?url=' + url;
                    
                    var youtube = url.indexOf('https://www.youtube.com/watch?v=');
                    var youtubem = url.indexOf('https://m.youtube.com/watch?v=');
                    var deezer = url.indexOf('http://www.deezer.com/track/');
                    if (youtube != -1) {
                        url = url.replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/') + '?autoplay=1';
                        document.getElementById('url').value = url;
                    }
                    else if (youtubem != -1) {
                        url = url.replace('https://m.youtube.com/watch?v=', 'https://www.youtube.com/embed/') + '?autoplay=1';
                        document.getElementById('url').value = url;
                    }
                    else if (deezer != -1) {
                        var id = url.replace('http://www.deezer.com/track/', '');
                        id = id.slice(0, id.indexOf('?'));
                        url = "http://www.deezer.com/plugins/player?format=classic&autoplay=true&playlist=false&color=007FEB&layout=dark&type=tracks&id=" + id + "&app_id=1";
                        document.getElementById('url').value = url;
                    }
                }
                function title2(fichier) {
                    fichier = fichier.replace('C:\\fakepath\\', '');
                    document.getElementById('titre2').value = fichier;
                }
                function validation() {
                    var url = document.getElementById('url');
                    var file = document.getElementById('file');
                    var titre1 = document.getElementById('titre1');
                    var titre2 = document.getElementById('titre2');
                    if (url.value=='' && file.value=='') {
                        alert("Vous devez entrer un média!");
                        return false;
                    } else if (titre1.value=='' && titre2.value=='') {
                        alert("Vous devez entrer un titre!");
                        return false;
                    } else return true;
                }
                </script>
                <div class="tab-content" style="color: oldlace">
                    <div id="adresse" class="tab-pane fade in active">
                        <form class="form-group" method="post" action="ajouter.php" onsubmit="return validation()">
                            <label for="url">Url :</label>
                            <input type="url" class="form-control" id="url" name="url" onchange="title1(this.value)" value=""/>
                            <label for="titre1">Titre :</label>
                            <input type="text" class="form-control" id="titre1" name="titre" value="" />
                            <iframe style="visibility: hidden; height: 0px" src="" onload="document.getElementById('titre1').value=this.contentDocument.body.innerHTML" id="titre_preview"></iframe>
                            <button type="submit" class="btn btn-success btn-block btn-swag-green">Valider</button>
                        </form>
                    </div>
                    <div id="fichier" class="tab-pane fade">
                        <form class="form-group" method="post" action="ajouter.php" enctype="multipart/form-data" onsubmit="return validation()">
                            <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
                            <label for="file">Fichier :</label>
                            <input type="file" class="form-control" id="file" name="uploadFile" accept="audio/*" onchange="title2(this.value)" />
                            <label for="titre2">Titre :</label>
                            <input type="text" class="form-control" id="titre2" name="titre" value=""/><br>
                            <button type="submit" class="btn btn-success btn-block btn-swag-green">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3" style="font-family: zekton">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liste de lecture :
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <form method="post" action="index.php">
                        <input type='hidden' id="key" name='key' value=''>
                        <table class="table">
                            <?php
                                $db = new pdo('mysql:host=localhost;dbname=raspi_connect', 'root', 'password');
                                if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['key'])) {
                                    $test = "SELECT utilisateur, url FROM media WHERE id = $_POST[key]";
                                    $request = $db->prepare($test);
                                    $request->execute();
                                    $result = $request->fetch(PDO::FETCH_ASSOC);
                                    if ($result['utilisateur'] == $_SESSION['user']) {
                                        if (file_exists($result['url'])) unlink ($result['url']);
                                        $suppr = "DELETE FROM media WHERE id = $_POST[key]";
                                        $request = $db->prepare($suppr);
                                        $request->execute();
                                    } else
                                        echo '<div class="alert alert-danger">Refusé! Vous n\'êtes pas l\'auteur de cet ajout.<a href="#" class="close" data-dismiss="alert">&times;</a></div>';
                                }

                                $media = "SELECT id, titre FROM media WHERE statut!='lecture' AND statut!='précédent' AND statut!='stop'";
                                $request = $db->prepare($media);
                                $request->execute();
                                while ($result = $request->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr><td>$result[titre]</td>";
                                    echo "<td><button type='submit' class=\"btn btn-danger btn-swag-red\" onclick=\"document.getElementById('key').value=$result[id]\">";
                                    echo "Supprimer</button></td></tr>";
                                }
                            ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
