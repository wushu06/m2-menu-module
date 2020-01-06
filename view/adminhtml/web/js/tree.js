var menuItemUrlLoad,  menuItemUrlSave, menu;
var self;
define([
    'jquery',
    'ko',
    'uiComponent',
    'Tbb_Menu/js/content',
    'tbb/nest'
], function ($, ko, Component) {
    'use strict';
    return Component.extend({
        defaults: {
            nav: [],
            menus: '',
            tracks: {
                nav: true,
                menus: true
            },
            imports: {
                menus: 'm2-component2:test'
            },
            exports: {
                nav: 'contentKoComponent:nav'
            }
        },
        initialize: function() {

            this._super();
            self = this;
            menuItemUrlLoad = this.menuItemUrlLoad;
            menu = this.menuCollection;
            //  menu && this.editPen && self.sortablKO(menu);
            this.loadData()
            this.sortablKO(menu)
            $('#save-menu-button').click(function() {
                self.saveConfig()
            });
            window.addEventListener("ajaxLoad", function(data){
                console.log('cliked');
                self.nav = []
                self.loadData()
            });


        },
        saveConfig: function(){
            console.log( {st: $('#nestable3').nestable('serialize')});
            $('.megamenu-loading').show();
            $.ajax({
                type: "POST",
                dataType : 'json',
                data: {st: $('#nestable3').nestable('serialize')},
                url: menuItemUrlSave,
                success: function(response) {
                    console.log(response);
                    self.nav = []
                    self.loadData()


                    $('.megamenu-loading').hide();
                },
                error: function() {
                    alert("error");
                    $('.megamenu-loading').hide();
                }
            });
        },
        editMenuItem: function(item) {
            var el = item.parent ? item.parent : item;
            var itemId = el.id;
            var itemName = el.name;
            var itemUrl = el.url;
            var itemCat = el.cat;
            var itemStatus = el.status;
            var itemType = el.type;
            var itemVisibility = el.visibility;
            var itemClassName = el.class_name

            $('#addMenu').hide();
            $('#editMenu').show();
            $('#deleteMenu').show();
            $('#cancelEdit').show();
            $('#megamenu_menu_url_type').val(el.type);
            jQuery("select#megamenu_menu_url_type").change()
            $('#itemId').val(itemId);
            $('#name').val(itemName)
            el.type === 'category' ? $('#megamenu_category_link').val(itemCat) :  $('#megamenu_category_link').val('')
            el.type === 'category' ? $('#custom_link').val('') : $('#custom_link').val(itemUrl)
            $('#megamenu_enable').val(itemStatus)
            $('#class_name').val(itemClassName)
            $('#visibility').val(itemVisibility)


            switch (el.type) {
                case 'custom_link':
                    $('#custom_link').val(itemUrl);
                    $('#megamenu_category_link').val('');
                    $('#megamenu_cms_link').val('');
                    break;
                case 'category_link':
                    $('#custom_link').val('');
                    $('#megamenu_category_link').val(itemUrl);
                    $('#megamenu_cms_link').val('');
                    break;
                case 'cms_link':
                    $('#custom_link').val('');
                    $('#megamenu_category_link').val('');
                    $('#megamenu_cms_link').val(itemUrl);
                    break;
            }

        },
        loadData: function(){
            $('.megamenu-loading').show();
            var _self = this
            $.ajax({
                type: "POST",
                dataType : 'json',
                data: $('#megamenu_content').serialize() ,
                url: menuItemUrlLoad,
                success: function(response) {
                    console.log(response);
                    _self.nav.push(Object.values(response))
                    $('.megamenu-loading').hide();
                    setTimeout(function(){
                        $('#nestable3').nestable()
                    }, 1000)
                },
                error: function() {
                    alert("error");
                    $('.megamenu-loading').hide();
                }
            });

        },

        sortablKO: function(menu) {
            //console.log(menu);
            //self.nav = ko.observable(Object.values(menu))
            self.editPenImage =   self.editPen

        }

    });
});
