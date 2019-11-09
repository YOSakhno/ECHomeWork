<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="./index.php" method="post">
        <?php if(!empty($_SESSION['incorrect_city'])) {?>
            <span style="color: red;"><?php echo $_SESSION['incorrect_city'];?></span>
        <?php } ?>
        <?php if(!empty($_SESSION['cities'])) {?>
            <span style="color: red;"><?php var_dump($_SESSION['cities']);?></span>
        <?php } ?>
        <label for="city">Введите название города</label>
        <input id="city" name="city" type="text">
        <?php if(!empty($_SESSION['answer'])) {?>
            <span style="color: red;"><?php echo $_SESSION['answer'];?></span>
        <?php } ?>
        <button type="submit" name="send" value="find">Ввести</button>
        <?php if(!empty($_SESSION['game_over'])) {?>
            <span style="color: red;"><?php echo 'Игра окончена'?></span>
        <?php } ?>
        <a href="./index.php?restart=1">RESTART</a>
    </form>
</body>
</html>