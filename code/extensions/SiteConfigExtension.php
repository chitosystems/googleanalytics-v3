<?php

namespace ChitoSystems\GoogleAnalytics\Extensions;

use DataExtension;
use FieldList;
use TextField;
use Tab;
use SiteConfig;

class SiteConfigExtension extends DataExtension
{

    private static $db = [
        'MeasurementID'           => 'Varchar',
        'GoogleAnalyticsLiteCode' => 'Varchar',
        //'SnippetPlacement'        => 'Enum("Footer,Head","Footer")',
    ];

    public function updateCMSFields(FieldList $fields)
    {

        $fields->addFieldToTab("Root", new Tab('GoogleAnalytics'));
        $fields->addFieldsToTab('Root.GoogleAnalyticsLite', [
            TextField::create("MeasurementID", 'Measurement-ID')->setDescription("(G--XXXXXXX)"),
            TextField::create("GoogleAnalyticsLiteCode")->setTitle("Google Analytics Code")->setDescription("(UA-XXXXXX-X)"),
        ]);

    }

    /**
     * Return various configuration values
     *
     * @param $key
     *
     * @return bool
     */
    public static function get_google_config($key)
    {
        if ( class_exists('SiteConfig') && SiteConfig::has_extension('GoogleAnalyticsLiteConfig') ) {
            $config = SiteConfig::current_site_config();
            switch ( $key ) {
                case 'code':
                    return $config->GoogleAnalyticsLiteCode ?: false;
                case 'placement':
                    return $config->SnippetPlacement ?: false;
            }

        }

        return false;


    }

}