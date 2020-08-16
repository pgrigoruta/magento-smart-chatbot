define([
    "jquery"
], function($){
    "use strict";
    return function(config, element) {
        $('[data-role=open-chat]').click(function(){
            $('#chat-popup').show();
            $('.typing-indicator').show();

            $.get( config.historyUrl )
                .done(function( data ) {
                    
                    var initialConversation = '';
                    $.each(data,function(index,value){
                        initialConversation+="<div class='type-"+value.type+"'>"+value.message+"</div>";
                    });
                    
                    $('#transcript-window').append(initialConversation);

                    $('.typing-indicator').hide();
                    
                    $("#transcript-window").animate({ scrollTop: $('#transcript-window').prop("scrollHeight")}, 500);
                });
            
            
        });
        $('[data-role=close-chat]').click(function(){
            $('#chat-popup').hide();
        });
        
        $('.chat-form-container').submit(function(event){
            event.preventDefault();
            
            var chatMsg = $('#chat-msg').val();
            $('#chat-msg').val('');
            $('#transcript-window').append("<div class='type-q'>"+chatMsg+"</div>");
            $('.typing-indicator').show();
            
            $.get( config.chatUrl, { msg: chatMsg } )
            .done(function( data ) {
                $('#transcript-window').append("<div class='type-a'>"+data.response+"</div>");
                $('.typing-indicator').hide();
                
                $("#transcript-window").animate({ scrollTop: $('#transcript-window').prop("scrollHeight")}, 100);
            });
        })
    }
}
)