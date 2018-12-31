// $(window).on('load', function() {

	// Row Toggler
	// -----------------------------------------------------------------
	// $('#demo-foo-row-toggler').footable();

	// Accordion
	// -----------------------------------------------------------------
	// jQuery(function($){
	// $('#ticket-foo-accordion').footable().on('footable_row_expanded', function(e) {
	// 	$('#ticket-foo-accordion tbody tr.footable-detail-show').not(e.row).each(function() {
	// 		$('#ticket-foo-accordion').data('footable').toggleDetail(this);
	// 	});
	// });


  $(function () {
	$('.footable').footable().bind('footable_row_expanded', function(e) {
	$('.footable tbody tr.footable-detail-show').not(e.row).each(function() {
		$('.footable').data('footable').toggleDetail(this);
	});
});

// $('.clear-filter').click(function (e) {
// 	e.preventDefault();
// 	$('.filter-status').val('');
// 	$('.footable').trigger('footable_clear_filter');
// });

// $('footable').footable().bind('footable_filtering', function (e) {
//   var selected = $('.filter-status').find(':selected').text();
//   if (selected && selected.length > 0) {
//     e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
//     e.clear = !e.filter;
//   }
// });

// $('.filter-status').change(function (e) {
// 	e.preventDefault();
// 	$('.footable').trigger('footable_filter', {filter: $('#filter').val()});
// });

  });
//
// 	// Pagination
// 	// -----------------------------------------------------------------
// 	$('#demo-foo-pagination').footable();
// 	$('#demo-show-entries').change(function (e) {
// 		e.preventDefault();
// 		var pageSize = $(this).val();
// 		$('#demo-foo-pagination').data('page-size', pageSize);
// 		$('#demo-foo-pagination').trigger('footable_initialized');
// 	});
//
// 	// Filtering
// 	// -----------------------------------------------------------------
// 	var filtering = $('#demo-foo-filtering');
// 	filtering.footable().on('footable_filtering', function (e) {
// 		var selected = $('#demo-foo-filter-status').find(':selected').val();
// 		e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
// 		e.clear = !e.filter;
// 	});
//
// 	// Filter status
// 	$('#demo-foo-filter-status').change(function (e) {
// 		e.preventDefault();
// 		filtering.trigger('footable_filter', {filter: $(this).val()});
// 	});
//
// 	// // Search input
// 	// $('#demo-foo-search').on('input', function (e) {
// 	// 	e.preventDefault();
// 	// 	filtering.trigger('footable_filter', {filter: $(this).val()});
// 	// });
// 	//
// 	//
// 	//
// 	//
// 	// // Search input
// 	// $('#demo-input-search2').on('input', function (e) {
// 	// 	e.preventDefault();
// 	// 	addrow.trigger('footable_filter', {filter: $(this).val()});
// 	// });
//
// 	// Add & Remove Row
// 	// var addrow = $('#demo-foo-addrow');
// 	// addrow.footable().on('click', '.delete-row-btn', function() {
// 	//
// 	// 	//get the footable object
// 	// 	var footable = addrow.data('footable');
// 	//
// 	// 	//get the row we are wanting to delete
// 	// 	var row = $(this).parents('tr:first');
// 	//
// 	// 	//delete the row
// 	// 	footable.removeRow(row);
// 	// });
//   //   var addrow = $('#demo-foo-addrow2');
// 	// addrow.footable().on('click', '.delete-row-btn', function() {
// 	//
// 	// 	//get the footable object
// 	// 	var footable = addrow.data('footable');
// 	//
// 	// 	//get the row we are wanting to delete
// 	// 	var row = $(this).parents('tr:first');
// 	//
// 	// 	//delete the row
// 	// 	footable.removeRow(row);
// 	// });
// 	// // Add Row Button
// 	// $('#demo-btn-addrow').click(function() {
// 	//
// 	// 	//get the footable object
// 	// 	var footable = addrow.data('footable');
// 	//
// 	// 	//build up the row we are wanting to add
// 	// 	var newRow = '<tr><td>thome</td><td>Woldt</td><td>Airline Transport Pilot</td><td>3 Oct 2016</td><td><span class="label label-table label-success">Active</span></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';
// 	//
// 	// 	//add it
// 	// 	footable.appendRow(newRow);
// 	// });
// });


	//
  // $(function () {
  //   $('table').footable().bind('footable_filtering', function (e) {
  //     var selected = $('.filter-status').find(':selected').text();
  //     if (selected && selected.length > 0) {
  //       e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
  //       e.clear = !e.filter;
  //     }
  //   });
	//
  //   $('.clear-filter').click(function (e) {
  //     e.preventDefault();
  //     $('.filter-status').val('');
  //     $('table.demo').trigger('footable_clear_filter');
  //   });
	//
  //   $('.filter-status').change(function (e) {
  //     e.preventDefault();
  //     $('table.demo').trigger('footable_filter', {filter: $('#filter').val()});
  //   });
	//
  //   $('.filter-api').click(function (e) {
  //     e.preventDefault();
	//
  //     //get the footable filter object
  //     var footableFilter = $('table').data('footable-filter');
	//
  //     alert('about to filter table by "tech"');
  //     //filter by 'tech'
  //     footableFilter.filter('tech');
	//
  //     //clear the filter
  //     if (confirm('clear filter now?')) {
  //       footableFilter.clearFilter();
  //     }
  //   });
  // });


  $(function () {
    $('table').footable().bind('footable_filtering', function (e) {
      var selected = $('.filter-status').find(':selected').text();
      if (selected && selected.length > 0) {
        e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
        e.clear = !e.filter;
      }
    });

    $('.clear-filter').click(function (e) {
      e.preventDefault();
      $('.filter-status').val('');
      $('table.demo').trigger('footable_clear_filter');
    });

    $('.filter-status').change(function (e) {
      e.preventDefault();
      $('table.demo').trigger('footable_filter', {filter: $('#filter').val()});
    });

    $('.filter-api').click(function (e) {
      e.preventDefault();

      //get the footable filter object
      var footableFilter = $('table').data('footable-filter');

      alert('about to filter table by "tech"');
      //filter by 'tech'
      footableFilter.filter('tech');

      //clear the filter
      if (confirm('clear filter now?')) {
        footableFilter.clearFilter();
      }
    });
  });
