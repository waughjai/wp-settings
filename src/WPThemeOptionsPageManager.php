<?php

declare( strict_types = 1 );
namespace WaughJ\WPThemeOption
{
	use WaughJ\WPThemeOption\WPThemeOptionsPage;

	class WPThemeOptionsPageManager
	{
		public static function initializeIfNotAlreadyInitialized( string $slug, string $title ) : WPThemeOptionsPage
		{
			if ( !isset( self::$pages[ $slug ] ) )
			{
				self::$pages[ $slug ] = new WPThemeOptionsPage( $slug, $title );
			}
			return self::$pages[ $slug ];
		}

		public static function get( string $slug )
		{
			return ( isset( self::$pages[ $slug ] ) ) ? self::$pages[ $slug ] : null;
		}

		private static $pages = [];
	}
}
