<?php
require_once('JobService.php');

class EntitiesBoxService {
	
	private $job_service;
	private $logger;

	function __construct() {
		global $job_service;

		$this->logger 		= Logger::getLogger(__CLASS__);
		$this->job_service 	= $job_service;
	}

	function custom_box($post) {

		$job 				= $this->job_service->get_job_by_post_id($post->ID);

		echo 'An analysis job for this post is '.$job->state.'.<br/>';
	?>

		<script type="text/template" id="entities-template">
			<% _.each(entities, function(entity) { %>
				<div class="isotope-item entity-item <%= entity.type %> <%= (entity.accepted ? 'accepted' : '') %> <%= (entity.rejected ? 'rejected' : '') %>" data-post-id="<%= entity.post_id %>" data-reference="<%= entity.reference %>">
					<% if (entity.properties['image']) { %>
						<div><img style="width: 100%;" alt="" onerror="jQuery(this).remove();" src="<%= entity.properties['image'] %>" /></div>
					<% } %>
					<div class="entity-caption-outer">
						<div class="entity-caption-inner"><a href="post.php?post=<%= entity.post_id %>&action=edit"><%= entity.text %></a></div>
					</div>
					<div class="entity-toolbar">
						<!-- <div class="forbidden <%= (entity.forbidden ? 'selected' : 'deselected') %>"><img class="clickable" src="<%= WORDLIFT_20_URL %>images/1330954875_thumbs_down_48.png" /></div> -->
						<div class="accepted <%= (entity.accepted ? 'selected' : 'deselected') %>"><img class="clickable" src="<%= WORDLIFT_20_URL %>images/1330946282_accepted_48.png" /></div>
						<div class="rejected <%= (entity.rejected ? 'selected' : 'deselected') %>"><img class="clickable" src="<%= WORDLIFT_20_URL %>images/1330946285_cancel_48.png" /></div>
					</div>
				</div>
			<% }); %>
		</script>

		[<a href="javascript:jQuery('#entities-container').isotope({ filter: '' });">All</a>]<br/>
		[<a href="javascript:jQuery('#entities-container').isotope({ filter: '.Person' });">People</a>][<a href="javascript:jQuery('#entities-container').isotope({ filter: '.Place' });">Places</a>][<a href="javascript:jQuery('#entities-container').isotope({ filter: '.CreativeWork' });">Creative Works</a>][<a href="javascript:jQuery('#entities-container').isotope({ filter: '.Organization' });">Organizations</a>][<a href="javascript:jQuery('#entities-container').isotope({ filter: '.Other' });">Other</a>]<br/>
		[<a href="javascript:jQuery('#entities-container').isotope({ filter: '.accepted' });">Accepted</a>][<a href="javascript:jQuery('#entities-container').isotope({ filter: '.rejected' });">Rejected</a>]
		<div id="entities-container" class="isotope" style="width: 100%;"></div>


		<script type="text/javascript">

			// load the entities when the document is ready.
			jQuery(window).ready(function(jQuery) {

				(function ($ , $wl) {

					$wl.services.loadEntities();

				})(jQuery,io.insideout.wordlift);

			});
		</script>

	<?php

	}

	function create_custom_box() {
		add_meta_box( 
	        'wordlift_20_entities',
	        _x( 'Entities', 'Entities (Custom-Box Title)' ),
	        array( $this, 'custom_box'),
	        'post' 
	    );
	}

}

$entities_box_service = new EntitiesBoxService();

?>