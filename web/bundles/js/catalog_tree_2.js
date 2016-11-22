/**
 * Created by grishalive on 11/20/16.
 */

'use strict';

// Модуль приложения
var app = (function($) {

    // Инициализируем нужные переменные
    var ajaxUrl = '',
        ui = {
            $categories: $('#categories'),
            $goods: $('#goods')
        };

    // Инициализация дерева категорий с помощью jstree
    function _initTree(data) {
        ui.$categories.jstree({
            core: {
                check_callback: true,
                multiple: false,
                data: data
            },
            plugins: ['dnd']
        }).bind('changed.jstree', function(e, data) {
            var category = data.node.text;
            ui.$goods.html('Товары из категории ' + category);
            console.log('node data: ', data);
        });
    }

    // Загрузка категорий с сервера
    function _loadData() {
        var params = {
            action: 'get_categories'
        };

        $.ajax({
            url: ajaxUrl,
            method: 'GET',
            data: params,
            dataType: 'json',
            success: function(resp) {
                // Инициализируем дерево категорий
                if (resp.code === 'success') {
                    _initTree(resp.result);
                } else {
                    console.error('Ошибка получения данных с сервера: ', resp.message);
                }
            },
            error: function(error) {
                console.error('Ошибка: ', error);
            }
        });
    }

    // Инициализация приложения
    function init() {
        _loadData();
    }

    // Экспортируем наружу
    return {
        init: init
    }

})(jQuery);

jQuery(document).ready(app.init);
