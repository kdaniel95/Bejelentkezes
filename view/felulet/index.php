<!doctype html>

<html>
    <head>
        <meta charset="utf-8">
        <title>Központi admin felület</title>
    </head>



    <body>
        <h1>Központi admin felület</h1>
        <h2>Menü</h2>
        <ul>

            <li><a href="">Központi admin felület</a></li>
            <?php
            if (isset($this->data['elerhetoMenuk'])) {
                echo $this->data['elerhetoMenuk'];
            }
            ?>

            <li><a href="./kijelentkezes">Kijelentkezés</a></li>
        </ul>

        <br>

        <h2>Felhasználói adatok</h2>
        <br>
        <label>Felhasználónév: </label>
        <?php
        if (isset($this->data['fnev'])) {
            echo $this->data['fnev'];
        }
        ?>
        
        <br>
        
        <label>Szerepkör: </label>
        <?php
        if (isset($this->data['szerepkorok'])) {
            echo $this->data['szerepkorok'];
        }
        ?>
        
        <br>
        
        <label>Utolsó bejelentkezés dátuma: </label>
        <?php
        if (isset($this->data['utbejeldatum'])) {
            echo $this->data['utbejeldatum'];
        }
        ?>

    </body>

</html>