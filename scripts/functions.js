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