jQuery(document).ready(function() {
//	$("#tabs").tabs();
//	$(".accordion").accordion();
//	$("button, .button").button();
});

function voteComment( cid, val ) {
/*	$url = '/ajax/votecomment';
	
	$.post( $url, { comment_id: cid, value: val }, function() {
	
	});
*/
	alert('cid:'+cid+' val:'+val);
}

function votePost( pid, val ) {
/*	$url = '/ajax/votepost';
	
	$.post( $url, { post_id: pid, value: val }, function() {
	
	});
*/
	alert('pid:'+pid+' val:'+val);
}