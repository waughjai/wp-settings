<?php
declare( strict_types = 1 );
namespace WaughJ\WPSettings
{
	use WaughJ\HTMLSelect\HTMLSelect;
	use function WaughJ\TestHashItem\TestHashItemExists;
	use WaughJ\VerifiedArguments\VerifiedArguments;

	class WPSettingsOption
	{
		public function __construct( WPSettingsSection $section, string $slug, string $name, array $other_attributes = [] )
		{
			$this->section = $section;
			$this->slug = $slug;
			$this->name = __( $name, 'textdomain' );
			$this->other_attributes = new VerifiedArguments( $other_attributes, self::DEFAULT_ATTRIBUTES );
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
			if ( $this->other_attributes->get( 'custom_render' ) !== null )
			{
				$this->other_attributes->get( 'custom_render' )( $this );
			}
			else
			{
				switch ( $this->other_attributes->get( 'input_type' ) )
				{
					case( 'checkbox' ):
					{
						$checked_text = ( $this->getOptionValue() ) ? ' checked="checked"' : '';
						?><input type="checkbox" id="<?= $this->slug; ?>" name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->slug; ?>]"<?= $checked_text; ?> /><?php
					}
					break;
					case( 'textarea' ):
					{
						?><textarea id="<?= $this->slug; ?>" name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->slug; ?>]"><?= $this->getOptionValue(); ?></textarea><?php
					}
					break;
					case( 'select' ):
					{
						$options = $this->other_attributes->get( 'select_options' );
						$number_of_options = count( $options );
						for ( $i = 0; $i < $number_of_options; $i++ )
						{
							if ( $this->getOptionValue() === $options[ $i ][ 'value' ] )
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
					default:
					{
						?><input type="<?= $this->other_attributes->get( 'input_type' ); ?>" id="<?= $this->slug; ?>" name="<?= $this->section->getPage()->getOptionsGroup(); ?>[<?= $this->slug; ?>]" placeholder="<?= $this->name; ?>" value="<?= $this->getOptionValue(); ?>" /><?php
					}
					break;
				}
			}
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
		private $other_attributes;

		private const DEFAULT_ATTRIBUTES =
		[
			'input_type' => [ "type" => "string", "value" => "text" ],
			'custom_render' => [ "type" => \Closure::class, "value" => null ]
		];
	}
}
