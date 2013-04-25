$(document).ready(function() {
 //   $("#content div.tab-content").hide(); // Initially hide all content
	$page = $("#page").val();
	$pageTitle = $("#page-title").val();
	
	switch($page) {
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
	
	$("#tab-topics a").html($pageTitle)
    //$("#tabs li:first").attr("id","current"); // Activate first tab
    $("#content").fadeIn(); // Show first tab content
    
  /*  $('#tabs a').click(function(e) {
        e.preventDefault();
        if ($(this).closest("li").attr("id") == "current"){ //detection for current tab
         return       
        }
        else{             
	        $("#content div.tab-content").hide(); //Hide all content
	        $("#tabs li").attr("id",""); //Reset id's
	        $(this).parent().attr("id","current"); // Activate this
	        $('#' + $(this).attr('name')).fadeIn(); // Show content for current tab
        }
    });
    */
});

//jQuery(document).ready(function() {
//	$("#tabs").tabs();
//	$(".accordion").accordion();
//	$("button, .button").button();
//});

function voteComment( cid, val ) {
/*	$url = '/ajax/vote';
	$type = 'comment';
	
	$.post( $url, { object_type: $type, object_id: cid, value: val }, function( data ) {
		$("#post").html( data );
		updateUserData();
	});
*/
	$url = '/ajax/votecomment';
	
	$.post( $url, { comment_id: cid, value: val }, function( data ) {
		$("#post").html( data );
		updateUserData();
	});
}

function votePost( pid, val ) {
/*	$url = '/ajax/vote';
	$type = 'post';
	
	$.post( $url, { object_type: $type, object_id: pid, value: val }, function( data ) {
		$("#post").html( data );
		updateUserData();
	});
*/
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