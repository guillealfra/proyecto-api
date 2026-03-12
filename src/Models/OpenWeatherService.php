<?php
require_once '../Views/view.php';

class OpenWeatherService {
    public static function buscarCiudad($ciudad) {
        $API_KEY = getenv('API_KEY');
        $limite = "6";
        
        if (!$API_KEY) {
            throw new Exception('No se encuentra la API');
        }

        $url = "http://api.openweathermap.org/geo/1.0/direct?q=".urlencode($ciudad)."&limit=".$limite."&appid=".$API_KEY;

        $res = file_get_contents($url);
        $data = json_decode($res, true);

        return $data;
    }
    public static function tiempoActualCiudad($lat, $lon) {
        $API_KEY = getenv('API_KEY');
        
        if (!$API_KEY) {
            throw new Exception('No se encuentra la API');
        }

        $url = "https://api.openweathermap.org/data/2.5/weather?lat=".$lat."&lon=".$lon."&appid=".$API_KEY."&units=metric&lang=es";

        $res = file_get_contents($url);
        $data = json_decode($res, true);

        return $data;
    }

    public static function tiempoSemanalCiudad($lat, $lon) {
        $API_KEY = getenv('API_KEY');
        
        if (!$API_KEY) {
            throw new Exception('No se encuentra la API');
        }

        $url = "https://api.openweathermap.org/data/2.5/forecast?lat=".$lat."&lon=".$lon."&appid=".$API_KEY."&units=metric&lang=es";

        $res = file_get_contents($url);
        $data = json_decode($res, true);

        return $data;
    }

}

?>