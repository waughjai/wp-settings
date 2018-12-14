<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPThemeOption\WPThemeOptionsPage;
use WaughJ\WPThemeOption\WPThemeOptionsPageManager;

class WPThemeOptionsPageManagerTest extends TestCase
{
	public function testStart()
	{
		$this->assertEquals( null, WPThemeOptionsPageManager::get( 'design' ) );
	}

	public function testBasic()
	{
		$page = WPThemeOptionsPageManager::initializeIfNotAlreadyInitialized( 'design', 'Design' );
		$this->assertEquals( new WPThemeOptionsPage( 'design', 'Design' ), $page );
	}

	public function testStillWorks()
	{
		$this->assertEquals( new WPThemeOptionsPage( 'design', 'Design' ), WPThemeOptionsPageManager::get( 'design' ) );
	}
}
