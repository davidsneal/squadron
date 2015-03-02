jQuery( document ).ready( function( $ ) {

    //---------------------------------------------------------------------------------------//
    //
    //  POST CREATE/EDIT
    //
    $( '#post-edit' ).on( 'submit', function(e) {

        // don't submit the form
        e.preventDefault();

        //.....
        //show some spinner etc to indicate operation in progress
        //.....
        $("button.btn-save").html('<i class="fa fa-spinner fa-spin"></i>');
 
        $.post(
            $( this ).prop( 'action' ),
            {
                data: $("#post-edit").serialize(),
                "_token": $( this ).find( 'input[name=_token]' ).val()
            },
            function( data ) {
                //do something with data/response returned by server

                // clear possible classes for the alert
                $('#custom-alert').removeClass( 'alert-danger alert-success alert-warning' );

                // set alert
                $("#alert-content").html( data.message );
                $('#custom-alert').addClass( data.alert_class );
                $('#custom-alert').fadeIn(100).delay(1500).fadeOut(200);
                
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
        );
    } );

});