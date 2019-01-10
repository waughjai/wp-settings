<?php

declare( strict_types = 1 );
namespace WaughJ\WPSettings
{
	use WaughJ\WPSettings\WPSettingsSubPage;

	class WPSettingsSubPageManager
	{
		public static function initializeIfNotAlreadyInitialized( string $type, string $slug, string $title ) : WPSettingsSubPage
		{
			if ( !isset( self::$pages[ $type ] ) )
			{
				self::$pages[ $type ] = [];
			}
			if ( !isset( self::$pages[ $type ][ $slug ] ) )
			{
				self::$pages[ $type ][ $slug ] = new WPSettingsSubPage( $type, $slug, $title );
			}
			return self::$pages[ $type ][ $slug ];
		}

		public static function get( string $type, string $slug )
		{
			return ( isset( self::$pages[ $type ] ) && isset( self::$pages[ $type ][ $slug ] ) ) ? self::$pages[ $type ][ $slug ] : null;
		}

		private static $pages = [];
	}
}
