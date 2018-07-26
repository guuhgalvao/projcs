var $loader = jQuery.noConflict();
function showLoader(callback = false){
    //$loader(document.body).addClass('no-overflow');
    $loader('#loader').addClass('fadeIn').css('display', 'block').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
        $loader(this).removeClass('fadeIn');
        if(callback){
            callback();
        }
    });
}

function hideLoader(callback = false){
    $loader('#loader').addClass('fadeOut').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
        $loader(this).removeClass('fadeOut').css('display', 'none');
        //$loader(document.body).removeClass('no-overflow');
        if(callback){
            callback();
        }
    });
}