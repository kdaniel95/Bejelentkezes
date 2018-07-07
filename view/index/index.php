<!doctype html>

<html>
    <head>
        <meta charset="utf-8">
        <title>Bejelentkező rendszer - Straxus próbafeladat - Kónya Dániel</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    
    
    <body>
        
        <h1>Bejelentkezés</h1>
        
        <form action="./bejelentkeztetes" method="post">
            <label for="fnev">Felhasználónév:</label>
            <input type="text" name="fnev" placeholder="Felhasználónév">
            <br>
            <br>
            <label for="fnev">Jelszó:</label>
            <input type="password" name="jelszo" placeholder="Jelszó">
            <br>
            <br>
            <input type="submit" value="Bejelentkezés">
            <br>
            <br>
            <?php
            if(isset($this -> data['withCaptcha'])){
            if($this -> data['withCaptcha']){
                echo "<div class='g-recaptcha' data-sitekey='6LezWCgUAAAAAKNwCPtg-_j8aAXe6QhGhDWoaEx7'></div>";
            }
            }
            ?>
            
        </form>
        
        
    </body>
    
    
    
    
</html>
