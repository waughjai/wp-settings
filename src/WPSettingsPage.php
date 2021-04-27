<?php

declare( strict_types = 1 );
namespace WaughJ\WPSettings;

use WaughJ\VerifiedArguments\VerifiedArguments;

class WPSettingsPage
{
	// Factory functions.
	// Only use these for creating subpages.
	public static function createForMain( string $slug, string $name, array $otherAttributes = [] ) : WPSettingsPage
	{
		return new WPSettingsPage( 'add_menu_page', 'main', $slug, $name, $otherAttributes );
	}

	public static function createForSettings( string $slug, string $name, array $otherAttributes = [] ) : WPSettingsPage
	{
		return new WPSettingsPage( 'add_options_page', 'settings', $slug, $name, $otherAttributes );
	}

	public static function createForTools( string $slug, string $name, array $otherAttributes = [] ) : WPSettingsPage
	{
		return new WPSettingsPage( 'add_management_page', 'tools', $slug, $name, $otherAttributes );
	}

	public static function createForTheme( string $slug, string $name, array $otherAttributes = [] ) : WPSettingsPage
	{
		return new WPSettingsPage( 'add_theme_page', 'theme', $slug, $name, $otherAttributes );
	}

	public function addSection( string $slug, string $name ) : void
	{
		$this->sections[ $slug ] = new WPSettingsSection( $this, $slug, $name );
	}

	public function register() : void
	{
		foreach ( $this->sections as $section )
		{
			$section->register();
		}
		add_action
		(
			'admin_menu',
			function()
			{
				call_user_func
				(
					$this->function,
					$this->name,
					$this->name,
					$this->otherAttributes->get( 'capability' ),
					$this->slug,
					$this->otherAttributes->get( 'render' )
				);
			}
		);
		add_action
		(
			'admin_init',
			function()
			{
				if ( get_option( $this->getOptionsGroup() ) == false )
				{
					add_option( $this->getOptionsGroup() );
				}
		
				register_setting
				(
					$this->getOptionsGroup(),
					$this->getOptionsGroup()
				);
			}
		);
	}

	public function getOptionsGroup() : string
	{
		return "{$this->slug}_options";
	}

	public function getSlug() : string
	{
		return $this->slug;
	}

	public function getName() : string
	{
		return $this->name;
	}

	public function getType() : string
	{
		return $this->type;
	}

	// Make sure this is a reference so it can be changed & have its changes propagate back here.
	public function &getSection( string $slug ) : WPSettingsSection
	{
		if ( !array_key_exists( $slug, $this->sections ) )
		{
			throw new WPSettingsMissingSectionException( $this, $slug );
		}
		return $this->sections[ $slug ];
	}

	public function render() : void
	{
		call_user_func( $this->otherAttributes->get( 'render' ) );
	}

	private function __construct( string $function, string $type, string $slug, string $name, array $otherAttributes = [] )
	{
		$this->function = $function;
		$this->type = $type;
		$this->slug = "{$type}_" . sanitize_title( $slug );
		$this->name = __( sanitize_text_field( $name ), 'textdomain' );
		$this->otherAttributes = new VerifiedArguments( $otherAttributes, $this->generateArgumentDefaults() );
		$this->sections = [];
	}

	private function generateArgumentDefaults() : array
	{
		return [
			'capability' => [ 'value' => 'manage_options', 'type' => 'string', 'sanitize' => 'sanitize_title' ],
			'render' =>
			[
				'value' => function()
				{
					?>
						<div class="wrap">
							<h1><?= $this->name; ?></h1>
							<?php settings_errors(); ?>
							<form method="post" action="options.php">
								<?php settings_fields( $this->getOptionsGroup() ); ?>
								<?php do_settings_sections( $this->getOptionsGroup() ); ?>
								<?php submit_button(); ?>
							</form>
						</div>
					<?php
				},
				'type' => \Closure::class
			]
		];
	}

	private string $function;
	private string $type;
	private string $slug;
	private string $name;
	private VerifiedArguments $otherAttributes;
	private array $sections;
}