jQuery(document).ready(function() {
//	$("#tabs").tabs();
//	$(".accordion").accordion();
//	$("button, .button").button();
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
	$url = '/ajax/userdata';
	
	$.post( $url, function( data ) {
		$("#userdata").html( data );
	});
}