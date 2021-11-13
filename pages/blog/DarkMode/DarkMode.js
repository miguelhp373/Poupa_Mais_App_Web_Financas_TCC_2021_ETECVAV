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
    $('.container-content').attr('id','container-content');
    $('.container-content-post').attr('id','container-content-post');

    if(state == true){
        
        $('#container-content').addClass('darkmode');
        $('#container-content-post').addClass('darkmode');
        
        
        localStorage.setItem('darkmode','true'); 
    }else{
        $('#container-content').removeClass('darkmode');
        $('#container-content-post').removeClass('darkmode');

        localStorage.setItem('darkmode','false');
    }
}



    
