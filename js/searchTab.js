class tableLiveSearch{
	constructor(table, searchable){
		this.table = table;
		this.searchable = searchable;
		this.hide_row_list = new Array();
	}
	
	// update the Table: 
	// 1. generate hide_row_list 
	// 2. show all rows of table
	// 3. hide all rows in hide_row_list
	// @param String search_query
	updateTable(search_query){
		this.hide_row_list = this.searchTable( search_query );
		this.showAllTableRows();
		this.hideTableRows();
	}
	
	// Search a query in each searchable item in the table
	// @param String search_query
	searchTable( search_query ){
		var temporary_list = new Array();
		var $searchable_items = $(this.table + ' ' + this.searchable);
		
		// Filter through all searchables
		$searchable_items.each(function( index, value ) {
			var $this_element = $(this);
			search_query = search_query.toLowerCase();
			var search_content = $this_element.text().toLowerCase();
			
			// If this element text does not contain the search query add element to list
			if (search_content.indexOf(search_query) == -1)
					temporary_list.push( $this_element.parent() );

		});
				
		return temporary_list;
	}
	
	// Show all items in table
	showAllTableRows(){
		$( this.table + ' ' + this.searchable ).each( function( index, value ) {
			$(this).parent().show();
		});
	}

	// Hide all items from list in table
	hideTableRows(){
		$.each( this.hide_row_list, function( index, value ) {
			$(this).hide();
		});
	}
}

var searchtable = new tableLiveSearch('.search-table', '.searchable');
$('#search').keyup(function() {
	// call updateTable() with the input value
  searchtable.updateTable( $(this).val() );
});