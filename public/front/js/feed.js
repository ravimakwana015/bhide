function openCommentBox(post_id){
	$('.comment-box_'+post_id).slideToggle("slow");
}
function openActionBox(post_id){
	$('.action-box_'+post_id).slideToggle("slow");
}

function postComment(post_id)
{

	$('.comment-error_'+post_id+'').html('');
	$('#loading').show();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: config.routes.comment_route,
		type: 'POST',
		dataType: 'json',
		data: {
			comment:$('#comment_'+post_id).val(),
			feed_id:post_id,
		},
	})
	.done(function(res) {
		console.log(res);
		$('#loading').hide();
    // if(res.status==false){
    //   var errorString = '<ul>';
    //   $.each(res.msg, function( key, value) {
    //     errorString += '<li>' + value + '</li>';
    //   });
    //   errorString += '</ul>';
    //   $('.comment-error_'+post_id+'').html('');
    //   $('.comment-error_'+post_id+'').html(errorString);
    //   $('#comment_'+post_id).focus();
    // }else{
    //   $('.media-list_'+post_id).prepend(res.commentdata);
    //   $('.comment_count_'+post_id).html(res.comment);
    //   $('#comment_'+post_id).val('');
    // }
});
}


function likePost(post_id)
{
	$('#loading').show();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: config.routes.like_route,
		type: 'POST',
		dataType: 'json',
		data: {feed_id: post_id},
	})
	.done(function(res) {
		console
		$('#loading').hide();
		$('.like_icon_'+post_id).attr('onclick', 'disLikePost('+post_id+')');
		$('.like_icon_'+post_id).html('<i class="fas fa-heart"></i>');
		$('#like_count_'+post_id).html(' '+res.likes);
		$('#feed_div_'+post_id).addClass('liked');

	});
}

function disLikePost(post_id)
{
	$('#loading').show();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url:  config.routes.dis_like_route,
		type: 'POST',
		dataType: 'json',
		data: {feed_id: post_id},
	})
	.done(function(res) {
		$('#loading').hide();
		$('.like_icon_'+post_id).attr('onclick', 'likePost('+post_id+')');
		$('.like_icon_'+post_id).html('<i class="far fa-heart"></i>');
		$('#like_count_'+post_id).html(res.likes);
		$('#feed_div_'+post_id).removeClass('liked');

	});
}


function editPost(post_id){
	$('#loading').show();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: config.routes.get_post_route,
		type: 'POST',
		dataType: 'json',
		data: {
			id: post_id
		},
	})
	.done(function(res) {
		console.log('UserFeedImage',res);
		$('#loading').hide();
		if(res.status==false){
			console.log('This feed not available');
		}else{
			$( '.status-edit-error' ).html('');
			// if(typeof(res.feed.properties) != "undefined" && res.feed.properties !== null)
			// {
			// 	var properties = jQuery.parseJSON(res.feed.properties);
			// 	if(typeof(properties.image) != "undefined" && properties.image !== null){
			// 		var path = config.routes.feed_image_route+properties.image;
			// 		$('#image_div').html('<img src="'+path+'" />');
			// 	}
			// }
			$('#feed_id').val(res.feed.id);
			$('#feed_message').val(res.feed.description);
			$('#editPostCenter').modal('show');
		}
	});
}
$('#status_edit_btn').click(function(event) {
	$('#loading').show();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: config.routes.update_post_route,
		type: 'POST',
		dataType: 'json',
		data: $('#status_form').serialize(),
	})
	.done(function(res) {
		$('#loading').hide();
		if(res.status==false){
			console.log('something is wrong');
		}else if(res.status==3){
			var errorString = '<ul>';
			$.each(res.msg, function( key, value) {
				errorString += '<li>' + value + '</li>';
			});
			errorString += '</ul>';
			$('.status-edit-error').html('');
			$( '.status-edit-error' ).html('<div class="alert alert-danger">'+errorString+'</div>');
			$('#feed_message').focus();
		}else{

			$('#feed_p_'+res.feed.id+'').text(res.feed.feed);
			$('#editPostCenter').modal('hide');
			location.reload();
		}
	});
});


function deletePostModal(post_id){

	$('#deletePostModal').modal('show');
	$('#delete-post-btn').attr('onclick', 'deletePost("'+post_id+'")');
}
function deletePost(post_id){
	$('#loading').show();
	$('#deletePostModal').modal('hide');
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: config.routes.delete_post_route,
		type: 'POST',
		dataType: 'json',
		data: {
			id: post_id
		},
	})
	.done(function(res) {
		$('#loading').hide();
		$('#feed_div_'+post_id).remove();
	});
}

function deletePostComment(comment_id)
{
	$('#loading').show();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: config.routes.delete_post_comment_route,
		type: 'POST',
		dataType: 'json',
		data: {
			id:comment_id,
		},
	}).done(function(res) {
		$('#loading').hide();
		$('#comment_li_'+comment_id).remove();
	});
}




function editPhotoPost(post_id){
	$('#loading').show();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: config.routes.get_post_route,
		type: 'POST',
		dataType: 'json',
		data: {
			id: post_id
		},
	})
	.done(function(res) {
		$('#loading').hide();
		if(res.status==false)
		{
			console.log('This feed not available');
		}
		else
		{
			$( '.status-edit-error' ).html('');
			if(typeof(res.feed.properties) != "undefined" && res.feed.properties !== null)
			{
				var properties = jQuery.parseJSON(res.feed.properties);
				if(typeof(properties.image) != "undefined" && properties.image !== null)
				{
					var imagesArray = [];
					$.each(properties, function (i) {
						$.each(properties[i], function (key, val) {
							var path = config.routes.feed_image_route+val;
							imagesArray.push('<div class="deletepic'+key+'"><img src="'+path+'" height="300" width="300"/><span class="deleteImage" data-delete_id="'+key+'" data-post_id="'+post_id+'" data-image_name="'+val+'"><i class="fa fa-trash"></i></span></div>');
						});
					});
				}
			}

			$('#image_div_image').html(imagesArray);
			$('#feed_id').val(res.feed.id);
			$('#simple_id').val(post_id);
			$('#feed_message_id').val(res.feed.description);
			$('#editPhotoCenter').modal('show');
		}
	});
}

