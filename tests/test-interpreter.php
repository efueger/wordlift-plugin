<?php

/**
 * This file covers tests related to the microdata printing routines.
 */

require_once 'functions.php';

class InterpreterTest extends WP_UnitTestCase {

	/**
	 * Set up the test.
	 */
	function setUp() {
		parent::setUp();

		wl_configure_wordpress_test();
		wl_empty_blog();
		rl_empty_dataset();
	}

	function testIntepreter() {
		
		$fake_post_id = 33;
		$this->assertFalse( wl_get_meanings_for_post( $fake_post_id ) );
		$fake_slug = "foo";
		$this->assertFalse( wl_get_meanings_for_post( $fake_post_id ) );

		$real_slug = "maltempo-rischio-alluvioni-paura-pioggia";
		$post_id = wl_create_post( 'Just a content', $real_slug, $real_slug, 'publish', 'post' );

	}

}

