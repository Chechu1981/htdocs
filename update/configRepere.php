<?php include('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include('./../helper/head.php'); ?>
</head>
<body>
    <?php include_once '../helper/alert.php'; ?>
    <div id="menu">
        <?php include_once '../helper/menu.php'; ?>
    </div>
    <div class="search-table">
        <div id="contacts">
            <h1>Configuración - Reperes</h1>
        </div>
        <div class="form-repere">
        <form>
            <?php
            for($i = 0;$i < 10;$i++){
                ?>
                <input type="text" name="repere" placeholder="Repere"></input>
                <div class="arrowRight"></div>
                <input type="text" name="referencia" placeholder="Referencia"></input>
            <?php } ?>
            <input type="submit" name="Guardar" value="Guardar"></input>
        </form>
        </div>
    </div>
    <?php include('../helper/footer.php'); ?>
    <script src="../js/formRepere.js"></script>
</body>
</html>