<?php


namespace Bx\Geolite;


use Bitrix\Main\Config\Option;
use Bitrix\Main\Application;
use Bx\Geolocation\Interfaces\GeolocationServiceInterface;

class Facade
{
    public static function createGeoService(): GeolocationServiceInterface
    {
        $lid = Application::getInstance()->getContext()->getLanguage();
        $dbPath = Option::get('bx.geolite', 'GEOLITE2DB_PATH', '');
        return new GeoLite2DBLocationService($dbPath, $lid);
    }
}