//this file its works onçy on dashboard

$(document).ready(function () {

    if(!localStorage.getItem('darkmode')){
        localStorage.setItem('darkmode','false');
    }else{
        var stateMode = localStorage.getItem('darkmode');
            if(stateMode == 'true'){
                $("#toggle_darkmode").prop('checked', true);
                DarkMode(true);
            }else{
                $("#toggle_darkmode").prop('checked', false);
                DarkMode(false);
            }
    }

    //toggle button
    const checkbox = $("#toggle_darkmode");

    checkbox.change(function(event) {
        var checkbox = event.target;
        checkbox.checked ? DarkMode(true) :  DarkMode(false);
    });
    //////////////////////////////////////////////////////
});

function DarkMode(state){
    //add id on classes
    $('.nav-bar-left-desktop').attr('id','nav-bar-left-desktop');
    $('.content-page').attr('id','content-page');
    $('.title_page').attr('id', 'title_page');
    $('.text-dark-mode-label').attr('id','text-dark-mode-label');

    if(state == true){
        
        $('#nav-bar-left-desktop').addClass('darkmode');
        $('#content-page').addClass('darkmode');
        $('#title_page').addClass('darkmode');
        $('#text-dark-mode-label').addClass('darkmode');
        
        
        localStorage.setItem('darkmode','true'); 
    }else{
        $('#nav-bar-left-desktop').removeClass('darkmode');
        $('#content-page').removeClass('darkmode');
        $('#title_page').removeClass('darkmode');
        $('#text-dark-mode-label').removeClass('darkmode');


        localStorage.setItem('darkmode','false');
    }
}



    
