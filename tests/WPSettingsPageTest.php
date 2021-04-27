<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsOption;
use WaughJ\WPSettings\WPSettingsMissingSectionException;
use WaughJ\WPSettings\WPSettingsPage;
use WaughJ\WPSettings\WPSettingsSection;

class WPSettingsPageTest extends TestCase
{
	public function testGetSlug()
	{
		$page = WPSettingsPage::createForMain( 'design', 'Design' );
		$this->assertEquals( 'main_design', $page->getSlug() );
		$page = WPSettingsPage::createForSettings( 'main_css', 'Main CSS' );
		$this->assertEquals( 'settings_main_css', $page->getSlug() );
		$page = WPSettingsPage::createForTools( 'something-else', 'Something Else' );
		$this->assertEquals( 'tools_something-else', $page->getSlug() );
	}

	public function testGetName()
	{
		$page = WPSettingsPage::createForSettings( 'main_css', 'Main CSS' );
		$this->assertEquals( 'Main CSS', $page->getName() );
	}

	public function testOptionsGroup()
	{
		$page = WPSettingsPage::createForMain( 'design', 'Design' );
		$this->assertEquals( 'main_design_options', $page->getOptionsGroup() );
		$page = WPSettingsPage::createForSettings( 'main_css', 'Main CSS' );
		$this->assertEquals( 'settings_main_css_options', $page->getOptionsGroup() );
		$page = WPSettingsPage::createForTools( 'something-else', 'Something Else' );
		$this->assertEquals( 'tools_something-else_options', $page->getOptionsGroup() );
	}

	public function testGetType()
	{
		$page = WPSettingsPage::createForMain( 'design', 'Design' );
		$this->assertEquals( 'main', $page->getType() );
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$this->assertEquals( 'settings', $page->getType() );
		$page = WPSettingsPage::createForTheme( 'design', 'Design' );
		$this->assertEquals( 'theme', $page->getType() );
		$page = WPSettingsPage::createForTools( 'design', 'Design' );
		$this->assertEquals( 'tools', $page->getType() );
	}

	public function testBasic()
	{
		$page = WPSettingsPage::createForMain( 'design', 'Design' );
		ob_start();
		$page->render();
		$this->assertEquals
		(
			1,
			preg_match
			(
				'/\s*<div\s*class="wrap">\s*<h1>Design<\/h1>\s*<form\s*method="post"\s*action="options.php">\s*<input\s*type="submit"\s*name="submit"\s*id="submit"\s*class="button button-primary"\s*value="Save Changes"\s*\/*>\s*<\/form>\s*<\/div>\s*/',
				ob_get_clean()
			)
		);
	}

	public function testWithSections()
	{
		$page = WPSettingsPage::createForMain( 'design', 'Design' );
		$page->addSection( 'main_scripts', 'Main Scripts' );
		$this->assertEquals( new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' ), $page->getSection( 'main_scripts' ) );
	}

	public function testMissingSection()
	{
		$page = WPSettingsPage::createForMain( 's', 'S' );
		$this->expectException( WPSettingsMissingSectionException::class );
		$page->getSection( 'imnothere' );
	}

	public function testWithOptions()
	{
		$page = WPSettingsPage::createForMain( 'design', 'Design' );
		$page->addSection( 'main_scripts', 'Main Scripts' );
		$section = $page->getSection( 'main_scripts' );
		$section->addOption( 'main_css', 'Main CSS' );
		$page->register();
		ob_start();
		$page->render();
		$this->assertEquals
		(
			1,
			preg_match
			(
				'/\s*<div\s*class="wrap">\s*<h1>Design<\/h1>\s*<form\s*method="post"\s*action="options.php">\s*<input\s*type="text"\s*id="main_design_main_scripts_main_css"\s*name="main_design_options\[main_design_main_scripts_main_css\]"\s*placeholder="Main CSS"\s*value=""\s*\/*>\s*<input\s*type="submit"\s*name="submit"\s*id="submit"\s*class="button button-primary"\s*value="Save Changes"\s*\/*>\s*<\/form>\s*<\/div>\s*/',
				ob_get_clean()
			)
		);
		$section_ref_2 = $page->getSection( 'main_scripts' );
		$this->assertEquals
		(
			// Using different references for both and a third for what originally got the option,
			// but all can access the option.
			new WPSettingsOption( $section_ref_2, 'main_css', 'Main CSS' ),
			$page->getSection( 'main_scripts' )->getOption( 'main_css' )
		);
	}
}
