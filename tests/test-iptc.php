<?php

/**
 * This file covers tests related to the microdata printing routines.
 */

require_once 'functions.php';

class IptcTest extends WP_UnitTestCase {

	/**
	 * Set up the test.
	 */
	function setUp() {
		parent::setUp();

		wl_configure_wordpress_test();
		wl_empty_blog();
		rl_empty_dataset();
	}

	function testSplitIptcCode() {

		// Test a third level code
		$this->assertEquals( 
			array("01000000", "01022000", "01022001"), 
			wl_split_iptc_code("01022001") 
		);

		// Test a second level code
		$this->assertEquals( 
			array("01000000", "01022000"), 
			wl_split_iptc_code("01022000") 
		);

		// Test a first level code
		$this->assertEquals( 
			array("01000000"), 
			wl_split_iptc_code("01000000") 
		);

		// Test a wrong code
		$this->assertEquals( 
			array(), 
			wl_split_iptc_code("01a00000") 
		);
	}

	function testSplitLabel() {

		// Test a third level code
		$this->assertEquals( 
			array("Ambiente", "Risorse naturali", "Risorse Energetiche"), 
			wl_split_iptc_label("Ambiente - Risorse naturali - Risorse Energetiche") 
		);

	}

	function testAddIptcClassificationToPost() {

		// Create a fake post
		$post_id = wl_create_post( "Just a post", 'post-1', 'Post 1', 'publish', 'post' );
		$this->assertEquals( 0, count( wp_get_post_terms( $post_id, "iptc" ) ) );
		// Add an iptc classification to the post
		wl_add_iptc_classification_to_post( $post_id, 
			"Ambiente - Risorse naturali - Risorse Energetiche", "06006009" );
		$this->assertEquals( 1, count( wp_get_post_terms( $post_id, "iptc" ) ) );
		// Get related terms
		$terms = wp_get_post_terms( $post_id, "iptc" );
		$this->assertEquals( "Risorse Energetiche", $terms[0]->name );
		$this->assertEquals( "06006009", $terms[0]->slug );
		// Check ancestors
		$ancestors = get_ancestors( intval( $terms[0]->term_id ), "iptc");
		$this->assertEquals( 2, count($ancestors) );
		$parent = get_term( $ancestors[0], "iptc" );
		$this->assertEquals( "Risorse naturali", $parent->name );
		$this->assertEquals( "06006000", $parent->slug );
		$ancestor = get_term( $ancestors[1], "iptc" );
		$this->assertEquals( "Ambiente", $ancestor->name );
		$this->assertEquals( "06000000", $ancestor->slug );
		$this->assertEquals( 0, $ancestor->parent );
			
	}
		
}

