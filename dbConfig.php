<?php
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
?>