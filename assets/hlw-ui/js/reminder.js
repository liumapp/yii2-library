/**
 * Created by liumapp on 2017/2/22.
 */

(function ($) {

    "use strict";

    setInterval(function () {
        $.ajax({
            url:window.location.origin+window.location.pathname+'?r=notification/reminder/reminders',
            data:{},
            Type:'get',
            success:function (data) {
                $('body').append(data)
            }
        })
    },30000)



})(jQuery);
