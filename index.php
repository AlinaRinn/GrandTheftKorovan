<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/header.php');
?>
    <audio id='audio1' src='/res/gta_sound.wav'></audio>
    <script type='text/javascript'>
        function playing() {
        document.getElementById('audio1').play();
        }
    </script>
    <a href="/korovan.php"><button id="start" name="start" onMouseOver="playing()">Грабить Корованы</button></a>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php');