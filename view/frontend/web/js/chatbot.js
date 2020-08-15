define([
    "jquery"
], function($){
    "use strict";
    return function(config, element) {
        $('[data-role=open-chat]').click(function(){
            $('#chat-popup').show();
        });
        $('[data-role=close-chat]').click(function(){
            $('#chat-popup').hide();
        });
        
        $('.chat-form-container').submit(function(event){
            event.preventDefault();
        })
    }
}
)