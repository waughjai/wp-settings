<?php

declare( strict_types = 1 );
namespace WaughJ\WPThemeOption
{
	use function WaughJ\TestHashItem\TestHashItemExists;
	use WaughJ\VerifiedArgumentsSameType\VerifiedArgumentsSameType;

	class WPThemeOption
	{
		public function __construct( WPThemeOptionsSection $section, string $slug, string $name, array $other_attributes = [] )
		{
			$this->section = $section;
			$this->slug = $slug;
			$this->name = __( $name, 'textdomain' );
			$this->other_attributes = new VerifiedArgumentsSameType( $other_attributes, self::DEFAULT_ATTRIBUTES );
			add_action( 'admin_init', [ $this, 'register' ] );
		}

		public function register()
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
		}

		public function render() : void
		{
			switch ( $this->other_attributes->get( 'input_type' ) )
			{
				case( 'checkbox' ):
				{
					$checked_text = ( $this->getOptionValue() ) ? ' checked="checked"' : '';
					?><input type="checkbox" id="<?= $this->slug; ?>" name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->slug; ?>]"<?= $checked_text; ?> /><?php
				}
				break;

				default:
				{
					?><input type="text" id="<?= $this->slug; ?>" name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->slug; ?>]" placeholder="<?= $this->name; ?>" value="<?= $this->getOptionValue(); ?>" /><?php
				}
				break;
			}
		}

		public function getOptionValue() : string
		{
			$options = get_option( $this->section->getPage()->getOptionsGroup() );
			return ( is_array( $options ) )
				? TestHashItemExists( $options, $this->slug, '' )
				: ( string )( $options );
		}

		const DEFAULT_ATTRIBUTES =
		[
			'input_type' => 'text'
		];

		private $page;
		private $section;
		private $slug;
		private $name;
		private $other_attributes;
	}
}
