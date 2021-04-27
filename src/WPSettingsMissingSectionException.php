<?php

declare( strict_types = 1 );
namespace WaughJ\WPSettings;

class WPSettingsMissingSectionException extends \Exception
{
    public function __construct( WPSettingsPage $page, string $sectionSlug )
    {
        parent::__construct
        (
            "Trying to access missing section in WPSettings page: page “{$page->getName()}” does not have section with slug “{$sectionSlug}”.",
            0,
            null
        );
    }
}