<?php

declare( strict_types = 1 );
namespace WaughJ\WPSettings;

use WaughJ\HTMLSelect\HTMLSelect;
use WaughJ\VerifiedArguments\VerifiedArguments;

class WPSettingsOption
{
	public function __construct( WPSettingsSection $section, string $slug, string $name, array $otherAttributes = [] )
	{
		$this->section = $section;
		$this->slug = sanitize_title( $slug );
		$this->name = __( sanitize_text_field( $name ), 'textdomain' );
		$this->otherAttributes = new VerifiedArguments( $otherAttributes, self::DEFAULT_ATTRIBUTES );
	}

	public function register() : void
	{
		add_action
		(
			'admin_init',
			function()
			{
				add_settings_field
				(
					$this->getFullSlug(),
					$this->name,
					[ $this, 'render' ],
					$this->section->getPage()->getOptionsGroup(),
					$this->section->getFullSlug(),
					[ 'label_for' => $this->getFullSlug() ]
				);
				register_setting( $this->section->getPage()->getOptionsGroup(), $this->getFullSlug() );
			}
		);
	}

	public function getValue() : string
	{
		$options = get_option( $this->section->getPage()->getOptionsGroup() );
		return ( is_array( $options ) )
			? ( $options[ $this->getFullSlug() ] ?? '' )
			: ( string )( $options );
	}

	public function getSlug() : string
	{
		return $this->slug;
	}

	public function getFullSlug() : string
	{
		return "{$this->section->getFullSlug()}_{$this->slug}";
	}

	public function getName() : string
	{
		return $this->name;
	}

	public function render() : void
	{
		if ( $this->otherAttributes->get( 'custom_render' ) !== null )
		{
			$this->otherAttributes->get( 'custom_render' )( $this );
		}
		else
		{
			$value = ( $this->otherAttributes->get( 'autoincrement' ) === true )
				?
				(
					( $this->getValue() === '' || $this->getValue() === null )
						? 0
						: intval( $this->getValue() ) + 1
				)
				: $this->getValue();

			switch ( $this->otherAttributes->get( 'input_type' ) )
			{
				case( 'checkbox' ):
				{
					$checked_text = ( $value ) ? ' checked="checked"' : '';
					?>
						<input
							type="checkbox" id="<?= $this->getFullSlug(); ?>"
							name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->getFullSlug(); ?>]"
							<?= $checked_text; ?>
						/>
					<?php
				}
				break;
				case( 'textarea' ):
				{
					?>
						<textarea
							id="<?= $this->getFullSlug(); ?>"
							name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->getFullSlug(); ?>]"
							rows="10"
							style="width:100%"><?= $value; ?></textarea>
					<?php
				}
				break;
				case( 'select' ):
				{
					$options = $this->otherAttributes->get( 'select_options' );
					$numberOfOptions = count( $options );
					for ( $i = 0; $i < $numberOfOptions; $i++ )
					{
						if ( $value === $options[ $i ][ 'value' ] )
						{
							$options[ $i ][ 'selected' ] = true;
						}
					}

					echo new HTMLSelect
					(
						$options,
						[ 'id' => $this->getFullSlug(), 'name' => $this->section->getPage()->getOptionsGroup() . '[' . $this->getFullSlug() . ']' ]
					);
				}
				break;
				default: // text
				{
					?>
						<input
							type="<?= $this->otherAttributes->get( 'input_type' ); ?>"
							id="<?= $this->getFullSlug(); ?>"
							name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->getFullSlug(); ?>]"
							placeholder="<?= $this->name; ?>"
							value="<?= $value; ?>"
						/>
					<?php
				}
				break;
			}
		}
	}

	private WPSettingsSection $section;
	private string $slug;
	private string $name;
	private VerifiedArguments $otherAttributes;

	private const DEFAULT_ATTRIBUTES =
	[
		'input_type' => [ "type" => "string", "value" => "text", "sanitize" => "sanitize_title" ],
		'custom_render' => [ "type" => \Closure::class, "value" => null ]
	];
}
