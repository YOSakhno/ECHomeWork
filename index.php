<?php
session_start();
if(!empty($_GET['restart'])) {
    unset($_SESSION['cities']);
    unset($_SESSION['answer']);
    unset($_SESSION['incorrect_city']);
    unset($_SESSION['game_over']);
    header('Location: ./form.php');
    exit;
}

define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');
define('DATABASE', 'gamecity');
$connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

function getCityFromDB($dbconfig) {
    $listOfCities = "SELECT * FROM city ORDER BY city_id ASC";
    $query = mysqli_query($dbconfig, $listOfCities);
    while($res[] = mysqli_fetch_assoc($query)) {
        $cities = $res;
    }
    foreach($cities as $key => $val) {
        foreach($val as $key2 => $val2) {
            if($key2 == 'city_name') {
                $city[] = $val2;
            }
        }
    }
    return $city;
}

if (empty($_SESSION['cities'])) {
    $_SESSION['cities'] = getCityFromDB($connect);
}

if(!empty($_POST['send'])) {
    if (findCity($_POST['city'], $_SESSION['cities'])) {
        if (empty($_SESSION['answer'])) {
            $_SESSION['answer'] = firstStep($_POST['city'], $_SESSION['cities']);
            $temp = deleteCity($_SESSION['answer'], $_SESSION['cities']);
        }else {
            $answer = answer($_POST['city'], $_SESSION['answer'], $_SESSION['cities']);
            if($answer) {
                $_SESSION['answer'] = $answer;
                $temp = deleteCity($_SESSION['answer'], $_SESSION['cities']);
            }else {
                $_SESSION['game_over'] = 2;
            }
        }
        if(!$temp){
            $_SESSION['game_over'] = 1;
        }else {
            $_SESSION['cities'] = $temp;
        }
    }else {
        $_SESSION['incorrect_city'] = 'Некорректный город';
    }
    header('Location: /form.php');
    exit;
}

function firstStep($userCity, $arrayOfCities) {
    $temp = '';
    if(!empty($userCity)) {
        foreach ($arrayOfCities as $key => $val) {
            if(mb_strtoupper(mb_substr($userCity, -1, 1, 'utf-8')) == mb_substr($val, 0, 1, 'utf-8')) {
                $temp .= $userCity . ',' . $val;
                return $temp;
            }
        }
    }
    return false;
}

function findCity ($city, $listCities) {
    foreach($listCities as $key => $val) {
        if($val == $city) {
            return true;
        }
    }
    return false;
}

function answer($city, $answer, $arrayOfCities) {
    if(mb_substr($city, 0, 1, 'utf-8' ) == mb_strtoupper(mb_substr($answer, -1, 1, 'utf-8'))) {
        $char = mb_strtoupper(mb_substr($city, -1, 1, 'utf-8'));
        foreach($arrayOfCities as $key => $val) {
            $temp = mb_strpos($val, $char, 0,'utf-8');
            if ($temp !== false) {
                $answer .= ',' . $city . ',' . $val;
                break;
            }
        }
        return $answer;
    }
    return false;
}

function deleteCity($town, $cities) {
    if (count($cities) > 0) {
        $town = explode(',', $town);
        $cities = array_values($cities);
        for($i = 0; $i < count($town); $i++) {
            for($j = 0; $j < count($cities); $j++) {
                if($town[$i] == $cities[$j]) {
                    unset($cities[$j]);
                }
            }
        }
        return $cities;
    }
    return false;
}