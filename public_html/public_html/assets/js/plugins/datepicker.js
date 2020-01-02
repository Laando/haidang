var Datepicker = function () {

    return {
        
        //Datepickers
        initDatepicker: function () {
	        // Regular datepicker
	        $('#date').datepicker({
	            dateFormat: 'dd/mm/yy',
	            prevText: '<i class="fa fa-angle-left"></i>',
	            nextText: '<i class="fa fa-angle-right"></i>'
	        });
	        
	        // Date range
	        $('#finish').datepicker({
	            dateFormat: 'dd/mm/yy',
	            prevText: '<i class="fa fa-angle-left"></i>',
	            nextText: '<i class="fa fa-angle-right"></i>',
	            onSelect: function( selectedDate )
	            {
	                $('#start').datepicker('option', 'maxDate', selectedDate);
	            }
	        });
            // Date range
            $('#checkin').datepicker({
                dateFormat: 'dd/mm/yy',
                prevText: '<i class="fa fa-angle-left"></i>',
                nextText: '<i class="fa fa-angle-right"></i>',
                onClose: function( selectedDate )
                {
                    $('#checkout').datepicker( "destroy" );
                    //$('#checkout').removeClass("hasDatepicker").removeAttr('id');
                    $('#checkout').datepicker({
                        dateFormat: 'dd/mm/yy',
                        prevText: '<i class="fa fa-angle-left"></i>',
                        nextText: '<i class="fa fa-angle-right"></i>',
                        minDate: selectedDate,
                        maxDate: "+1M +10D"
                    });
                }
            });
	        
	        // Inline datepicker
	        $('#inline').datepicker({
	            dateFormat: 'dd/mm/yy',
	            prevText: '<i class="fa fa-angle-left"></i>',
	            nextText: '<i class="fa fa-angle-right"></i>'
	        });
	        
	        // Inline date range
	        $('#inline-start').datepicker({
	            dateFormat: 'dd/mm/yy',
	            prevText: '<i class="fa fa-angle-left"></i>',
	            nextText: '<i class="fa fa-angle-right"></i>',
	            onSelect: function( selectedDate )
	            {
	                $('#inline-finish').datepicker('option', 'minDate', selectedDate);
	            }
	        });
	        $('#inline-finish').datepicker({
	            dateFormat: 'dd/mm/yy',
	            prevText: '<i class="fa fa-angle-left"></i>',
	            nextText: '<i class="fa fa-angle-right"></i>',
	            onSelect: function( selectedDate )
	            {
	                $('#inline-start').datepicker('option', 'maxDate', selectedDate);
	            }
	        });
        }

    };
}();