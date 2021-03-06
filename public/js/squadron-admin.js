jQuery( document ).ready( function( $ ) {

    //---------------------------------------------------------------------------------------//
    //
    //  ARTICLE CREATE/EDIT
    //
    $( '#article-edit' ).validator().on( 'submit', function(e) {
	    
	     // form failed validation
	    if (e.isDefaultPrevented()) {
			// do nothing
		} else {

	        // don't submit the form
	        e.preventDefault();
	
	        // show spinner to show save in progress
	        $("button.btn-save").html('<i class="fa fa-spinner fa-spin"></i>');
	        
	        // disable all inputs
	        $('#article-edit input textarea').prop('disabled', true);
	 
	        $.post(
	            $( this ).prop( 'action' ),
	            {
	                data: $("#article-edit").serialize(),
	                "_token": $( this ).find( 'input[name=_token]' ).val()
	            },
	            function( data ) {
	                //do something with data/response returned by server
	
	                // clear possible classes for the alert
	                $('#custom-alert').removeClass( 'alert-danger alert-success alert-warning' );
	
	                // set alert
	                $("#alert-content").html( data.message );
	                $('#custom-alert').addClass( data.alert_class );
	                $('#custom-alert').fadeIn(100).delay(2500).fadeOut(200);
	                
	                // if successful
	                if( data.status === 'success' )
	                {
	                    // delay then redirect
	                    setTimeout(function(){ window.location = data.redirect; }, 1500);
	                }
	                else
	                {
		                // re-enable inputs and reset save button
		                $('#article-edit input').prop('disabled', false);
	                    $("button.btn-save").html('Save');
	                }
	            },
	            'json'
	        ); // end post
	    } // end else for validation pass
    } ); // end form submit
    
    //---------------------------------------------------------------------------------------//
    //
    //  FOLDER ADD/EDIT
    //
    $( '#folder-edit' ).validator().on( 'submit', function(e) {
	    
	     // form failed validation
	    if (e.isDefaultPrevented()) {
			// do nothing
		} else {

	        // don't submit the form
	        e.preventDefault();
	
	        //.....
	        //show some spinner etc to indicate operation in progress
	        //.....
	        $("button.btn-save").html('<i class="fa fa-spinner fa-spin"></i>');
	 
	        $.post(
	            $( this ).prop( 'action' ),
	            {
	                data: $("#folder-edit").serialize(),
	                "_token": $( this ).find( 'input[name=_token]' ).val()
	            },
	            function( data ) {
	                //do something with data/response returned by server
	
	                // clear possible classes for the alert
	                $('#custom-alert').removeClass( 'alert-danger alert-success alert-warning' );
	
	                // set alert
	                $("#alert-content").html( data.message );
	                $('#custom-alert').addClass( data.alert_class );
	                $('#custom-alert').fadeIn(100).delay(2500).fadeOut(200);
	                
	                // if successful
	                if( data.status === 'success' )
	                {
	                    // delay then redirect
	                    setTimeout(function(){ window.location = data.redirect; }, 1500);
	                }
	                else
	                {
	                    $("button.btn-save").html('Save');
	                }
	            },
	            'json'
	        ); // end post
	    } // end else for validation pass
    } ); // end form submit
    
    // table sorter
    $( ".th-table-order" ).click(function() {
	    
	    // url path (without params)
		var url = window.location.pathname;
		
	    // get order details
		var order 	= $(this).data('order');
		var orderBy = $(this).data('order-by');

		// get existing params if present
		var search 	= parseQueryString('search');
		var page 	= parseQueryString('page');
	
		// if there's a search in place
		if( typeof search === 'string' ) {
			var search = '&search='+search;
		}
		else {
			var search = '';
		}
		
		// if there's a page set
		if( typeof page === 'string' ) {
			var page = '&page='+page;
		}
		else {
			var page = '';
		}
	
		// redirect
		window.location = '?order-by=' + orderBy + '&order=' + order + search + page;
	});
	
	function parseQueryString(key) {
        var urlParams = '';

        (window.onpopstate = function() {
            var match,
                pl     = /\+/g,  // Regex for replacing addition symbol with a space
                search = /([^&=]+)=?([^&]*)/g,
                decode = function (s) { return decodeURIComponent(s.replace(pl, ' ')); },
                query  = window.location.search.substring(1);

            urlParams = {};
            while (match = search.exec(query)) {
                urlParams[decode(match[1])] = decode(match[2]);
            }
        })();

        if ( urlParams[key] ) {
            return urlParams[key];
        }
    }

});