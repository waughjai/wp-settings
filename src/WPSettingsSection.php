<?php

declare( strict_types = 1 );
namespace WaughJ\WPSettings;

class WPSettingsSection
{
	public function __construct( WPSettingsPage $page, string $slug, string $name )
	{
		$this->page = $page;
		$this->slug = sanitize_title( $slug );
		$this->name = __( sanitize_text_field( $name ), 'textdomain' );
		$this->options = [];
	}

	public function register() : void
	{
		foreach ( $this->options as $option )
		{
			$option->register();
		}
		add_action
		(
			'admin_init',
			function()
			{
				add_settings_section
				(
					$this->slug,
					$this->name,
					function() {},
					$this->page->getOptionsGroup()
				);
			}
		);
	}

	public function addOption( string $slug, string $name, array $otherAttributes = [] ) : void
	{
		$this->options[ $slug ] = new WPSettingsOption( $this, $slug, $name, $otherAttributes );
	}

	public function getPage() : WPSettingsPage
	{
		return $this->page;
	}

	public function getSlug() : string
	{
		return $this->slug;
	}

	public function getName() : string
	{
		return $this->name;
	}

	private WPSettingsPage $page;
	private string $slug;
	private string $name;
	private array $options;
}