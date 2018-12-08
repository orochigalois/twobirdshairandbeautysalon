jQuery(document).ready(function(){
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
	var set_to_post_id = 0; // Set this
	 
	  jQuery('#upload_image_button').live('click', function( event ){
	 
		event.preventDefault();
	 
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
		  // Set the post ID to what we want
		  file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
		  // Open frame
		  file_frame.open();
		  return;
		} else {
		  // Set the wp.media post id so the uploader grabs the ID we want when initialised
		  wp.media.model.settings.post.id = set_to_post_id;
		}
	 
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
		  title: jQuery( this ).data( 'uploader_title' ),
		  button: {
			text: jQuery( this ).data( 'uploader_button_text' ),
		  },
		  multiple: true  // Set to true to allow multiple files to be selected
		});
	 
		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
		  // We set multiple to false so only get one image from the uploader
		  //attachment = file_frame.state().get('selection').first().toJSON();
			var selection_ids = [];
			var selection = file_frame.state().get('selection');
			var row_i = 1;
			
			jQuery('table.ozy_gallery_page_ozy_gallery_bulk_post tbody tr').remove();
			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				//jQuery("#obal").after("<img src=" +attachment.url+">");
				jQuery('table.ozy_gallery_page_ozy_gallery_bulk_post tbody').append('<tr'+(row_i%2 ? ' class="alternate"':'')+' data-fileid="'+ attachment.id +'"><td class="filename column-filename"><a href="'+ attachment.url +'" class="thickbox" title="'+ attachment.title +'">'+ attachment.filename +'</a></td><td class="title column-title"><input type="textbox" id="ozy_bulk_title_'+ attachment.title +'" class="widefat regular-text ozy_bulk_title" value="'+ attachment.title +'"/></td><td class="description regular-text column-description"><textarea id="ozy_bulk_description_'+ attachment.id +'" class="widefat ozy_bulk_description">'+ attachment.description +'</textarea></td></tr>');
				row_i++;
			});
		  
		  // Restore the main post ID
		  wp.media.model.settings.post.id = wp_media_post_id;
		});
	 
		// Finally, open the modal
		file_frame.open();
	  });
	  
	jQuery('.ozy_gallery_page_ozy_gallery_bulk_post').on('mouseenter', '.column-filename>a', function( event ) {
		jQuery('#ozy_bulk_post_editor_thumb').html('<img src="'+ jQuery(this).attr('href') +'" width="150"/>').fadeIn();
	}).on('mouseleave', '.column-filename>a', function( event ) {
		jQuery('#ozy_bulk_post_editor_thumb').stop().fadeOut();
	});

	jQuery(document).on('mousemove', function(e){
		jQuery('#ozy_bulk_post_editor_thumb').css({
		   left:  e.pageX-160,
		   top:   e.pageY-20
		});
	});

	jQuery(document).on('click', '#ozy_bulk_post_editor_create_posts', function(){
		var categories = [];
		jQuery('input[name=ozy_bulk_post_editor_category]:checked').each(function(){
			categories.push(jQuery(this).val());
		});
		if(categories.length<=0) {
			alert('Please select at least one category to continue');
			return;
		}
		if(jQuery('table.ozy_gallery_page_ozy_gallery_bulk_post tbody tr[data-fileid]').length < 1) {
			alert('Please add images to your list before processing creating posts');
			return;
		}
		
		jQuery('#ozy_bulk_post_editor_loader').fadeIn();
		
		jQuery('body,html').animate({scrollTop:0},800)
		
		var jSONData = [];//[{ "aid": "60", "title": "Title 1", "description" : "Description 1" },{ "aid": "59", "title": "Title 2", "description" : "Description 2" },{ "aid": "58", "title": "Title 3", "description" : "Description 3" }];
		jQuery('table.ozy_gallery_page_ozy_gallery_bulk_post tbody tr[data-fileid]').each(function(){
			jSONData.push({
				aid: jQuery(this).data('fileid'),
				title: jQuery(this).find('.ozy_bulk_title').val(),
				description: jQuery(this).find('.ozy_bulk_description').val(),
				category: categories.join(',')
			});
		});
		jQuery.ajax({
			url: ozyBulkEditor.ozyAdminAjaxUrl,
			data: { 'action': 'ozy_insert_bulk_posts', 'posts': JSON.stringify(jSONData) },
			//contentType: "application/json; charset=utf-8",
			//dataType: "json",
			type: "POST",
			cache: false,
			success: function(data) {
				alert(data);
				
				jQuery('table.ozy_gallery_page_ozy_gallery_bulk_post tbody tr').remove();
				jQuery('table.ozy_gallery_page_ozy_gallery_bulk_post tbody').append('<tr class="no-items"><td class="colspanchange" colspan="3">No items found.</td></tr>');

				jQuery('#ozy_bulk_post_editor_loader').fadeOut();
			},
			error: function(MLHttpRequest, textStatus, errorThrown){  
				alert("MLHttpRequest: " + MLHttpRequest + "\ntextStatus: " + textStatus + "\nerrorThrown: " + errorThrown); 
			}  
		});
		return;	
	});

});