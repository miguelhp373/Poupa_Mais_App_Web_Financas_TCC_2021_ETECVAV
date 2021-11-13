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

    $('#btn-edit-currency').click(function(){
        $('.popup_currency').removeClass('hidden');
        $('.title_pop').html('Editar Saldo')
    })

    $('#close_pop_up_currency').click(function(){
        $('.popup_currency').addClass('hidden');
    })
    
});