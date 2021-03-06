<?php
require_once 'functions.php';

/**
 * Class EntityTest
 */
class EntityTest extends WP_UnitTestCase
{

    /**
     * Set up the test.
     */
    function setUp()
    {
        parent::setUp();

        // Configure WordPress with the test settings.
        wl_configure_wordpress_test();

        // Reset data on the remote dataset.
        rl_empty_dataset();

        // Check that the dataset is empty.
//        $this->assertEquals( array(
//            'subjects'   => 0,
//            'predicates' => 0,
//            'objects'    => 0
//        ), rl_count_triples() );

        // Empty the blog.
        wl_empty_blog();

        // Check that entities and posts have been deleted.
        $this->assertEquals( 0, count( get_posts( array(
            'posts_per_page' => -1,
            'post_type'      => 'post',
            'post_status'    => 'any'
        ) ) ) );
        $this->assertEquals( 0, count( get_posts( array(
            'posts_per_page' => -1,
            'post_type'      => 'entity',
            'post_status'    => 'any'
        ) ) ) );

    }

    function testSaveEntity1() {

        $entity_props = array(
            'uri'           => 'http://dbpedia.org/resource/Tim_Berners-Lee',
            'label'         => 'Tim Berners-Lee',
            'main_type_uri' => 'http://schema.org/Person',
            'type_uris'     => array(),
            'related_post_id' => null,
            'description' => file_get_contents( dirname(__FILE__) . '/assets/tim_berners-lee.txt' ),
            'images'      => array(
                'http://upload.wikimedia.org/wikipedia/commons/f/ff/Tim_Berners-Lee-Knight.jpg'
            ),
            'same_as'     => array(
                'http://es.dbpedia.org/resource/Tim_Berners-Lee',
                'http://el.dbpedia.org/resource/Τιμ_Μπέρνερς_Λι',
                'http://it.dbpedia.org/resource/Tim_Berners-Lee',
                'http://ja.dbpedia.org/resource/ティム・バーナーズ＝リー',
                'http://pt.dbpedia.org/resource/Tim_Berners-Lee',
                'http://rdf.freebase.com/ns/m.07d5b',
                'http://www4.wiwiss.fu-berlin.de/dblp/resource/person/100007',
                'http://de.dbpedia.org/resource/Tim_Berners-Lee',
                'http://fr.dbpedia.org/resource/Tim_Berners-Lee',
                'http://ru.dbpedia.org/resource/Бернерс-Ли,_Тим',
                'http://cs.dbpedia.org/resource/Tim_Berners-Lee',
                'http://ko.dbpedia.org/resource/팀_버너스리',
                'http://pl.dbpedia.org/resource/Tim_Berners-Lee',
                'http://sw.cyc.com/concept/Mx4r3THFqbCtSyOa3bvfYXUhWg',
                'http://nl.dbpedia.org/resource/Tim_Berners-Lee',
                'http://eu.dbpedia.org/resource/Tim_Berners-Lee',
                'http://www.wikidata.org/entity/Q80',
                'http://yago-knowledge.org/resource/Tim_Berners-Lee',
                'http://zh.dbpedia.org/resource/蒂姆·伯纳斯-李',
                'http://af.dbpedia.org/resource/Tim_Berners-Lee',
                'http://an.dbpedia.org/resource/Tim_Berners-Lee',
                'http://ar.dbpedia.org/resource/تيم_بيرنرز_لي',
                'http://arz.dbpedia.org/resource/تيم_بيرنرز_لى',
                'http://az.dbpedia.org/resource/Tim_Berners-Li',
                'http://be.dbpedia.org/resource/Цім_Бернерс-Лі',
                'http://bg.dbpedia.org/resource/Тим_Бърнърс-Лий',
                'http://bn.dbpedia.org/resource/টিম_বার্নার্স-লি',
                'http://br.dbpedia.org/resource/Tim_Berners-Lee',
                'http://bs.dbpedia.org/resource/Tim_Berners-Lee',
                'http://ca.dbpedia.org/resource/Tim_Berners-Lee',
                'http://cy.dbpedia.org/resource/Tim_Berners-Lee',
                'http://da.dbpedia.org/resource/Tim_Berners-Lee',
                'http://eo.dbpedia.org/resource/Tim_Berners-Lee',
                'http://et.dbpedia.org/resource/Tim_Berners-Lee',
                'http://fa.dbpedia.org/resource/تیم_برنرز_لی',
                'http://fi.dbpedia.org/resource/Tim_Berners-Lee',
                'http://fy.dbpedia.org/resource/Tim_Berners-Lee',
                'http://ga.dbpedia.org/resource/Tim_Berners-Lee',
                'http://gd.dbpedia.org/resource/Tim_Berners-Lee',
                'http://gl.dbpedia.org/resource/Tim_Berners-Lee',
                'http://he.dbpedia.org/resource/טים_ברנרס-לי',
                'http://hi.dbpedia.org/resource/टिम_बर्नर्स_ली',
                'http://hif.dbpedia.org/resource/Tim_Berners-Lee',
                'http://hr.dbpedia.org/resource/Tim_Berners-Lee',
                'http://hu.dbpedia.org/resource/Tim_Berners-Lee',
                'http://id.dbpedia.org/resource/Tim_Berners-Lee',
                'http://ilo.dbpedia.org/resource/Tim_Berners-Lee',
                'http://is.dbpedia.org/resource/Tim_Berners-Lee',
                'http://jv.dbpedia.org/resource/Tim_Berners-Lee',
                'http://ka.dbpedia.org/resource/ტიმ_ბერნერს-ლი',
                'http://kk.dbpedia.org/resource/Тим_Бернерс-Ли',
                'http://kn.dbpedia.org/resource/ಟಿಮ್_ಬರ್ನರ್ಸ್_ಲೀ',
                'http://la.dbpedia.org/resource/Timotheus_Ioannes_Berners-Lee',
                'http://lb.dbpedia.org/resource/Tim_Berners-Lee',
                'http://lt.dbpedia.org/resource/Tim_Berners-Lee',
                'http://lv.dbpedia.org/resource/Tims_Bērnerss-Lī',
                'http://mk.dbpedia.org/resource/Тим_Бернерс-Ли',
                'http://ml.dbpedia.org/resource/ടിം_ബർണേഴ്സ്_ലീ',
                'http://ms.dbpedia.org/resource/Tim_Berners-Lee',
                'http://nn.dbpedia.org/resource/Tim_Berners-Lee',
                'http://no.dbpedia.org/resource/Tim_Berners-Lee',
                'http://oc.dbpedia.org/resource/Tim_Berners-Lee',
                'http://pms.dbpedia.org/resource/Tim_Berners-Lee',
                'http://pnb.dbpedia.org/resource/ٹم_برنرز_لی',
                'http://ro.dbpedia.org/resource/Tim_Berners-Lee',
                'http://rue.dbpedia.org/resource/Тім_Бернерс-Лі',
                'http://scn.dbpedia.org/resource/Tim_Berners-Lee',
                'http://sh.dbpedia.org/resource/Tim_Berners-Lee',
                'http://simple.dbpedia.org/resource/Tim_Berners-Lee',
                'http://sk.dbpedia.org/resource/Tim_Berners-Lee',
                'http://sl.dbpedia.org/resource/Tim_Berners-Lee',
                'http://sq.dbpedia.org/resource/Tim_Berners-Lee',
                'http://sr.dbpedia.org/resource/Тим_Бернерс-Ли',
                'http://sv.dbpedia.org/resource/Tim_Berners-Lee',
                'http://sw.dbpedia.org/resource/Tim_Berners-Lee',
                'http://ta.dbpedia.org/resource/டிம்_பேர்னேர்ஸ்-லீ',
                'http://te.dbpedia.org/resource/టిమ్_బెర్నర్స్_లీ',
                'http://tg.dbpedia.org/resource/Тим_Бернерс-Ли',
                'http://th.dbpedia.org/resource/ทิม_เบอร์เนิร์ส-ลี',
                'http://tl.dbpedia.org/resource/Tim_Berners-Lee',
                'http://tr.dbpedia.org/resource/Tim_Berners-Lee',
                'http://uk.dbpedia.org/resource/Тім_Бернерс-Лі',
                'http://ur.dbpedia.org/resource/ٹم_برنرز_لی',
                'http://uz.dbpedia.org/resource/Tim_Berners-Lee',
                'http://vi.dbpedia.org/resource/Tim_Berners-Lee',
                'http://war.dbpedia.org/resource/Tim_Berners-Lee',
                'http://yi.dbpedia.org/resource/טים_בערנערס-לי',
                'http://yo.dbpedia.org/resource/Tim_Berners-Lee',
                'http://za.dbpedia.org/resource/Tim_Berners-Lee',
                'http://als.dbpedia.org/resource/Tim_Berners-Lee',
                'http://lmo.dbpedia.org/resource/Tim_Berners-Lee',
                'http://bat_smg.dbpedia.org/resource/Tim_Berners-Lee',
                'http://be_x_old.dbpedia.org/resource/Тым_Бэрнэрз-Лі',
                'http://ce.dbpedia.org/resource/Бернерс-Ли,_Тим',
                'http://ckb.dbpedia.org/resource/تیم_بێرنەرز_لی',
                'http://ksh.dbpedia.org/resource/Tim_Berners-Lee',
                'http://li.dbpedia.org/resource/Tim_Berners-Lee',
                'http://mn.dbpedia.org/resource/Тим_Бернерс-Ли',
                'http://mt.dbpedia.org/resource/Tim_Berners-Lee',
                'http://new.dbpedia.org/resource/टिम_बर्नर्स_ली',
                'http://sah.dbpedia.org/resource/Тим_Бернерс-Ли',
                'http://vec.dbpedia.org/resource/Tim_Berners-Lee',
                'http://vo.dbpedia.org/resource/Tim_Berners-Lee',
                'http://zh_min_nan.dbpedia.org/resource/Tim_Berners-Lee'
            )
        );
        $entity_post = wl_save_entity( $entity_props );
        $this->assertNotNull( $entity_post );

        // Check that creating a post for the same entity does create a duplicate post.
        $entity_post_2 = wl_save_entity( $entity_props );
        $this->assertEquals( $entity_post->ID, $entity_post_2->ID );
        
        $entity_props_working_copy = $entity_props; // in PHP arrays are copied, not referenced
        foreach ( $entity_props['same_as'] as $same_as_uri ) {
            // Check that creating a post for the same entity does create a duplicate post.
            $entity_props_working_copy['same_as'] = array( $same_as_uri );
            $same_as_entity_post = wl_save_entity( $entity_props_working_copy );
            $this->assertEquals( $entity_post->ID, $same_as_entity_post->ID );
        }

        // Check that the type is set correctly.
        $types = wl_get_entity_rdf_types( $entity_post->ID );
        $this->assertEquals( 0, count( $types ) );
//        $this->assertEquals( $type, wl_get_entity_main_type( $entity_post->ID ) );
    }

    function testSaveEventWithStartAndEndDates() {

        $entity_1_id = wl_create_post( '', 'entity-1', 'Entity 1', 'draft', 'entity' );
        add_post_meta( $entity_1_id, WL_CUSTOM_FIELD_CAL_DATE_START, '2013-01-02' );
        add_post_meta( $entity_1_id, WL_CUSTOM_FIELD_CAL_DATE_END, '2013-02-03' );

        wl_set_entity_main_type( $entity_1_id, 'http://schema.org/Event' );

        wp_update_post( array(
            'ID'           => $entity_1_id,
            'post_content' => 'Lorem Ipsum.'
        ) );

        // TODO: add checks for SPARQL query.

    }

    function create_World_Wide_Web_Foundation( $related_post_id ) {

        $uri         = 'http://data.redlink.io/353/wordlift-tests-php-5-4-wp-3-8-ms-0/entity/World_Wide_Web_Foundation';
        $label       = 'World Wide Web Foundation';
        $type        = 'http://schema.org/Organization';
        $description = file_get_contents( dirname(__FILE__) . '/assets/world_wide_web_foundation.txt' );
        $images      = array();
        $same_as     = array();
//            'http://rdf.freebase.com/ns/m.04myd3k',
//            'http://yago-knowledge.org/resource/World_Wide_Web_Foundation'
//        );
        $entity_post = wl_save_entity( $uri, $label, $type, $description, array(), $images, $related_post_id, $same_as );

        $this->assertNotNull( $entity_post );

        // Check that the type is set correctly.
        $types = wl_get_entity_rdf_types( $entity_post->ID );
        $this->assertEquals( 0, count( $types ) );
        //$this->assertEquals( 'organization', $types[0]->slug );

        // Check that Tim Berners-Lee is related to this resource.
        $related_entities = wl_core_get_related_entity_ids( $entity_post->ID );
        $this->assertEquals( 1, count( $related_entities ) );
        $this->assertEquals( $related_post_id, $related_entities[0] );

        return $entity_post->ID;
    }

    function create_MIT_Center_for_Collective_Intelligence( $related_post_id ) {

        $uri         = 'http://dbpedia.org/resource/MIT_Center_for_Collective_Intelligence';
        $label       = 'MIT Center for Collective Intelligence';
        $type        = 'http://schema.org/Organization';
        $description = file_get_contents( dirname(__FILE__) . '/assets/mit_center_for_cognitive_intelligence.txt' );
        $images      = array();
        $same_as     = array(
            'http://rdf.freebase.com/ns/m.04n2n64'
        );
        $entity_post = wl_save_entity( $uri, $label, $type, $description, array(), $images, $related_post_id, $same_as );

        // Check that the type is set correctly.
        $types = wl_get_entity_rdf_types( $entity_post->ID );
        $this->assertEquals( 0, count( $types ) );
//        $this->assertEquals( 'organization', $types[0]->slug );

        // Check that Tim Berners-Lee is related to this resource.
        $related_entities = wl_core_get_related_entity_ids( $entity_post->ID );
        $this->assertEquals( 1, count( $related_entities ) );
        $this->assertEquals( $related_post_id, $related_entities[0] );

        return $entity_post->ID;
    }

}