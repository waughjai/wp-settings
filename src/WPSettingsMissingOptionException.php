<?php

declare( strict_types = 1 );
namespace WaughJ\WPSettings;

class WPSettingsMissingOptionException extends \Exception
{
    public function __construct( WPSettingsSection $section, string $optionSlug )
    {
        parent::__construct
        (
            "Trying to access missing option in WPSettings section: section “{$section->getName()}” from page “{$section->getPage()->getName()}” does not have an option with slug “{$optionSlug}”.",
            0,
            null
        );
    }
}