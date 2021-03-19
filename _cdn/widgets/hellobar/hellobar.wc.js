$(function () {
    //HELLOBAR CONTROL
    $(window).load(function () {
        var HelloKey = window.location.href;
        
        $.post(BASE + "/_cdn/widgets/hellobar/hellobar.ajax.php", {url: HelloKey}, function (data) {
            //EFFECTS
            if (data.hello_position === 'center') {
                $("body").prepend(data.hello);

                setTimeout(function () {
                    $(".wc_hellobar").fadeIn(function () {
                        $(".wc_hellobar_box").animate({'opacity': 1, 'top': '100'}, 400);
                        wc_helloclose();
                    });
                }, 1000);
            }

            if (data.hello_position === 'right_top' || data.hello_position === 'right_bottom') {
                $("body").prepend(data.hello);

                setTimeout(function () {
                    $(".wc_hellobar").fadeIn(function () {
                        $(".wc_hellobar").animate({'opacity': 1, 'right': '20'}, 400);
                        wc_helloclose();
                    });
                }, 1000);
            }
            
            if (data.hello_position === 'exit_intent' ) {
               $("body").prepend(data.hello);
                const mouseEvent = e => {
                if (!e.toElement && !e.relatedTarget) {
                    document.removeEventListener('mouseout', mouseEvent);
                    
                    setTimeout(function () {
                    $(".wc_hellobar").fadeIn(function () {
                        $(".wc_hellobar_box").animate({'opacity': 1, 'top': '100'}, 400);
                        wc_helloclose();
                    });
                }, 100);
                }
            };

            document.addEventListener('mouseout', mouseEvent);
            }
            

            //TRAKING
            $(".wc_hellobar_cta").click(function () {
                var HellobarId = $(this).attr("id");
                var HellobarLink = $(this).attr("href");

                $("#" + HellobarId + ".wc_hellobar").fadeOut(50);
                $.post(BASE + "/_cdn/widgets/hellobar/hellobar.ajax.php", {action: 'track', hello: HellobarId}, function () {
                    window.open(HellobarLink);
                });
                return false;
            });
        }, 'json');
        
        
    });
});

//HELLO CLOSE
function wc_helloclose() {
    $(".wc_hellobar_close").click(function () {
        var HelloBar = $(this).attr("id");
        $("#" + HelloBar + ".wc_hellobar").fadeOut();
    });
}


jQuery(document).on('touchstart', function(){
     $('body').addClass('on-mobile-device');
 });
  function myScrollSpeedFunction(){
     if( jQuery('body').hasClass('on-mobile-device') ){ 
         if(my_scroll() < -200){
             //Your code here to display Exit Intent popup
            
                    $(".wc_hellobar").fadeIn(function () {
                        $(".wc_hellobar_box").animate({'opacity': 1, 'top': '100'}, 400);
                        wc_helloclose();
                    });
              
         }
     }
 }

 var my_scroll = (function(){ //Function that checks the speed of scrolling
 var last_position, new_position, timer, delta, delay = 50; 
 function clear() {
     last_position = null;
     delta = 0;
 }

 clear();
 return function(){
     new_position = window.scrollY;
     if ( last_position != null ){
         delta = new_position -  last_position;
     }
     last_position = new_position;
     clearTimeout(timer);
     timer = setTimeout(clear, delay);
     return delta;
 };
 })();

 jQuery(document).on('scroll', myScrollSpeedFunction );