// Jquery function for order fields
// When the page is loaded define the current order and items to reorder
$(document).ready( function(){
	/* Call the container items to reorder directories */
	$("#dir-list").sortable({ 
			opacity: 0.6, 
			cursor: "move",
			connectWith: "#dir-list",
			update: function(event, ui) {
				var list = $(this).sortable("serialize");
				$.post("directories.php?op=order", list );
			},
			receive: function(event, ui) {
				var list = $(this).sortable("serialize");                    
				$.post("directories.php?op=order", list );                      
			}
		}
	).disableSelection();
});