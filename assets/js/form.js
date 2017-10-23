$(document).on('ready', function() {

  function isValidEmail( email ){
    var addressCheck = new RegExp( /^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i );
    return addressCheck.test( email );
  }

  var contactForm = '.inscriere';

  $( contactForm ).submit( function( event ){

    event.preventDefault();

  	var contactRequired = '.required-field';
  	var contactFormSending = 'Te rugam sa astepti...';
  	var contactFormSendingButton = 'Se trimite...';
  	var contactFormSuccess = 'Multumim, cererea ta de inscriere a fost trimisa!';
  	var contactFormError = 'Oh, o eroare a aparut in cererea ta de inscriere, te rugam sa mai incerci o data.';
  	var contactFormFillFields = 'Te rugam sa completezi toate campurile.';
  	var contactFormValidEmail = 'Te rugam sa introduci o adresa de email valida.';

  	var formSubmit = '.form-submit';

    // References
    var form = $( this );
    var responseMessage = $('.cform-response');
    var formElement = form.find( '.form-element' );
    var formElements = form.find( formElement );
    var emailField = form.find( 'input[type="email"]' );
    var submit = form.find( formSubmit );

    // Check action, method and
    // serialize input
    var formData = [];
    var formMessage = encodeURIComponent(form.find( 'textarea[name=motivatie]' ).val() + '\n' );
    var formAux = [];

    // Aux form elements, exclude submit button
    form.find( 'input:not([type=submit]),select,textarea' ).each(
      function ( key, value ) {
        var formElement = $( value );
        var elementName = formElement.attr( 'name' );
        if(formElement.hasClass( 'form-aux' ) && elementName ) {

          // We need label, and so on.
          var formLabel = formElement.data( 'label' ) || elementName;
          var currentTextLabel = formElement.find( 'option:selected' ).text();
          var formValue = formElement.val();
          if(!formValue && formElement.is( 'select' )) {
            if(formLabel == currentTextLabel) {
              formValue = 'Not selected';
            } else {
              formValue = formElement.find( 'option:selected' ).text();
            }
          } else if (formElement.attr( 'type' ) == 'checkbox' && !formElement.prop( 'checked' )) {
            formValue = 'Not checked';
          }
          formAux.push({
            'name': elementName,
            'label': encodeURIComponent(formLabel),
            'value': encodeURIComponent(formValue),
          });

          // We do not want anything undefined ie. no name elms
        } else if(elementName && elementName != 'message') {
          formData.push(elementName + '=' + encodeURIComponent(formElement.val()));
        }
        // formData.encodeURIComponent();
      }
    );

    // Contact aux form elements
    for (var i = 0; i < formAux.length; i ++) {
      var formAuxString = encodeURIComponent( '\n' ) + formAux[i].label + '%3A%20' + formAux[i].value;
      formMessage += formAuxString;
    }
    formData.push( 'message=' + formMessage );
    formData = formData.join( '&' );

    // Validation flags
    var emptyFields = false;
    var filledFields = false;
    var validEmail = false;

    // Clear error class
    contactRequired = contactRequired.split('.').join('');
    formElements.removeClass( contactRequired );

    // Empty fields
    formElements.each( function(){
      if( $( this ).attr( 'required' ) ){
        if( !$( this ).val() ){
          emptyFields = true;
          $( this ).addClass( contactRequired );
          responseMessage
            .hide()
            .text( contactFormFillFields )
            .fadeIn( 200 );
        }
      }
    });
    if ( !emptyFields ) filledFields = true;

    // Invalid email
    if( emailField.val() && !isValidEmail( emailField.val() ) ){
      responseMessage
        .hide()
        .text( contactFormValidEmail )
        .fadeIn( 200 );
      emailField.addClass( contactRequired );
    }else{
      validEmail = true;
    }


    // If empty fields and invalid
    // email merge messages
    if( emptyFields && emailField.val() && !isValidEmail( emailField.val() ) ){
      responseMessage
        .hide()
        .text( contactFormFillFields + ' ' + contactFormValidEmail )
        .fadeIn( 200 );
    }
    if( filledFields && validEmail ){

      // Change submit text
      var submitValue = $( submit ).val();
      $( submit )
        .css({ width: $( submit ).outerWidth() + 'px' })
        .val( contactFormSendingButton )
        .attr( 'disabled', true );

      // Sending Message
      responseMessage
        .hide()
        .text( contactFormSending )
        .fadeIn( 200 );
      // Send
      $.ajax({
        url: '../assets/php/inscriere.php',
        type: 'POST',
        data: formData,
        dataType: 'json'
      }).done( function( data ){
        try {
          if( data == true ){

            // Set success message
            responseMessage.text( contactFormSuccess );
            responseMessage
              .delay( 1500 )
              .fadeOut( 200 );
            formElements.val('');
          } else {

            // Set error message
            var errorMessage = (typeof data.json.error_message == 'undefined' ) ? 'There is a possibility that your message was not sent. Please check up the server or script configuration.' : data.json.error_message ;
            responseMessage
              .hide()
              .text( contactFormError + ' ' + errorMessage  )
              .fadeIn( 200 );
          }
        } catch ( e ) {
          console.log( 'error in parsing returned ajax data: '+ e );
          console.log(data);

        }
      }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log( 'Error occured in processing your request:' );
        console.log( jqXHR );
        console.log( 'Text status' );
        console.log( textStatus );
        console.log( 'Error thrown' );
        console.log( errorThrown );
        console.log( 'Servre response' );
        console.log( jqXHR.status );
        console.log( 'Response Text may contain error output form PHP' );
        console.log( qXHR.responseText );
        // Set error message
        responseMessage
          .hide()
          .text( contactFormError + ' (Please see the console for error details.)' )
          .fadeIn( 200 );
      }).always(function(){

        // Revert button value
        $( submit )
          .css({ width: '' })
          .val( submitValue )
          .attr( 'disabled', false );
      });
    }
  });



});
