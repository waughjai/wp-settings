<?php

declare( strict_types = 1 );
namespace WaughJ\WPSettings
{
	use WaughJ\WPSettings\WPSettingsSubPage;

	class WPThemeSettingsSubPage extends WPSettingsSubPage
	{
		public function __construct( string $slug, string $name, string $capability = WPSettingsSubPage::DEFAULT_CAPABILITY )
		{
			parent::__construct( self::TYPE, $slug, $name, $capability );
		}

		const TYPE = 'theme';
	}
}
