$(document).ready(function () {

    if(!localStorage.getItem('darkmode')){
        localStorage.setItem('darkmode','false');
    }else{
        var stateMode = localStorage.getItem('darkmode');
            if(stateMode == 'true'){
                DarkMode(true);
            }else{
                DarkMode(false);
            }
    }
});

function DarkMode(state){

    addClasses()

    if(state == true){
        
        $('#nav-bar-left-desktop').addClass('darkmode');
        $('#content-page').addClass('darkmode');
        $('#content_page').addClass('darkmode');
        $('#title_page').addClass('darkmode');
        $('#text-dark-mode-label').addClass('darkmode');
        $('#label_btn_home').addClass('darkmode');
        $('#select_image_pop_up').addClass('darkmode');
        $('#title_modal_avatar').addClass('darkmode');
        $('#main_container').addClass('darkmode');
        $('#name').addClass('darkmode');
        $('#email').addClass('darkmode');
        $('#text').addClass('darkmode');
        $('#message').addClass('darkmode');
        $('#row-grid').addClass('darkmode');
        $('#content-page-mobile').addClass('darkmode');
        $('#container-content-grid-transactions').addClass('darkmode');
        $('#content-grid-container').attr('darkmode');
        $('.type-row').css({'color':'#FFFF'});  
        $('.card-balance').css({'background-color':'#1F1D36'})  
        $('.value_format').css({'color':'#FFFF'});
        $('.column_content').css({'background-color':'#1F1D36'})
        $('.lb_dates').css({'color':'#FFFF'});
        $('.filter_title').css({'color':'#FFFF'});
        
        localStorage.setItem('darkmode','true'); 
    }else{
        $('#nav-bar-left-desktop').removeClass('darkmode');
        $('#content-page').removeClass('darkmode');
        $('#content_page').removeClass('darkmode');
        $('#title_page').removeClass('darkmode');
        $('#text-dark-mode-label').removeClass('darkmode');
        $('#label_btn_home').removeClass('darkmode');
        $('#select_image_pop_up').removeClass('darkmode');
        $('#title_modal_avatar').removeClass('darkmode');
        $('#main_container').removeClass('darkmode');
        $('#name').removeClass('darkmode');
        $('#email').removeClass('darkmode');
        $('#text').removeClass('darkmode');
        $('#message').removeClass('darkmode');
        $('#row-grid').removeClass('darkmode');
        $('#content-page-mobile').removeClass("darkmode");
        $('#container-content-grid-transactions').removeClass('darkmode');
        $('#content-grid-container').removeClass('darkmode');
        $('.type-row').css({'color':'#000'});
        $('.card-balance').css({'background-color':'#f3f3f3'});
        $('.value_format').css({'color':'#000'});
        $('.column_content').css({'background-color':'#f3f3f3'})
        $('.lb_dates').css({'color':'#000'});
        $('.filter_title').css({'color':'#000'});
        
        
        


        localStorage.setItem('darkmode','false');
    }
}


function addClasses(){
    $('.nav-bar-left-desktop').attr('id','nav-bar-left-desktop');
    $('.content-page').attr('id','content-page');
    $('.content_page').attr('id','content_page');
    $('.title_page').attr('id', 'title_page');
    $('.text-dark-mode-label').attr('id','text-dark-mode-label');
    $('.label_btn_home').attr('id','label_btn_home');
    $('.title_modal_avatar').attr('id','title_modal_avatar');
    $('.main_container').attr('id','main_container');
    $('.name').attr('id','name');
    $('.email').attr('id','email');
    $('.text').attr('id','text');
    $('.message').attr('id','message');
    $('.row-grid').attr('id','row-grid');
    $('.content-page-mobile').attr('id','content-page-mobile');
    $('.content-grid-container').attr('id','content-grid-container');

    
}



    
