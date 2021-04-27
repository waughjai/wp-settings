<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsOption;
use WaughJ\WPSettings\WPSettingsPage;
use WaughJ\WPSettings\WPSettingsSection;

class WPGeneralSettingsSubPageTest extends TestCase
{
	public function testOptionsGroup()
	{
		$page = WPSettingsPage::createForMain( 'design', 'Design' );
		$this->assertEquals( 'main_design_options', $page->getOptionsGroup() );
	}

	public function testBasic()
	{
		$page = WPSettingsPage::createForMain( 'design', 'Design' );
		ob_start();
		$page->render();
		$html = ob_get_clean();
		$this->assertStringContainsString( '<div class="wrap">', $html );
		$this->assertStringContainsString( '<h1>Design</h1>', $html );
		$this->assertStringContainsString( '<form method="post" action="options.php">', $html );
		$this->assertStringContainsString( '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">', $html );
	}

	public function testWithOptions()
	{
		$page = WPSettingsPage::createForMain( 'design', 'Design' );
		$page->addSection( 'main_scripts', 'Main Scripts' );
		$page->getSection( 'main_scripts' )->addOption( 'main_css', 'Main CSS' );
		$page->register();
		ob_start();
		$page->render();
		$this->assertEquals
		(
			1,
			preg_match
			(
				'/\s*<div\s*class="wrap">\s*<h1>Design<\/h1>\s*<form\s*method="post"\s*action="options.php">\s*<input\s*type="text"\s*id="main_css"\s*name="main_design_options\[main_css\]"\s*placeholder="Main CSS"\s*value=""\s*\/*>\s*<input\s*type="submit"\s*name="submit"\s*id="submit"\s*class="button button-primary"\s*value="Save Changes"\s*\/*>\s*<\/form>\s*<\/div>\s*/',
				ob_get_clean()
			)
		);
	}
}
