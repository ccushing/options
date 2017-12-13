


$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});


function set_up_sliders()
{
	$(".slider").slider({});
}

    

function edit_feed(d,feed_id)
{
	// Fill in the Edit Modal Form\
	var row = d.parentNode.parentNode;

	var feed_name = row.cells[1].innerHTML;
	var feed_url = row.cells[2].innerHTML;
	//var feed_weight = row.cells[5].innerHTML;
	var feed_type = row.cells[5].innerHTML;


	document.getElementById("edit-feed-name").value=feed_name;
	document.getElementById("edit-feed-url").value=feed_url;
	document.getElementById("edit-feed-id").value=feed_id;
	document.getElementById("edit-feed-type").value=feed_type;

	$("#edit-feed-weight").attr('data-slider-value', 8);
    $("#edit-feed-weight").slider('refresh');

	//$("#edit-feed-weight").value=feed_weight;


}


function edit_tag(d,tag_id)
{
	// Fill in the Edit Modal Form\
	var row = d.parentNode.parentNode;

	var tag_name = row.cells[1].innerHTML;
	var tag_weight = row.cells[2].innerHTML;

	document.getElementById("edit-tag-name").value=tag_name;
	document.getElementById("edit-tag-id").value=tag_id;


}


function edit_category(d,category_id)
{
	// Fill in the Edit Modal Form\
	var row = d.parentNode.parentNode;

	var category_name = row.cells[1].innerHTML;
	var category_weight = row.cells[2].innerHTML;

	document.getElementById("edit-category-name").value=category_name;
	document.getElementById("edit-category-id").value=category_id;

}




function delete_feed(d,feed_id)
{


// Update the form action to the proper route
$("#delete-feed-form").attr("action", "/RemoveFeed/" + feed_id);


}


function delete_tag(d,tag_id)
{


// Update the form action to the proper route
$("#delete-tag-form").attr("action", "/RemoveTag/" + tag_id);


}



function delete_category(d,category_id)
{


// Update the form action to the proper route
$("#delete-category-form").attr("action", "/RemoveCategory/" + category_id);


}


function mark_as_read(article_id)
{


$.ajax({
            type: "GET",
            url : "/MarkAsRead/" + article_id,
            data : "",
            success : function(data){
             	//Remove Article From the View
             	$("#article-panel-" + article_id).remove();			
             }

     },"json");


}


function remove_article(article_id)
{


$.ajax({
            type: "GET",
            url : "/RemoveArticle/" + article_id,
            data : "",
            success : function(data){
             	//Remove Article From the View
             	$("#article-panel-" + article_id).remove();			
             }

     },"json");


}


function init_DataTables() {
				
				console.log('run_datatables');
				
				if( typeof ($.fn.DataTable) === 'undefined'){ return; }
				console.log('init_DataTables');
				
				var handleDataTableButtons = function() {
				  if ($("#datatable-buttons").length) {
					$("#datatable-buttons").DataTable({
					  dom: "Blfrtip",
					  "bLengthChange": false,
					  pageLength : 50,
					  buttons: [],
					  responsive: true
					});
				  }
				};

				TableManageButtons = function() {
				  "use strict";
				  return {
					init: function() {
					  handleDataTableButtons();
					}
				  };
				}();

				$('#datatable').dataTable();

				$('#datatable-keytable').DataTable({
				  keys: true
				});

				$('#datatable-responsive').DataTable();

				$('#datatable-scroller').DataTable({
				  ajax: "js/datatables/json/scroller-demo.json",
				  deferRender: true,
				  scrollY: 380,
				  scrollCollapse: true,
				  scroller: true
				});

				$('#datatable-fixed-header').DataTable({
				  fixedHeader: true
				});

				var $datatable = $('#datatable-checkbox');

				$datatable.dataTable({
				  'order': [[ 1, 'asc' ]],
				  'columnDefs': [
					{ orderable: false, targets: [0] }
				  ]
				});
				$datatable.on('draw.dt', function() {
				  $('checkbox input').iCheck({
					checkboxClass: 'icheckbox_flat-green'
				  });
				});

				TableManageButtons.init();
				
			}


