/**
 * Created by liumapp.com@gmail.com on 2016/12/9.
 */
+function ($) {
    'use strict';

    $.fn.relationCount = function (options) {
        var opts = $.extend({},$.fn.relationCount.default,options);
        return this.each(function () {
            var _this = $(this);
            _this.on('update',function () {
                $.getJSON(opts.url,function (data) {
                    if (data.count > 0) {
                        _this.find('a')
                            .append('<span class="pull-right badge bg-'+opts.color+'">'
                                +data.count
                                +'</span>');
                    }
                });
            });
            _this.trigger('update');
        });
    };
    $.fn.relationCount.default = {
        color:'red',
        url:''
    };
}(jQuery);