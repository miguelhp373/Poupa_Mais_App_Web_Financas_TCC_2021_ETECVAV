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
        $('.currency-value-display').css({'color':'#FFFF'});
        $('.title_page').css({'color':'#FFFF'});
        $('.page-link').addClass("bg-dark");
        $('.card-text-top').css({'color':'#FFFF'});
        $('.fa-wallet').css({'color':'#FFFF'});
        $('.fa-university').css({'color':'#FFFF'});
        $('.title-row').css({'color':'#FFFF'});
        $('.span-top-mobile').css({'color':'#FFFF'});
        $('.container_page').css({'background-color':'#3F3351'});
        $('.fc-toolbar-title').css({'color':'#FFFF'});
        $('.fc-toolbar-title').css({'border':'#000'});
        $('.fc-prev-button').css({'border':'1px solid'});
        $('.fc-next-button').css({'border':'1px solid'});
        $('.fc-today-button').css({'border':'1px solid'});
        $('.fc-dayGridMonth-button').css({'border':'1px solid'});
        $('.fc-listYear-button').css({'border':'1px solid'});
        $('.thead-grid').css({"background-color":'#3B185F'});
        $('.thead-grid').css({'color':'#FFFF'});
        $('.fa-edit').css({'color':'#FFFF'});
        $('.material-icons').css({'color':'#FFFF'});
        $('.title_pop').css({'color':'#FFFF'});
        $('.text-popmodal').css({'color':'#FFFF'});
        $('#col-con01').addClass('darkmode');
        $('#content_page').addClass('darkmode');
        $('.text-adm-page').css({'color':'#FFFF'});
        $('.container-content').css({'background-color':'#3F3351'});
        $('.text-modal').css({'color':'#FFFF'});
        
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
        $('.card-balance').css({'background-color':'#FFFF'});
        $('.value_format').css({'color':'#000'});
        $('.column_content').css({'background-color':'#f3f3f3'})
        $('.lb_dates').css({'color':'#000'});
        $('.filter_title').css({'color':'#000'});
        $('.currency-value-display').css({'color':'#000'});
        $('.title_page').css({'color':'#000'});
        $('.page-link').removeClass("bg-dark");
        $('.fa-wallet').css({'color':'#000'});
        $('.fa-university').css({'color':'#000'});
        $('.card-text-top').css({'color':'#000'});
        $('.title-row').css({'color':'#000'});
        $('.span-top-mobile').css({'color':'#000'});
        $('.container_page').css({'background-color':'#f3f3f3'});
        $('.fa-edit').css({'color':'#000'});
        $('.material-icons').css({'color':'#000'});
        $('.title_pop').css({'color':'#000'});;
        $('.text-popmodal').css({'color':'#000'});
        $('#col-con01').removeClass('darkmode');
        $('.text-adm-page').css({'color':'#000'});
        $('.container-content').css({'background-color':'#f3f3f3'});
        $('.text-modal').css({'color':'#000'});
    
        
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
    $('.currency-value-display').attr('id','currency-value-display');
    $('.text-container').attr('id','text-container');
    $('.col-con01').attr('id','col-con01');
    
}



    
