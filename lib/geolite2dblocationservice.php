<?php


namespace Bx\Geolite;

use Bx\Geolocation\Interfaces\LocationServiceInterface;
use Bx\Geolocation\BaseGeoLocationService;
use Exception;
use GeoIp2\Database\Reader;
use GeoIp2\ProviderInterface;
use MaxMind\Db\Reader\InvalidDatabaseException;
use Bitrix\Main\Service\GeoIp;
use Throwable;

final class GeoLite2DBLocationService extends BaseGeoLocationService
{
    /**
     * @var string
     */
    private $dbPath;
    /**
     * @var ProviderInterface
     */
    private $reader;
    /**
     * @var string
     */
    private $locale;

    /**
     * GeoLite2DBLocationService constructor.
     * @param string $dbPath
     * @param string $locale
     * @throws Exception
     */
    public function __construct(string $dbPath, string $locale = 'ru')
    {
        if (!file_exists($dbPath)) {
            throw new Exception("File db - {$dbPath} does not exists!");
        }

        $this->dbPath = $dbPath;
        $this->locale = $locale;
    }

    /**
     * @return ProviderInterface
     * @throws InvalidDatabaseException
     */
    private function getReader(): ProviderInterface
    {
        if ($this->reader instanceof ProviderInterface) {
            return $this->reader;
        }

        return $this->reader = new Reader($this->dbPath, [$this->locale]);
    }

    /**
     * @param LocationServiceInterface $locationService
     * @param string|null $ip
     * @return string
     */
    protected function getLocationName(LocationServiceInterface $locationService, string $ip = null): string
    {
        try {
            $ip = $ip ?? GeoIp\Manager::getRealIp();
            $geoData = $this->getReader()->city($ip);
        } catch (Throwable $e) {
            return '';
        }

        return $geoData->city->name ?? '';
    }
}