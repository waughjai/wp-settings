<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsMissingOptionException;
use WaughJ\WPSettings\WPSettingsPage;
use WaughJ\WPSettings\WPSettingsSection;

class WPSettingsSectionTest extends TestCase
{
	public function testGetSlug()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$this->assertEquals( 'main_scripts', $section->getSlug() );
	}

	public function testGetFullSlug()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$this->assertEquals( "{$page->getSlug()}_main_scripts", $section->getFullSlug() );
	}

	public function testGetName()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$this->assertEquals( 'Main Scripts', $section->getName() );
	}

	public function testGetPage()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$this->assertEquals( $page, $section->getPage() );
	}

	public function testMissingOption()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$this->expectException( WPSettingsMissingOptionException::class );
		$section->getOption( 'somethingdifferent' );
	}
}
