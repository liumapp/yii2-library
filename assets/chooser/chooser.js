/**
 * Created by dungang@huluwa.cc on 2016/12/6.
 * 人员选择器
 */
+function ($) {
    'use strict';

    $.stringify = $.stringify || function (obj) {
        var t = typeof (obj);
        if (t != "object" || obj === null) {
            // simple data type
            if (t == "string") obj = '"'+obj+'"';
            return String(obj);
        }
        else {
            // recurse array or object
            var n, v, json = [], arr = (obj && obj.constructor == Array);
            for (n in obj) {
                v = obj[n]; t = typeof(v);
                if (t == "string") v = '"'+v+'"';
                else if (t == "object" && v !== null) v = JSON.stringify(v);
                json.push((arr ? "" : '"' + n + '":') + String(v));
            }
            return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
        }
    };

    $.fn.chooser = function (options) {
        var opts = $.extend({},$.fn.chooser.default,options);
        return this.each(function () {
            var container = $(this);
            var id = container.attr('id');
            var tagContainer = container.find('#'+id + '-tag-box');
            var input = container.find('#'+id+'-hidden');
            var treeNodes = false;
            container
                //渲染标签组件
                .on('renderTag',function () {
                    var nodeString = input.val();
                    tagContainer.empty();
                    if (nodeString) {
                        $.each($.parseJSON(nodeString),function (index,node) {
                            var tag = $('<span class="label label-primary"></span>')
                                .data('id',node.id)
                                .append(node.text)
                                .append($('<i class="fa fa-close"></i>').click(function (e) {
                                    e.preventDefault();
                                    $(this).parent('span.label').remove();
                                    var nodes = [];
                                    tagContainer.find('span.label').each(function () {
                                        var span = $(this);
                                        nodes.push({
                                            id:span.data('id'),
                                            text:span.text()
                                        });
                                    });
                                    input.val($.stringify(nodes));
                                }).css({cursor:'pointer'}));

                            tagContainer.append(tag);
                        });
                    }
                })
                //保存树的选择状态
                .on('saveTree',function () {
                    var ids = [];
                    var nodes = [];
                    container.find(opts.nodeChooser + ':checked').each(function () {
                        var check = $(this);
                        var val = opts.idIsNumber
                            ? parseInt(check.val().trim())
                            : check.val().trim();
                        if ( ids.indexOf(val)==-1) {
                            ids.push(val);
                            nodes.push({
                                id:val,
                                text:check.parent('label').text()
                            });
                        }
                    });
                    input.val($.stringify(nodes));
                })
                //更新树的选择状态
                .on('updateTree',function () {
                    var ids = [];
                    var nodeString = input.val();
                    if (nodeString) {
                        $.each($.parseJSON(nodeString),function (index,node) {
                            ids.push(node.id);
                        });
                        container.find(opts.nodeChooser).each(function () {
                            var _check = $(this);
                            var val = opts.idIsNumber
                                ? parseInt(_check.val().trim())
                                : _check.val().trim();
                            if (ids.indexOf(val) > -1) {
                                _check.prop('checked',true);
                            }
                        });
                    }
                })
                //渲染树，并绑定行为（点击父节点可以自动选择所有的子节点）
                .on('renderTree',function () {
                    container
                        .find('div.tree')
                        .html(treeNodes)
                        .find(opts.nodeToggle).click(function (e) {
                        var _this = $(this);
                        _this.parent('li')
                            .find('input[type=checkbox]:enabled')
                            .prop('checked',_this.prop('checked'));
                    });
                    container.trigger('updateTree');
                })
                //打开树
                .on('openTree',function () {
                    if (treeNodes) {
                        container.trigger('renderTree');
                    } else {
                        $.get(opts.url,function (data) {
                            treeNodes = data;
                            container.trigger('renderTree');
                        });
                    }
                })
                //关闭树
                .on('closeTree',function () {
                    container.find('div.tree').empty();
                });

            var modal = container.find('#'+id+'-modal');
            modal
                .on('hidden.bs.modal', function () {
                    container.trigger('closeTree');
                })
                .on('show.bs.modal', function () {
                    container.trigger('openTree');
                })
                //保存按钮
                .find('#'+id+'-save-button')
                    .click(function (e) {
                        e.preventDefault();
                        container.trigger('saveTree').trigger('renderTag');
                        modal.modal('hide');
                    });
            //根据初始值渲染标签
            container.trigger('renderTag');
        });
    };
    $.fn.chooser.default = {
        nodeToggle:'input.tree-check',
        nodeChooser:'.tree-chooser input[type=checkbox]',
        initValues:'',
        idIsNumber:true,
        url:''
    };
}(jQuery);
