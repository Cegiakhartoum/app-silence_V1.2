<?php

namespace App\Services;

class MixPanelTrackingService implements TrackingInterface
{
    private $mixPanel;
    
    public function __construct() 
    {
      
        $mixPanelToken = config('services.mix_panel.token');
        $this->mixPanel = Mixpanel::getInstance($mixPanelToken);

    }

    public function trackEvent(string $name, array $options)
    {
        $this->mixPanel->track($name, $options);

    }
}