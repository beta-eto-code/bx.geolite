# Bitrix GeoLite2

Пример использования:

```php
use Bx\Geolite\Facade;
use Bx\Geolocation\Services\LocationService;

$someIp = 'XXX.XXX.XXX.XXX';
$location = new LocationService();
$geoLiteService = Facade::createGeoService();
$location = $geoLiteService->getLocationByIp($location, $someIp);

$location->getLocationName();
$location->getLatitude();
$location->getLongitude();
$location->getCode();
$location->getLocationType();
```