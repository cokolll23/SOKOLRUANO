BX.ready(function () {
    // Обработка удаления товара
    $(document).on('click', '.product-item-button-container button', function(e) {
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
