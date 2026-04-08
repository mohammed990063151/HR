<?php

namespace App\Services;

class GeolocationService
{
    /**
     * Haversine distance in meters between two WGS84 points.
     */
    public function distanceMeters(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earth = 6371000;
        $φ1 = deg2rad($lat1);
        $φ2 = deg2rad($lat2);
        $Δφ = deg2rad($lat2 - $lat1);
        $Δλ = deg2rad($lng2 - $lng1);

        $a = sin($Δφ / 2) ** 2 + cos($φ1) * cos($φ2) * sin($Δλ / 2) ** 2;

        return $earth * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    public function isWithinRadius(float $lat, float $lng, float $centerLat, float $centerLng, float $radiusMeters): bool
    {
        return $this->distanceMeters($lat, $lng, $centerLat, $centerLng) <= $radiusMeters;
    }
}
