$(function () {
    $('#openPopReceita').click(function(){
        $('.popup_actions').removeClass('hidden');
        $('.title_pop').html('Nova Receita');

        $('#form_actions').attr('action','model/main.php?type=receita')
    })

    $('#close_pop_up').click(function(){
        $('.popup_actions').addClass('hidden');
    })

    $('#openPopDespesa').click(function(){
        $('.popup_actions').removeClass('hidden');
        $('.title_pop').html('Nova Despesa')

        $('#form_actions').attr('action','model/main.php?type=despesa')
    })



    
});