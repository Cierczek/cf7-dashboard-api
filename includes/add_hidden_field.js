jQuery( document ).ready(function() {

//------------------------------------------------------------------------------------
   //Function to Get Url Parameter
//------------------------------------------------------------------------------------
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
    
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
    
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };


//------------------------------------------------------------------------------------
   //Function to Send Parameter
//------------------------------------------------------------------------------------
 jQuery('form').submit(function () {
        // submit the form
        jQuery.ajax({
            
            //Code changed by Jonatan MenÃ©ndez for Send with our new System
            url: "https://clientes.optimizaclick.com/api/v1/contact-form/send",
            type: 'POST',
            data: {
                server_parameters: {'hostname': window.location.hostname,
                                    'gclid': getUrlParameter('gclid'),
                                    'utm_soure' :getUrlParameter('utm_source'),
                                    'token': tokenLanding,
                                    'url': window.location.href,
                                    'referer'  : document.referrer            
                },data_form : jQuery("form").serialize()
            },
            success: function () {
               
            },
            error: function () {
               
            }
        });
        

         return true;
        
       
    });

});





