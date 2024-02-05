<?php

namespace App\Services;

interface TrackingInterface
{
    public function trackEvent(string $name, array $options);
}