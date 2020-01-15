<?php

declare( strict_types = 1 );
namespace WaughJ\WPSettings;

class WPSettingsSubPage
{
	public function __construct( string $type, string $slug, string $name, string $capability = self::DEFAULT_CAPABILITY )
	{
		$this->type = $type;
		$this->slug = "{$type}_{$slug}";
		$this->name = __( $name, 'textdomain' );
		$this->capability = $capability;
	}

	public function submit() : void
	{
		add_action( 'admin_menu', [ $this, 'addPage' ] );
		add_action( 'admin_init', [ $this, 'registerSetting' ] );
	}

	public function addPage() : void
	{
		call_user_func( $this->getAddPageFunction(), $this->name, $this->name, $this->capability, $this->slug, [ $this, 'render' ] );
	}

	public function registerSetting() : void
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

	public function getOptionsGroup() : string
	{
		return "{$this->slug}_options";
	}

	public function render() : void
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
	}

	public function getSlug() : string
	{
		return $this->slug;
	}

	public function getName() : string
	{
		return $this->name;
	}

	public function getAddPageFunction() : string
	{
		if ( !array_key_exists( $this->type, self::TYPE_ADD_PAGE_FUNCTIONS ) )
		{
			throw new \Exception( "Invalid type for WPSettingsSubPage: {$this->type}" );
		}
		return self::TYPE_ADD_PAGE_FUNCTIONS[ $this->type ];
	}

	public const DEFAULT_CAPABILITY = 'manage_options';

	private $type;
	private $slug;
	private $name;
	private $capability;

	private const TYPE_ADD_PAGE_FUNCTIONS =
	[
		'settings' => 'add_options_page',
		'tools' => 'add_management_page',
		'theme' => 'add_theme_page'
	];
}