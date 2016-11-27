'use strict';

// Модуль приложения
var app = (function($) {

    // Инициализируем нужные переменные
    var ajaxUrl = '/catalog/edit',
        ui = {
            $categories: $('#categories'),
            $goods: $('#goods')
        };

    // Инициализация дерева категорий с помощью jstree
    function _initTree(data) {
        var category;
        ui.$categories.jstree({
            core: {
                check_callback: true,
                multiple: false,
                data: data
            },
            plugins: ['dnd']
        }).bind('changed.jstree', function(e, data) {
            category = data.node.text;
            ui.$goods.html('Товары из категории ' + category);
            console.log('changed node: ', data);
        }).bind('move_node.jstree', function(e, data) {
            var params = {
                id: +data.node.id,
                old_parent: +data.old_parent,
                new_parent: +data.parent,
                old_position: +data.old_position,
                new_position: +data.position
            };
            _moveCategory(params);
            console.log('move_node params', params);
        });
    }

    // Перемещение категории
    function _moveCategory(params) {
        var data = $.extend(params, {
            action: 'move_category'
        });

        $.ajax({
            url: ajaxUrl,
            data: data,
            dataType: 'json',
            success: function(resp) {
                if (resp.code === 'success') {
                    console.log('category moved');
                } else {
                    console.error('Ошибка получения данных с сервера: ', resp.message);
                }
            },
            error: function(error) {
                console.error('Ошибка: ', error);
            }
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
                    _initTree(resp);
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