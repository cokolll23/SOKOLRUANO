BX.ready(function () {
    var ammountInput = $('#basket-item-table  input');
    var ammountInputVal = ammountInput.val();
    //console.log(ammountInput.lenght);

    $.each(ammountInput,function (index,value) {
        console.log("инпут : " + $(value).val());
    });


    //alert(ammountInputVal);
    // Обработка удаления товара
    $(document).on('click', '.product-item-amount-field-btn-plus', function(e) {
        e.preventDefault();
       var _this = $(this);
       var targt = e.target
        var elId =_this.attr('id').split('_',3)[2] ;

        console.log(elId);

        // AJAX-запрос на удаление
        $.ajax({
            url: '/local/js/lab/mainjs/src/ajax.php',
            type: 'POST',
            data: {
                act: 'add2basket',
                id: elId,
            },
            success: function(response) {

            }
        });
    });
});
