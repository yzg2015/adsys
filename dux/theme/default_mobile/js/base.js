(function ($, owner) {
    owner.frame = function () {
        dux.init();
    };
}(jQuery, window.base = {}));

(function ($, owner) {
    /**
     * 分类处理
     */
    owner.category = function ($el) {
        var $layout = $($el);
        var switchClass = function (i) {
            $layout.children('.class-first').find('li').removeClass('active');
            $layout.children('.class-first').children('li:eq(' + i + ')').addClass('active');
            $layout.children('.class-son').find('.son-item').removeClass('active');
            $layout.children('.class-son').children('.son-item:eq(' + i + ')').addClass('active');
        };

        $layout.children('.class-first').on('click', 'li', function () {
            var i = $(this).index();
            switchClass(i);
        });
    };


}(jQuery, window.common = {}));

(function ($, owner) {
    /**
     * 统计购物车
     * @param $el
     */
    owner.count = function ($el) {
        var $layout = $($el);
        window.count = function (num, info, $input) {
            app.ajax({
                url: $layout.data('urlNum'),
                data: $.extend({}, info, {qty: num}),
                type: 'post',
                success: function () {
                    $input.val(num);
                    $input.parents('li').find('[data-price]').text((num * info.price).toFixed(2));
                    countCart();
                },
                error: function (msg) {
                    app.error(msg);
                }
            });

        };

        $layout.on('click', '[data-del]', function () {
            var $li = $(this).parents('li');
            app.ajax({
                url: $layout.data('urlDel'),
                data: {
                    rowid: $(this).data('del')
                },
                type: 'post',
                success: function () {
                    $li.remove();
                    countCart();
                },
                error: function (msg) {
                    app.error(msg);
                }
            });
        });

        var countCart = function () {
            var price = 0;
            var num = 0;
            $layout.find('[data-price]').each(function () {
                price += parseFloat($(this).text());
            });
            $layout.find('[data-num]').each(function () {
                num += parseInt($(this).val());
            });
            $layout.find('[data-count-num]').text(num);
            $layout.find('[data-count-price]').text(price.toFixed(2));
            if (num == 0) {
                window.location.reload();
            }
        };
    };
    /**
     * 提交购物车
     * @param $el
     */
    owner.submit = function ($el) {
        var $layout = $($el);

        $layout.on('change', '[name=type]', function () {
            $layout.find('[data-count-type]').text($(this).data('name'));
        });

        $layout.on('change', '[name=delivery]', function () {
            var price = parseFloat($(this).data('price'));
            $layout.find('[data-count-delivery]').text(price);
            var orderPrice = parseFloat($layout.find('[data-count-price]').data('count-price'));
            $layout.find('[data-count-price]').text((orderPrice + price).toFixed(2));
        });
        $layout.on('click', '[data-submit]', function () {
            Do('dialog', function () {
                app.ajax({
                    url: $(this).data('url'),
                    type: 'post',
                    data: {
                        add_id: $('[name=add_id]').val(),
                        pay_type: $('[name=pay_type]').val(),
                        delivery: $('[name=delivery]:checked').val()
                    },
                    success: function (msg, url) {
                        layer.open({
                            content: msg,
                            btn: ['确定'],
                            yes: function () {
                                if (url) {
                                    window.location.href = url;
                                } else {
                                    window.location.reload();
                                }
                            }
                        });
                    },
                    error: function (msg) {
                        app.error(msg);
                    }
                });
            });

        });
        $layout.find('[name=delivery]:eq(0)').change();
    };
}(jQuery, window.cart = {}));


(function ($, owner) {
    /**
     * 商品属性选择
     */
    owner.sku = function ($el) {
        var $layout = $($el);
        $layout.on('click', 'a', function () {
            $(this).parent().find('a').removeClass('active');
            $(this).addClass('active');
            var sku = [];
            $layout.find('a.active').each(function () {
                var data = $(this).data();
                sku.push(data.id + ':' + data.value);
            });
            var key = sku.join(',');
            window.location = productJson[key]['url'];
        });
    };

    /**
     * 商品数量
     */
    owner.count = function ($el) {
        var $layout = $($el), $down = $layout.find('.down'), $up = $layout.find('.up'), $input = $layout.find('input'), maxCount = parseInt($layout.data('count')), callback = $layout.data('callback'), info = $layout.data('info');

        $down.click(function () {
            var curCount = parseInt($input.val());
            var num = curCount - 1;
            if (num <= 1) {
                num = 1;
            }
            upData(num);
        });
        $up.click(function () {
            var curCount = parseInt($input.val());
            var num = curCount + 1;
            if (maxCount && num >= maxCount) {
                num = maxCount;
            }
            upData(num);

        });
        $input.blur(function () {
            var num = parseInt($(this).val());
            if (num <= 1 || num >= maxCount) {
                $input.val(1);
            }
            if (callback != undefined && callback != '') {
                window[callback](num, info, $input);
            }
        });
        function upData(num) {
            if (callback != undefined && callback != '') {
                window[callback](num, info, $input);
            } else {
                $input.val(num);
            }
        }
    };
    /**
     * 加入购物车
     */
    owner.addCart = function ($el) {
        var $layout = $($el), url = $layout.data('url'), params = $layout.data('params'), $count = $($layout.data('count')), callback = $layout.data('callback');
        Do('dialog', function () {
            $layout.click(function () {
                app.ajax({
                    url: url,
                    data: $.extend({}, params, {qty: $count.val()}),
                    type: 'post',
                    success: function (msg, url) {
                        if (callback != undefined && callback != '') {
                            window[callback](msg);
                        }
                        app.success(msg);
                    },
                    error: function (msg) {
                        app.error(msg);
                    }
                });
            });
        });
    };
    /**
     * 收藏商品
     */
    owner.follow = function ($el) {
        var $layout = $($el), url = $layout.data('url'), params = $layout.data('params'), $icon = $layout.find('[data-icon]');
        Do('dialog', function () {
            $layout.click(function () {
                app.ajax({
                    url: url,
                    data: params,
                    type: 'post',
                    success: function (msg, url) {
                        changeIcon();
                        app.success(msg);
                    },
                    error: function (msg) {
                        app.error(msg);
                    }
                });
            });


            var changeIcon = function () {
                $icon.removeClass('am-icon-heart-o am-icon-heart');
                if($layout.data('status')) {
                    $icon.addClass('am-icon-heart-o');
                    $layout.data('status', 0);
                }else {
                    $icon.addClass('am-icon-heart');
                    $layout.data('status', 1);
                }
            }
        });

    };

}(jQuery, window.shop = {}));



(function ($, owner) {

    owner.ajaxPage = function ($el, config) {
        Do('more', 'tpl', function () {
            var defaultConfig = {
                page : 1,
                url: '',
                list : '',
                tpl : ''
            };
            config = $.extend(defaultConfig, config);
            var page = config.page;
            var pageStatus = 1;
            $($el).dropload({
                scrollArea : window,
                loadDownFn : function(me){
                    if(!pageStatus) {
                        me.noData(true);
                        me.resetload();
                        return false;
                    }
                    app.ajax({
                        type: 'GET',
                        url: config.url,
                        data : {
                            'page' : page
                        },
                        success: function(info){
                            var tpl = $(config.tpl).html();
                            laytpl(tpl).render(info.data, function(html){
                                page++;
                                $(config.list).append(html);
                            });
                            me.resetload();
                        },
                        error: function(xhr, type){
                            pageStatus = 0;
                            me.noData(true);
                            me.resetload();
                        }
                    });
                }
            });


        });

    }


    /**
     * 超链接访问
     */
    owner.ajaxLink = function ($el, config) {
        Do('base', function () {
            var defaultConfig = {
                callback: ''
            };
            config = $.extend(defaultConfig, config);
            $($el).click(function () {
                var data = $(this).data();
                var datas = data.data ? data.data : {};
                var field = data.field ? data.field : '';
                var fieldArray = new Array();
                if (data.field) {
                    fieldArray = field.split(',');
                    for (var i = 0; i < fieldArray.length; i++) {
                        datas[fieldArray[i]] = $('#' + fieldArray[i]).val();
                    }
                }
                app.ajax({
                    url: data.url,
                    type: 'post',
                    data: datas,
                    success: function (msg) {
                        app.success(msg);
                        //设置回调
                        if (typeof config.callback === 'function') {
                            config.callback(data.data);
                        }
                        if (typeof config.callback === 'string' && config.callback) {
                            window[config.callback].apply($el, data.data);
                        }
                    },
                    error: function (msg) {
                        app.error(msg);
                    }
                });
            });
        });
    };

    var countdown = 60;
    /**
     * 验证码倒计时
     */
    owner.getCode = function ($el) {
        owner.ajaxLink($el, {
            callback: function () {
                owner._codeTime($el);
            }
        });
    };
    owner._codeTime = function (val) {
        if (countdown == 0) {
            countdown = 60;
            $(val).text('获取验证码').attr('disabled', false);
        } else {
            countdown--;
            $(val).text(countdown + '秒后获取').attr('disabled', true);

            setTimeout(function () {
                owner._codeTime(val)
            }, 1000);
        }
    }

}(jQuery, window.page = {}));