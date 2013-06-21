$(document).ready(function() {
	$page = $("#page").val();
	
	switch($page) {
		case 'account':
		    $("#tabs li#tab-account").attr("id","current"); // Activate account tab
			break;		
		case 'admin':
		    $("#tabs li#tab-admin").attr("id","current"); // Activate admin tab
			break;
		case 'topics':
		case 'topic':
		case 'post':
		    $("#tabs li#tab-topics").attr("id","current"); // Activate topics tab
		    break;
	    case 'home':
	    default:
		    $("#tabs li#tab-home").attr("id","current"); // Activate home tab
		    break;	
	}
	
	$pageTitle = $("#page-title").val();
	$("html head title").html($pageTitle);
	
	$('#select-search').selectize({
		theme: 'repositories',
		persist: true,
		maxItems: 1,
		valueField: 'link',
		labelField: 'title',
		searchField: ['title', 'details', 'authorStr'],
		options: [],
		render: {
			option: function(item) {
				return '<div>' +
					'<span class="title">' +
						'<span class="name">' + item.title + '</span>' +
						'<span class="by">' + item.authorStr + '</span>' +
					'</span>' +
					'<span class="description">' + item.details + '</span>' +
				'</div>';
			}
		},
		create: false,
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: '/ajax/api.php',
				type: 'GET',
				dataType: 'jsonp',
				data: {
					q: query,
				},
				error: function() {
					callback();
				},
				success: function(res) {
					callback(res);
				}
			});
		},
		onChange: function() {
			if ($('#select-search').val() != '') {
				window.location = $('#select-search').val();
			}
		}
	});
});

function voteComment( cid, val ) {
	$url = '/ajax/votecomment';
	
	$.post( $url, { comment_id: cid, value: val }, function( data ) {
		$("#post").html( data );
		updateUserData();
	});
}

function votePost( pid, val ) {
	$url = '/ajax/votepost';
	
	$.post( $url, { post_id: pid, value: val }, function( data ) {
		$("#topic").html( data );
		updateUserData();
	});
}

function updateUserData() {
	$url = '/ajax/userstatus';
	
	$.post( $url, { ajax: 'ajax' }, function( data ) {
		$("#userstatus").html( data );
	});
}