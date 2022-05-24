(function($){
    Drupal.behaviors.testing = {
        attach: function (context,settings) {
            
            $('.region-header',context).once('region-header').on({
                mouseenter: function(){
                    $(this).css("background-color","green");
                },

                mouseleave: function(){
                    $(this).css("background-color","red");
                },

                dblclick: function(){
                    $(this).css("background-color","yellow");
                    alert("Finally this is working")
                }
            });
        }
    };
}(jQuery));