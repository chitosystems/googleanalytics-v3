<?php

namespace ChitoSystems\GoogleAnalytics\Extensions;

use Extension;
use DevelopmentAdmin;
use DatabaseAdmin;
use DevBuildController;
use SiteConfig;
use Requirements;
use ArrayData;

class PageControllerExtension extends Extension
{

    public function onAfterInit()
    {
        if (
            $this->owner instanceof DevelopmentAdmin ||
            $this->owner instanceof DatabaseAdmin ||
            ( class_exists('DevBuildController') && $this->owner instanceof DevBuildController )
        ) {
            return;
        }
        $code = null;
        $config = SiteConfig::current_site_config();
        if ( $config->MeasurementID ) {
            $template = 'GoogleAnalyticsMeasurementIDSnippet';
            $code = $config->MeasurementID;
        } elseif ( $config->GoogleAnalyticsLiteCode ) {
            $template = 'GoogleAnalyticsLiteJSSnippet';
            $code = $config->GoogleAnalyticsLiteCode;
        }

        if ( !empty($code) ) {
            $snippetHtml = ArrayData::create([
                'Code' => $code,
            ])->renderWith($template);
            Requirements::insertHeadTags($snippetHtml->Value);
        }

    }


}