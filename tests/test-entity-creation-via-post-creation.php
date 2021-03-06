<?php

/**
 * This file covers tests related entity creation via post creation.
 */

require_once 'functions.php';

class EntityCreationViaPostCreationTest extends WP_UnitTestCase {

	/**
	 * Set up the test.
	 */
	function setUp() {
		parent::setUp();

		wl_configure_wordpress_test();
		wl_empty_blog();
		rl_empty_dataset();
	}

	// This test simulate the standard workflow from disambiguation widget:
	// A create a post having in $_POST one external entity related as 'what'
	// Please notice here the entity is properly referenced by post content
	function testEntityIsCreatedAndLinkedToThePost() {

		$fake = $this->prepareFakeGlobalPostArrayFromFile(
			'/assets/fake_global_post_array_with_one_entity_linked_as_what.json' 
		);
		$_POST = $fake;
		// Retrieve the entity uri (the first key in wl_entities associative aray)
		$original_entity_uri = current( array_keys ( $fake['wl_entities' ] ) );
		// Reference the entity to the post content 
		$content    = <<<EOF
    <span itemid="$original_entity_uri">My entity</span>
EOF;
		// Be sure that the entity does not exist yet
		$entity = wl_get_entity_post_by_uri( $original_entity_uri );
		$this->assertNull( $entity );
		// Create a post referincing to the created entity
		$post_id = wl_create_post( $content, 'my-post', 'A post' , 'draft');
		// Here the entity should be created instead
		$entity = wl_get_entity_post_by_uri( $original_entity_uri );
		$this->assertNotNull( $entity );
		// Here the original uri should be properly as same_as 
		$same_as = wl_schema_get_value( $entity->ID, 'sameAs' );
		$this->assertContains( $original_entity_uri, $same_as );
		// The entity url should be the same we expect
		$raw_entity = current( array_values ( $fake['wl_entities' ] ) );
		$expected_entity_uri = $this->buildEntityUriForLabel( $raw_entity['label'] );
		$entity_uri = wl_get_entity_uri( $entity->ID );
		$this->assertEquals( $entity_uri, $expected_entity_uri );
		
		// And it should be related to the post as what predicate
		$related_entity_ids = wl_core_get_related_entity_ids( $post_id, array( "predicate" => "what" ) );
		$this->assertCount( 1, $related_entity_ids );
		$this->assertContains( $entity->ID, $related_entity_ids );
		// Ensure there are no other relation instances
		$relation_instances = wl_tests_get_relation_instances_for( $post_id ); 
		$this->assertCount( 1, $relation_instances );
		
	}

	// Same test of the previous one but with escaped chars in the entity label
	function testNewEntityWithEscapedCharsIsCreatedAndLinkedToThePost() {

		$fake = $this->prepareFakeGlobalPostArrayFromFile(
			'/assets/fake_global_post_array_with_a_new_entity_linked_with_escaped_chars.json' 
		);
		$_POST = $fake;
		// Retrieve the entity uri (the first key in wl_entities associative aray)
		$entity_uri = current( array_keys ( $fake['wl_entities' ] ) );
		// Retrieve the label 
		$raw_entity = current( array_values ( $fake['wl_entities' ] ) );
		$expected_entity_uri = $this->buildEntityUriForLabel( $raw_entity['label'] );
		// Reference the entity to the post content 
		$content    = <<<EOF
    <span itemid="$entity_uri">My entity</span>
EOF;
		// Be sure that the entity does not exist yet
		$entity = wl_get_entity_post_by_uri( $expected_entity_uri );		
		
		$this->assertNull( $entity );
		// Create a post referincing to the created entity
		$post_id = wl_create_post( $content, 'my-post', 'A post' , 'draft');
		// Here the entity should be created instead
		$entity = wl_get_entity_post_by_uri( $expected_entity_uri );
		$this->assertNotNull( $entity );

		// Check if the content was properly fixed
		$expected_content = <<<EOF
    <span itemid="$expected_entity_uri">My entity</span>
EOF;
		$post = get_post( $post_id );
		$this->assertEquals( $post->post_content, $expected_content );
		// And it should be related to the post as what predicate
		$related_entity_ids = wl_core_get_related_entity_ids( $post_id, array( "predicate" => "who" ) );
		$this->assertCount( 1, $related_entity_ids );
		$this->assertContains( $entity->ID, $related_entity_ids );
		// Ensure there are no other relation instances
		$relation_instances = wl_tests_get_relation_instances_for( $post_id ); 
		$this->assertCount( 1, $relation_instances );
		
	}

	// Same test of the previous one but with utf8 chars in the entity label
	function testNewEntityWithUtf8CharsIsCreatedAndLinkedToThePost() {

		$fake = $this->prepareFakeGlobalPostArrayFromFile(
			'/assets/fake_global_post_array_with_a_new_entity_linked_with_utf8_chars.json' 
		);
		$_POST = $fake;
		// Retrieve the entity uri (the first key in wl_entities associative aray)
		$entity_uri = current( array_keys ( $fake['wl_entities' ] ) );
		// Retrieve the label 
		$raw_entity = current( array_values ( $fake['wl_entities' ] ) );
		$expected_entity_uri = $this->buildEntityUriForLabel( $raw_entity['label'] );
		// Reference the entity to the post content 
		$content    = <<<EOF
    <span itemid="$entity_uri">My entity</span>
EOF;
		// Be sure that the entity does not exist yet
		$entity = wl_get_entity_post_by_uri( $expected_entity_uri );		
		
		$this->assertNull( $entity );
		// Create a post referincing to the created entity
		$post_id = wl_create_post( $content, 'my-post', 'A post' , 'draft');
		// Here the entity should be created instead
		$entity = wl_get_entity_post_by_uri( $expected_entity_uri );
		$this->assertNotNull( $entity );

		// Check if the content was properly fixed
		$expected_content = <<<EOF
    <span itemid="$expected_entity_uri">My entity</span>
EOF;
		$post = get_post( $post_id );
		$this->assertEquals( $post->post_content, $expected_content );
		// And it should be related to the post as what predicate
		$related_entity_ids = wl_core_get_related_entity_ids( $post_id, array( "predicate" => "who" ) );
		$this->assertCount( 1, $related_entity_ids );
		$this->assertContains( $entity->ID, $related_entity_ids );
		// Ensure there are no other relation instances
		$relation_instances = wl_tests_get_relation_instances_for( $post_id ); 
		$this->assertCount( 1, $relation_instances );
		
	}

	// This test simulates the standard workflow from disambiguation widget:
	// Create a post having in $_POST a NEW entity related as 'who'
	// Please notice that new entities are a tmp uri with 'local-entity-' prefix 
	// that needs to be processed before the save entity routine
	// Ea: local-entity-n3n5c5ql1yycik9zu55mq0miox0f6rgt
	function testNewEntityIsCreatedAndLinkedToThePost() {

		$fake = $this->prepareFakeGlobalPostArrayFromFile(
			'/assets/fake_global_post_array_with_a_new_entity_linked_as_who.json' 
		);
		$_POST = $fake;
		// Retrieve the entity uri (the first key in wl_entities associative aray)
		$entity_uri = current( array_keys ( $fake['wl_entities' ] ) );
		// Retrieve the label 
		$raw_entity = current( array_values ( $fake['wl_entities' ] ) );
		$expected_entity_uri = $this->buildEntityUriForLabel( $raw_entity['label'] );
		// Reference the entity to the post content 
		$content    = <<<EOF
    <span itemid="$entity_uri">My entity</span>
EOF;
		// Be sure that the entity does not exist yet
		$entity = wl_get_entity_post_by_uri( $expected_entity_uri );
		$this->assertNull( $entity );
		// Create a post referincing to the created entity
		$post_id = wl_create_post( $content, 'my-post', 'A post' , 'draft');
		// Here the entity should be created instead
		$entity = wl_get_entity_post_by_uri( $expected_entity_uri );
		$this->assertNotNull( $entity );
		// Check if the content was properly fixed
		$expected_content = <<<EOF
    <span itemid="$expected_entity_uri">My entity</span>
EOF;
		$post = get_post( $post_id );
		$this->assertEquals( $post->post_content, $expected_content );
		// And it should be related to the post as what predicate
		$related_entity_ids = wl_core_get_related_entity_ids( $post_id, array( "predicate" => "who" ) );
		$this->assertCount( 1, $related_entity_ids );
		$this->assertContains( $entity->ID, $related_entity_ids );
		// Ensure there are no other relation instances
		$relation_instances = wl_tests_get_relation_instances_for( $post_id ); 
		$this->assertCount( 1, $relation_instances );
		
	}
	// This test simulate the standard workflow from disambiguation widget:
	// A create a post having in $_POST one entity related as 'what' and 'who'
	// Please notice here the entity is properly referenced by post content
	function testEntityIsCreatedAndLinkedWithMultiplePredicatesToThePost() {

		$fake = $this->prepareFakeGlobalPostArrayFromFile(
			'/assets/fake_global_post_array_with_one_entity_linked_as_what_and_who.json' 
		);
		
		$_POST = $fake;
		// Retrieve the entity uri (the first key in wl_entities associative aray)
		$entity_uri = current( array_keys ( $fake['wl_entities' ] ) );
		// Reference the entity to the post content 
		$content    = <<<EOF
    <span itemid="$entity_uri">My entity</span>
EOF;
		// Be sure that the entity does not exist yet
		$entity = wl_get_entity_post_by_uri( $entity_uri );
		$this->assertNull( $entity );
		// Create a post referincing to the created entity
		$post_id = wl_create_post( $content, 'my-post', 'A post' , 'draft');
		// Here the entity should be created instead
		$entity = wl_get_entity_post_by_uri( $entity_uri );
		$this->assertNotNull( $entity );
		// And it should be related to the post as what predicate
		$related_entity_ids = wl_core_get_related_entity_ids( $post_id, array( "predicate" => "what" ) );
		$this->assertCount( 1, $related_entity_ids );
		$this->assertContains( $entity->ID, $related_entity_ids );
		// And it should be related to the post as what predicate
		$related_entity_ids = wl_core_get_related_entity_ids( $post_id, array( "predicate" => "who" ) );
		$this->assertCount( 1, $related_entity_ids );
		$this->assertContains( $entity->ID, $related_entity_ids );
		// Ensure there are no other relation instances
		$relation_instances = wl_tests_get_relation_instances_for( $post_id ); 
		$this->assertCount( 2, $relation_instances );

	}

	// This test simulate the standard workflow from disambiguation widget:
	// A create a post having in $_POST one entity related as 'what'
	// Please notice here the entity is NOT properly referenced by post content
	function testEntityIsCreatedButNotLinkedToThePost() {

		$fake = $this->prepareFakeGlobalPostArrayFromFile(
			'/assets/fake_global_post_array_with_one_entity_linked_as_what.json' 
		);
		$_POST = $fake;
		// Retrieve the entity uri (the first key in wl_entities associative aray)
		$entity_uri = current( array_keys ( $fake['wl_entities' ] ) );
		// Here I DON'T reference the entity to the post content 
		$content    = <<<EOF
    <span>My entity</span>
EOF;
		// Be sure that the entity does not exist yet
		$entity = wl_get_entity_post_by_uri( $entity_uri );
		$this->assertNull( $entity );
		// Create a post referencing to the created entity
		$post_id = wl_create_post( $content, 'my-post', 'A post' , 'draft');
		// Here the entity should be existing instead
		$entity = wl_get_entity_post_by_uri( $entity_uri );
		$this->assertNotNull( $entity );
		// And it should be related to the post as what predicate
		$related_entity_ids = wl_core_get_related_entity_ids( $post_id );
		$this->assertCount( 0, $related_entity_ids );
	
	}

	// This test simulate entity metadata updating trough the disambiguation widget
	function testEntityMetadataAreProperlyUpdated() {

		$fake = $this->prepareFakeGlobalPostArrayFromFile(
			'/assets/fake_global_post_array_with_one_entity_linked_as_what.json' 
		);
		$_POST = $fake;
		// Retrieve the entity uri (the first key in wl_entities associative aray)
		$original_entity_uri = current( array_keys ( $fake['wl_entities' ] ) );
		// Reference the entity to the post content 
		$content    = <<<EOF
    <span itemid="$original_entity_uri">My entity</span>
EOF;
		// Create a post referincing to the created entity
		$post_id = wl_create_post( $content, 'my-post', 'A post' , 'draft');
		
        // Here the entity should have been created
		$original_entity = wl_get_entity_post_by_uri( $original_entity_uri );
        $this->assertNotNull( $original_entity );
        
        // Store entity type, images and sameAs (needed later)
        $original_type = wl_schema_get_types( $original_entity->ID );
        $original_thumbnails = $this->getThumbs( $original_entity->ID );
        $original_sameAs = wl_schema_get_value( $original_entity->ID, 'sameAs' );
        
        // Query the same entity using the Redlink URI
		$entity_uri = wl_get_entity_uri( $original_entity->ID );
		$e = wl_get_entity_post_by_uri( $entity_uri );
        $this->assertEquals($original_entity, $e);

		// The entity description should be the same we expect
		$raw_entity = current( array_values ( $fake[ 'wl_entities' ] ) );
		$this->assertEquals( $raw_entity[ 'description' ], $original_entity->post_content );
                
		// The entity is related as what predicate
		$related_entity_ids = wl_core_get_related_entity_ids( $post_id, array( "predicate" => "what" ) );
		$this->assertCount( 1, $related_entity_ids );
                
		// Ensure there are no other relation instances
		$relation_instances = wl_tests_get_relation_instances_for( $post_id ); 
		$this->assertCount( 1, $relation_instances );

        /* Now Post is saved again with the same mentioned entity:
         * - with different type
         * - with different description
         * - with one more image
         * - with one modified sameAs
         * - as WHO instead fo WHAT
         */
		$fake = $this->prepareFakeGlobalPostArrayFromFile(
			'/assets/fake_global_post_array_with_one_entity_linked_as_who_and_modified_data.json' 
		);
		$_POST = $fake;
                
		// The entity url should be the same we expect
		$raw_entity = current( array_values ( $fake[ 'wl_entities' ] ) );
		$raw_entity_uri = $raw_entity[ 'uri' ];

		$new_content    = <<<EOF
    <span itemid="$raw_entity_uri">My entity</span>
EOF;
        // Update the post content (to force existing entities update)
		wp_update_post( array('ID' => $post_id, 'post_content' => $new_content ) );
		
        // Verify the mentioned entity was already into DB...
		$updated_entity = wl_get_entity_post_by_uri( $raw_entity_uri );
        $this->assertEquals( $original_entity->ID, $updated_entity->ID );
        $this->assertEquals( $original_entity->post_title, $updated_entity->post_title );
        // ... but some properties changed!
        $this->assertNotEquals( $original_entity, $updated_entity );
                
		// Verify entity type has been updated
        $updated_type = wl_schema_get_types( $updated_entity->ID );
        $this->assertNotEquals( $original_type, $updated_type );
		$this->assertEquals( array('http://schema.org/Organization'), $updated_type );
                
        // Verify entity description has been updated
		$this->assertEquals( $raw_entity[ 'description' ], $updated_entity->post_content );
                
        // Verify entity images have been updated (one was added)
        $updated_thumbnails = $this->getThumbs( $updated_entity->ID );
		$this->assertNotEquals( $original_thumbnails, $updated_thumbnails );
        $this->assertContains( $original_thumbnails[0], $updated_thumbnails );
        $this->assertCount( 2, $updated_thumbnails );                                       // There is one more
        $this->assertContains('Netherlands_vs_Ivory_Coast', $updated_thumbnails[1]);        // ... about soccer
                
        // Verify entity sameAs have been updated
        $updated_sameAs = wl_schema_get_value( $updated_entity->ID, 'sameAs' );
		$this->assertNotEquals( $original_sameAs, $updated_sameAs );
        $this->assertContains( $original_sameAs[1], $updated_sameAs );
        $this->assertNotContains( $original_sameAs[0], $updated_sameAs );
        $this->assertContains( 'http://sv.dbpedia.org/page/Reason', $updated_sameAs );
                
        // Verify the entity is now related as who predicate
		$related_entity_ids = wl_core_get_related_entity_ids( $post_id, array( "predicate" => "who" ) );
		$this->assertCount( 1, $related_entity_ids );
		// Ensure there are no other relation instances
		$relation_instances = wl_tests_get_relation_instances_for( $post_id ); 
		$this->assertCount( 1, $relation_instances );
	}

	function prepareFakeGlobalPostArrayFromFile( $fileName ) {
		$json_data = file_get_contents( dirname( __FILE__ ) . $fileName );
		$json_data = preg_replace(
			'/{{REDLINK_ENDPOINT}}/',
			wl_configuration_get_redlink_dataset_uri(),
			$json_data );
		wl_write_log( $json_data );
		$data = json_decode( $json_data, true );
		return $data;

	}

	function buildEntityUriForLabel( $label ){
		return sprintf( '%s/%s/%s',
			wl_configuration_get_redlink_dataset_uri(), 
			'entity', wl_sanitize_uri_path( $label ) ); 
	}
        
    function getThumbs( $post_id ) {
        
        $attatchments = get_attached_media( 'image', $post_id );
        $attatchments_uris = array();
        foreach( $attatchments as $attch ){
            $attatchments_uris[] = wp_get_attachment_url( $attch->ID );
        }
        
        return $attatchments_uris;
    }

}

