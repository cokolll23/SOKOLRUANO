BX.ready(function () {
    // Обработка удаления товара
    $(document).on('click', '.basket-item-actions-remove', function(e) {
        e.preventDefault();

        var itemId = $(this).data('item-id');

        // AJAX-запрос на удаление
       /* $.ajax({
            url: '/bitrix/components/bitrix/sale.basket.basket/ajax.php',
            type: 'POST',
            data: {
                ajax_action: 'DELETE',
                id: itemId,
                sessid: BX.bitrix_sessid()
            },
            success: function(response) {
                if (isEmptyObject(response.DELETED_BASKET_ITEMS)) {
                    // Принудительное обновление компонента
                    //BX.reload();
                    console.log(isEmptyObject(response.DELETED_BASKET_ITEMS));
                }
            }
        });*/
    });
});
function isEmptyObject(obj) {
    for (var i in obj) {
        if (obj.hasOwnProperty(i)) {
            return false;
        }
    }
    return true;
}