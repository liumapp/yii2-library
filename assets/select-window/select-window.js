/**
 * Created by Lenovo on 2016/12/30.
 *
 */

+function ($) {
    'use strict';

    function Data() {

        this.refer = null;
        this.items = [];
        this.defaultItem = {};

        this.addItems = function (items) {
            for(var i=0; i<items.length; i++) {
                if (this.items[items[i].id] == 'undefined'){
                    var item = this.items[items[i].id];
                    this.items[items[i].id] = $.extend({},this.defaultItem,items[i],item);
                } else {
                    this.items[items[i].id] = items[i];
                }
            }
            this.refer.trigger('update');
        };

        this.updateItem = function (item) {
            if (this.items[item.id]){
                var old = this.items[item.id];
                this.items[item.id] = $.extend({},this.defaultItem,old,item);
                this.refer.trigger('update');
            }
        };

        this.deleteItem = function (id) {
            if (this.items[id]){
                delete this.items[id];
                this.refer.trigger('update');
            }
        };

    }

    $.fn.selectWindow = function (options) {
        var opts = $.extend({},$.fn.selectWindow.default,options);
        return this.each(function () {

            var _this = $(this);
            var dataObj = new Data();
            dataObj.refer = _this;

            _this.on('update',function () {
                var viewContainer = _this.find(opts.viewContainer);
                viewContainer.empty();
                var callable = opts.renderView;
                if (callable){
                    callable(dataObj,viewContainer);
                }
                console.log(1);
            });

            dataObj.addItems(opts.items);

            var childWindow = null;
            var childDoc = null;

            var openButton = _this.find('.openButton').click(function (e) {
                e.preventDefault();
                childWindow = window.open(opts.window.url,
                    "_blank",
                    "toolbar=yes, location=yes, directories=no, " +
                    "status=no, menubar=yes, scrollbars=yes, resizable=no, " +
                    "copyhistory=yes, width="+opts.width+", height="+opts.height);
                childWindow.onload = function (e) {
                    childDoc = $(childWindow.document);
                    childDoc.find('.btn-yes').click(function (e) {
                        e.preventDefault();
                        var items = [];
                        childDoc.find('.data:checked').each(function () {
                            var obj = $(this);
                            items.push(obj.data('obj'));
                        });
                        dataObj.addItems(items);
                        childWindow.close();
                        childWindow = childDoc = null;
                    });
                }
            });
        });
    };

    $.fn.selectWindow.default = {
        viewContainer:'.view',
        renderView:function (dataObj,viewContainer) {},
        //初始默认数据
        items:[],
        amount:0,
        defaultItem:{},
        window:{
            url:'http://www.huluwa.cc',
            height:400,
            width:500
        }
    };
}(jQuery);
