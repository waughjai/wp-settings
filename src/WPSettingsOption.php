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
					$this->slug,
					$this->name,
					[ $this, 'render' ],
					$this->section->getPage()->getOptionsGroup(),
					$this->section->getSlug(),
					[ 'label_for' => $this->slug ]
				);
				register_setting( $this->section->getPage()->getOptionsGroup(), $this->slug );
			}
		);
	}

	public function getValue() : string
	{
		$options = get_option( $this->section->getPage()->getOptionsGroup() );
		return ( is_array( $options ) )
			? ( $options[ $this->slug ] ?? '' )
			: ( string )( $options );
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
							type="checkbox" id="<?= $this->slug; ?>"
							name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->slug; ?>]"
							<?= $checked_text; ?>
						/>
					<?php
				}
				break;
				case( 'textarea' ):
				{
					?>
						<textarea
							id="<?= $this->slug; ?>"
							name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->slug; ?>]"
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
						[ 'id' => $this->slug, 'name' => $this->section->getPage()->getOptionsGroup() . '[' . $this->slug . ']' ]
					);
				}
				break;
				default: // text
				{
					?>
						<input
							type="<?= $this->otherAttributes->get( 'input_type' ); ?>"
							id="<?= $this->slug; ?>"
							name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->slug; ?>]"
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
