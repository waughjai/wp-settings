<?php

declare( strict_types = 1 );
namespace WaughJ\WPThemeOption
{
	use function WaughJ\TestHashItem\TestHashItemExists;

	class WPThemeOption
	{
		public function __construct( WPThemeOptionsSection $section, string $slug, string $name )
		{
			$this->section = $section;
			$this->slug = $slug;
			$this->name = __( $name, 'textdomain' );
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
			?><input type="text" id="<?= $this->slug; ?>" name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->slug; ?>]" placeholder="<?= $this->name; ?>" value="<?= $this->getOptionValue(); ?>" /><?php
		}

		public function getOptionValue() : string
		{
			$options = get_option( $this->section->getPage()->getOptionsGroup() );
			return ( is_array( $options ) )
				? TestHashItemExists( $options, $this->slug, '' )
				: ( string )( $options );
		}

		private $page;
		private $section;
		private $slug;
		private $name;
	}
}
