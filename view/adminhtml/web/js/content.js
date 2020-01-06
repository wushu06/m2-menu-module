var menuItemUrlLoad,  menuItemUrlSave, menuItemUrlEdit, getCategoryCollectionJson;
var self;
define([
    'jquery',
    'ko',
    'uiComponent',
    'Tbb_Menu/js/sortable',
    'tbb/nest'
], function ($, ko, Component, sortable) {
    'use strict';


    return Component.extend({
        defaults: {
            nav: [],
            tracks: {
                nav: true
            }

        },
        initialize: function() {
            this._super();
            self = this;
            $('.dd').nestable('serialize');
            var st =  $('#nestable3').nestable('serialize');
             menuItemUrlEdit = this.menuItemUrlEdit;
             menuItemUrlLoad = this.menuItemUrlLoad;
             menuItemUrlSave = this.menuItemUrlSave;
             self.megamenuKO();
             var _self = this


            $(document).on("change", "select#megamenu_menu_url_type", function() {
                var menuType = $(this).val();
                switch (menuType) {
                    case 'custom_link':
                        $(".admin__field.bss_custom_link").show();
                        $(".admin__field.bss_category_link").hide();
                        $(".admin__field.bss_cms_link").hide();
                        $('#megamenu_category_link').val('');
                        break;
                    case 'category_link':
                        $(".admin__field.bss_custom_link").hide();
                        $(".admin__field.bss_cms_link").hide();
                        $(".admin__field.bss_category_link").show();
                        $('#custom_link').val('');
                        break;
                    case 'cms_link':
                        $(".admin__field.bss_custom_link").hide();
                        $(".admin__field.bss_category_link").hide();
                        $(".admin__field.bss_cms_link").show();
                        $('#custom_link').val('');
                        break;
                    default:
                        $(".admin__field.bss_custom_link").hide();
                        $(".admin__field.bss_category_link").hide();
                        $(".admin__field.bss_cms_link").hide();
                        $('#megamenu_category_link').val('');
                        $('#custom_link').val('');
                        break;
                }
            });
            $(document).on("change", "select#megamenu_category_link", function() {
                var catVal = $(this).find("option:selected").text();
               $('#name').val(catVal)
            });
            $(document).on("change", "select#megamenu_cms_link", function() {
                var catVal = $(this).find("option:selected").text();
               $('#name').val(catVal)
            });

        },

        addToMenu : function() {
                this.ajaxOnAdd()

        },
        ajaxOnAdd: function (edit = false) {

            if(!this.checkValues()){
                 alert('Required field is missing');
                 return;
             }
            $('.megamenu-loading').show();
            var _self = this
            $.ajax({
                type: "POST",
                dataType : 'json',
                data: $('#megamenu_content').serialize() ,
                url: menuItemUrlEdit,
                success: function(response) {
                    console.log(response);
                    _self.dispatchCustomEvent()
                    _self.resetValues();
                    $('.megamenu-loading').hide();
                },
                error: function(e) {
                    console.log(e);
                    alert("error");
                    $('.megamenu-loading').hide();
                }
            });
        },
        editItem: function(){
            if(!this.checkValues()){
                alert('Required field is missing');
                return;
            }

            $('#addMenu').show();
            $('#editMenu').hide();
            $('#deleteMenu').hide();
            this.ajaxOnAdd(true)
        },
        deleteItem: function(){
            var id = $('#itemId').val();
            var _self = this
            $.ajax({
                type: "POST",
                dataType : 'json',
                data: {delete: id} ,
                url: menuItemUrlLoad,
                success: function(response) {

                   // $(`[data-id='${id}']`).remove()
                  //  this.resetValues();
                    _self.dispatchCustomEvent()
                    _self.resetValues();
                    $('.megamenu-loading').hide();
                },
                error: function() {
                    alert("error");
                    $('.megamenu-loading').hide();
                }
            });
        },
        dispatchCustomEvent: function (){
            const eventAwesome = new CustomEvent('ajaxLoad');
            window.dispatchEvent(new CustomEvent('ajaxLoad', { delete: true}))
        },
        resetValues: function(){
            $('#itemId').val('');
            $('#name').val('')
            $('#custom_link').val('')
            $('#megamenu_enable').val(1);
            $('#megamenu_category_link').val('');
            $('#megamenu_cms_link').val('');
            $('#class_name').val('')
            $('#visibility').val(1)
            $('#addMenu').show();
            $('#editMenu').hide();
            $('#deleteMenu').hide();

        },
        checkValues: function(){
            var isValid = true;
            if ( $('#name').val() === '' )
                isValid = false;
            /*$('.form-field').each(function() {
                if ( $(this).val() === '' )
                    isValid = false;
            });*/
            return isValid;
        },
        cancelEditing: function(){
            $('#addMenu').show();
            $('#editMenu').hide();
            $('#deleteMenu').hide();
            $('#cancelEdit').hide();
            $('#itemId').val('');
            $('#name').val('')
            $('#class_name').val('')
            $('#megamenu_menu_url_type').val('custom_link');
            $('#custom_link').val('')
            $('#visibility').val(1)
            $('#status').val(1)
        },



        megamenuKO: function(id,title, itemName, item_id,active, url_type , custom_link ,  category_link) {

            self.enables = [
                {'id': 1 , 'title' : 'Yes'},
                {'id': 0 , 'title' : 'No'}
            ];
            self.visibility = [
                {'id': 1 , 'title' : 'Visible'},
                {'id': 0 , 'title' : 'Hidden'}
            ];
            self.menuUrlType = [
                {'id': 'custom_link' , 'title' : 'Custom Link'},
                {'id': 'category_link' , 'title' : 'Category Link'},
                {'id': 'cms_link' , 'title' : 'Cms Page'}
            ];
            self.categoriesLink2 = JSON.parse(this.getCategoryCollectionJson);
            self.cmsPages = JSON.parse(this.getCmsPagesJson);


            self.itemName = itemName
            self.className = ''
            self.className = ''
            self.menuId = ko.observable(id);
            self.itemId = ko.observable(item_id);
            self.menuTitle = ko.observable(title);
            self.chosenEnable = 1;
            self.chosenVisibility = 1;
            self.chosenMenuUrlType = ko.observable(url_type);
            self.customLink = custom_link;
           // self.chosenCategoriesLink = ko.observable(category_link);

            self.storeId = this.storeId;
        }
    });
});
