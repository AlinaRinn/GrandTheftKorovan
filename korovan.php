<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/GTK_db.php');

class Korovan{
    private int $difficulty, $richness, $gold;
    private float $required_time;

    function __construct() {
        //print "Конструктор класса" . "<br>";
        $this->difficulty = rand(1,5);
        $this->richness = rand(1,3);
        $this->required_time = rand(1, 30) / 10;
        $this->gold = $this->difficulty * $this->richness * $this->required_time + rand(1,10);
    }

    function __destruct() {
    }

    function get_rich(){
        return $this->richness;
    }

    function get_req(){
        return $this->required_time;
    }

    function get_gold(){
        return $this->gold;
    }

    public function print() {

        print "Богатство: ";
        if($this->richness === 1){
            print "&#9733; <br>";
        }
        elseif ($this->richness === 2){
            print "&#9733;&#9733; <br>";
        }
        elseif ($this->richness === 3){
            print "&#9733;&#9733;&#9733; <br>";
        }

        print "Сложность: ";
        if($this->difficulty === 1){
            print "&#9733; <br>";
        }
        elseif ($this->difficulty === 2){
            print "&#9733;&#9733; <br>";
        }
        elseif ($this->difficulty === 3){
            print "&#9733;&#9733;&#9733; <br>";
        }
        elseif ($this->difficulty === 4){
            print "&#9733;&#9733;&#9733;&#9733; <br>";
        }
        elseif ($this->difficulty === 5){
            print "&#9733;&#9733;&#9733;&#9733;&#9733; <br>";
        }

        print "Время набигания: " . $this->required_time  . "<br>";
        print "Золото: " . $this->gold  . "<br>";
    }
}

session_start();

if(!isset($_SESSION['kp'])) {
    $_SESSION['kp'] = 2241.00;
    $_SESSION['gold_cnt'] = 0;
    $_SESSION['cnt'] = 1;
    $_SESSION['korovan'] = new Korovan();
}
print "<div id='game'><div id='year'>Год: " . $_SESSION['kp'] . "</div>";

if($_SESSION['korovan']->get_rich() === 1){
    print "<img src='/pics/small.jpg' width='480' height='270' alt='error'>";
}
elseif ($_SESSION['korovan']->get_rich() === 2){
    print "<img src='/pics/medium.jpg' width='480' height='270' alt='error'>";
}
elseif ($_SESSION['korovan']->get_rich() === 3){
    print "<img src='/pics/big.jpg' width='480' height='270' alt='error'>";
}
print "<br>" . "<p id='gamehead'>Корован № " . $_SESSION['cnt'] . "</p>";
$_SESSION['korovan']->print();
print "<p id='gamescore'>Уже награблено: " . $_SESSION['gold_cnt'] . " золота</p>";

if($_SESSION['kp'] >= 2254) {
    $tmp_gold = $_SESSION['gold_cnt'];
    session_destroy();
    session_start();
    $_SESSION['gold_cnt_tmp'] = $tmp_gold;

        print '    
    <div id="scoresender">
        <form action="/korovan.php" method="post" style="height: 50px">
            <label> Ник: <input style="margin-left: 30px; margin-right: 30px; height: 40px; border-radius: 10px; font-size: xx-large; font-family: GTAru, cursive;" type="text" name="nick" value="" required/></label>
            <button style="font-size: xxx-large; border-radius: 10px; padding: 5px" type="submit" name="scoresend">Сохранятся можно...</button>
        </form>
    </div>
    ';

    print("<p style='margin-top: 30px; '><a href='korovan.php' style='font-size: 80px; font-family: GTAru, cursive; font-weight: lighter;'>набигать снова</a></p>");
}
else {
    print('
    <div id="manager">
        <form action="/korovan.php" method="post">
            <button type="submit" name="looting">набигать</button>
            <button type="submit" name="skipwait">ждать джва года</button>
        </form>
    </div>
    ');
}

if(isset($_POST['scoresend'])) {
    $db_connect = new GTKdb();
    $db_connect->Insert("leaderboard", htmlspecialchars($_POST["nick"]), $_SESSION['gold_cnt_tmp']);
    session_destroy();
}

if(isset($_POST['looting'])) {
    header('Location: ' . $_SERVER['REQUEST_URI']);
    $_SESSION['kp'] += $_SESSION['korovan']->get_req();
    $_SESSION['gold_cnt'] += $_SESSION['korovan']->get_gold();
    $_SESSION['cnt']++;
    $_SESSION['korovan'] = new Korovan();
}
elseif(isset($_POST['skipwait'])) {
    header('Location: ' . $_SERVER['REQUEST_URI']);
    $_SESSION['kp'] += 2;
    $_SESSION['cnt']++;
    $_SESSION['korovan'] = new Korovan();
}

print "</div>";
require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php');


/*$Korovans = array();
for($i = 0; $i < 10; $i++) {
    $Korovans[$i] = new Korovan();
    $Korovans[$i]->print();
}
*/
