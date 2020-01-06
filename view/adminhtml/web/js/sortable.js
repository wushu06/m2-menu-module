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
            people: [],
            menus: '',
            tracks: {
               people: true,
               menus: true
            },
            imports: {
                menus: 'm2-component2:test'
            },
            exports: {
                people: 'm2-component:nav'
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


          /*  setTimeout(function(){

                $('#nestable3').nestable()
            }, 2000)*/
            $('#save-menu-button').click(function() {
                self.saveConfig()
            });
            window.addEventListener("ajaxLoad", function(data){
                console.log('cliked');
                self.people([])
                self.loadData()
            });


        },
        saveConfig: function(){

            $('.megamenu-loading').show();
            $.ajax({
                type: "POST",
                dataType : 'json',
                data: {st: $('#nestable3').nestable('serialize')},
                url: menuItemUrlSave,
                success: function(response) {
                    self.people([])
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
            console.log(el);
            var itemId = el.id;
            var itemName = el.name;
            var itemUrl = el.url;
            var itemCat = el.cat;
            var itemStatus = el.status;
            var itemType = el.type;


            $('#addMenu').hide();
            $('#editMenu').show();
            $('#deleteMenu').show();

            $('#megamenu_menu_url_type').val(el.type === 'category' ? 0 : 1);
            jQuery("select#megamenu_menu_url_type").change()
            $('#itemId').val(itemId);
            $('#name').val(itemName)

            el.type === 'category' ? $('#megamenu_category_link').val(itemCat) :  $('#megamenu_category_link').val('')
            el.type === 'category' ? $('#custom_link').val('') : $('#custom_link').val(itemUrl)
            $('#megamenu_enable').val(itemStatus)

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
                   _self.people.push(Object.values(response))
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
            //self.people = ko.observable(Object.values(menu))
            self.editPenImage =   self.editPen




        },




        megamenuKO: function(id,title, itemName, item_id,active, url_type , custom_link ,  category_link) {

            self.itemName = ko.observable(id);
            self.customLink = 'some linke';

            self.enables = [
                {'id': 1 , 'title' : 'Yes'},
                {'id': 0 , 'title' : 'No'}
            ];
            self.menuUrlType = [
                {'id': 1 , 'title' : 'Custom Link'},
                {'id': 0 , 'title' : 'Category Link'}
            ];
            self.categoriesLink2 = '';


            self.menuId = ko.observable(id);
            self.itemId = ko.observable(item_id);
            self.menuTitle = ko.observable(title);
            self.chosenEnable = ko.observable(active);
            self.chosenMenuUrlType = ko.observable(url_type);
            // self.chosenCategoriesLink = ko.observable(category_link);

            self.storeId = this.storeId;
        }
    });
});
