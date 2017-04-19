/**
 * Created by Lenovo on 2016/12/17.
 */

+function ($) {

    $.fn.select1 = function (options) {
        var opts = $.extend({}, $.fn.select1.default, options);
        return this.each(function () {
            var _this = $(this);
            var _value = _this.find('#'+opts.valId);
            var _name = _this.find('#'+opts.namId);
            var _text = _this.find('span').text(opts.prompt);
            var _list = _this.find('ul').css({
                maxHeight:opts.maxHeight,
                overflowY:'auto'
            });
            var _searchBox = $('<li class="text-center"></li>')
                .on('clean',function (e) {
                    _list.find('li:not(:first-child)').remove();

                });
            var _search = $('<input style="width:80%;" type="text" value="" />')
                .on('keyup',function (e) {
                    _this.trigger('update');
                });
            _searchBox.append(_search);
            _list.append(_searchBox);

            _this.on('update',function () {
                var params = {};
                params[opts.paramName] = _value.val();
                params['term'] = _search.val();
                $.getJSON(
                    opts.url,
                    params,
                    function (data) {
                        var val = _value.val();
                        _searchBox.trigger('clean');
                        $.each(data,function (idx,elem) {
                            _list.append('<li class="divider"></li>');
                            var option = $('<li>');
                            if (elem.id == val) {
                                option.addClass('active');
                                _name.val(elem.text);
                                _text.html(elem.text.trim());
                            }
                            var a = $('<a href="#">');
                            a.attr("data-val",elem.id)
                                .html(elem.text)
                                .click(function (e) {
                                    e.preventDefault();
                                    var _aThis = $(e.target);
                                    _value.val(_aThis.data("val"));
                                    _name.val(_aThis.text());
                                    _text.html(_aThis.text().trim());
                                });
                            option.append(a);
                            _list.append(option);
                        });
                    }
                );
            });
            _this.on('show.bs.dropdown',function () {
                var val = _value.val();
                _list.find('a').each(function(){
                    var a = $(this);
                    if (a.data('val')==val){
                        a.parent().addClass('active');
                    } else {
                        a.parent().removeClass('active');
                    }
                });
            });
            _this.trigger('update');
        });
    };

    $.fn.select1.default = {
        paramName:'adminId',
        maxHeight:'300px',
        valId: '',
        namId: '',
        url: '',
        prompt: '请选择'
    };
}(jQuery);