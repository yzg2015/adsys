/**
 * 页面框架
 * var 1.0
 */
window.initStats = 0;
(function ($, owner) {
    /**
     * 初始化自动绑定
     */
    owner.init = function () {
        //处理绑定组件
        if (window['initStats']) {
            return false;
        }
        $("[data-dux]").each(function () {
            var data = $(this).data(), name = data['dux'], names = name.split('-', 2);
            if (window[names[0]][names[1]] && typeof(window[names[0]][names[1]]) == "function") {
                window[names[0]][names[1]](this, data);
            } else {
                app.debug(names[0] + '组件中不存在' + names[1] + '方法!');
            }

        });
        if (window['windowAfter'] != undefined && window['windowAfter'] != '') {
            window['windowAfter']();
        }
        window.initStats = 1;
        //引入必要部件
        Do(mobile ? 'dialog_mobile' : 'dialog');
    };

    /**
     * 自定义绑定
     */
    owner.bind = function ($el) {
        $($el).find("[data-dux]").each(function () {
            var data = $(this).data(), name = data['dux'], names = name.split('-', 2);
            window[names[0]][names[1]](this, data);
        });
    }
}(jQuery, window.dux = {}));


(function ($, owner) {

    var pre = window;
    if ($('body', window.parent.document).length > 0) {
        pre = parent;
    }
    /**
     * 加载提示
     * @param msg
     */
    owner.loading = function (msg, status) {
        var defaultConfig = {
            msg: '加载中',
            status: true
        };
        var config = $.extend(defaultConfig, {
            msg: msg,
            status: status
        });
        var html = '<div class="dux-loading"><div class="loading-icon"></div><div class="loading-msg">请求加载中...</div></div>';
        if (config.status) {
            if ($('.dux-loading').length) {
                return false;
            }
            $(html).appendTo('body');
        } else {
            setTimeout(function () {
                $('.dux-loading').remove();
            }, 100);
        }

    };
    /**
     * 消息提示
     * @param msg
     */
    owner.msg = function (msg) {
        Do(mobile ? 'dialog_mobile' : 'dialog', function () {
            if (mobile) {
                layer.open({
                    content: msg
                    , skin: 'msg'
                    , time: 3
                });
            } else {
                layer.ready(function () {
                    pre.layer.msg(msg);
                });
            }
        });
    };
    /**
     * AJAX确认
     * @param $el
     */
    owner.ajaxConfirm = function ($el) {
        $($el).click(function () {
            var data = $(this).data();
            owner.confirm({
                title: data.title,
                callback: [function () {
                    app.ajax({
                        url: data.url,
                        type: 'post',
                        data: data.params,
                        success: function (msg, url) {
                            var callback = data.callback;
                            if (callback != undefined && callback != '') {
                                window[callback](msg, url);
                            } else {
                                location.reload();
                            }
                        },
                        error: function (msg) {
                            app.error(msg);
                        }
                    });
                }]
            });
        });
    };

    /**
     * 询问窗口
     * @param config
     */
    owner.confirm = function (config) {
        Do(mobile ? 'dialog_mobile' : 'dialog', function () {
            var defaultConfig = {
                title: '询问',
                btn: ['确认', '取消'],
                callback: []
            };
            config = $.extend(defaultConfig, config);
            if (mobile) {
                layer.open({
                    content: config.title
                    , btn: config.btn
                    , yes: config.callback[0]
                    , no: config.callback[1]
                });
            } else {
                layer.ready(function () {
                    var data = [config.title, config.btn];
                    data = $.merge(data, config.callback);
                    pre.layer.confirm.apply(this, data);
                });

            }
        });

    };


    /**
     * 打开窗口
     * @param $el
     * @param config
     */
    owner.open = function ($el, config) {
        var defaultConfig = {
            width: '500px',
            height: '400px'
        };
        config = $.extend(defaultConfig, config);
        Do('dialog', function () {
            layer.ready(function () {
                $($el).on('click', function () {
                    pre.layer.open({
                        type: 2,
                        title: config.title,
                        shadeClose: true,
                        shade: 0.8,
                        area: [config.width, config.height],
                        content: config.url //iframe的url
                    });
                });
            });
        });
    };

    /**
     * 关闭窗口
     */
    owner.close = function (type) {
        Do(mobile ? 'dialog_mobile' : 'dialog', function () {
            if (mobile) {
                layer.closeAll();
            } else {
                layer.ready(function () {
                    pre.layer.closeAll(type);
                });
            }
        });
    };

    /**
     * 确认对话框
     * @param config
     */
    owner.alert = function (config) {
        Do(mobile ? 'dialog_mobile' : 'dialog', function () {
            if (mobile) {
                layer.open({
                    content: config.title
                    , btn: config.btn ? config.btn : '确认'
                    , yes: function () {
                        if (typeof config.callback == 'function') {
                            config.callback();
                        }
                    }
                });
            } else {
                layer.ready(function () {
                    pre.layer.alert(config.title, {}, function () {
                        if (typeof config.callback == 'function') {
                            config.callback();
                        }
                    });
                });

            }
        });
    };

}(jQuery, window.dialog = {}));


/**
 * 表单操作
 */
(function ($, owner) {
    /**
     * 绑定AJAX提交
     */
    owner.bind = function ($el, config) {
        var defaultConfig = {
            advanced: true
        };
        config = $.extend(defaultConfig, config);
        Do('form', function () {
            var options = {
                dataType: 'json',
                beforeSubmit: function () {
                    $($el).find("button[type=submit]").prepend('<i class="am-icon-circle-o-notch am-icon-spin"></i> ');
                    $($el).find("button").attr("disabled", true);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                },
                complete: function () {
                    $($el).find("button").attr("disabled", false);
                    $($el).find("button[type=submit]").find('i:first-child').remove();

                },
                success: function (json) {
                    var msg = json.message;
                    var url = json.url;

                    //成功回调
                    if (typeof config.callback === 'function') {
                        config.callback(msg, url);
                        return;
                    }
                    if (typeof config.callback === 'string') {
                        window[config.callback](msg, url);
                        return;
                    }
                    //执行弹窗
                    if (url) {
                        if (config.advanced) {
                            dialog.confirm({
                                title: msg,
                                btn: ['返回', '继续'],
                                callback: [function () {
                                    window.location.href = url;
                                }, function () {
                                    location.reload();
                                }]
                            });
                        } else {
                            dialog.alert({
                                title: msg,
                                callback: function () {
                                    window.location.href = url;
                                }
                            });
                        }
                    } else {

                        if (config.advanced) {
                            notify.success({
                                content: msg
                            });
                        } else {
                            dialog.alert({
                                title: msg,
                                callback: function () {
                                    location.reload();
                                }
                            });
                        }
                    }
                },
                error: function (e) {
                    var json = eval('(' + e.responseText + ')');
                    var msg = json.message;
                    if (config.advanced) {
                        notify.error({
                            content: msg
                        });
                    } else {
                        dialog.msg(msg);
                    }
                }
            };
            $($el).validator({
                H5validation: false,
                validateOnSubmit: true,
                onValid: function (validity) {
                    $(validity.field).closest('.am-form-group').find('.am-alert').hide();
                },
                markValid: function (validity) {
                    var options = this.options;
                    var $field = $(validity.field);
                    var $parent = $field.closest('.am-form-group');
                    $field.removeClass(options.inValidClass);
                    $parent.removeClass('am-form-error');
                    options.onValid.call(this, validity);
                },
                onInValid: function (validity) {
                    var $field = $(validity.field);
                    var msg = $field.data('validationMessage') || this.getValidationMessage(validity);
                    if (config.advanced) {
                        var $group = $field.parent();
                        if ($group.hasClass('am-input-group')) {
                            $group = $field.parent().parent();
                        }
                        var $alert = $group.find('.am-alert');
                        if (!$alert.length) {
                            $alert = $('<div class="am-alert am-alert-danger"></div>').hide().appendTo($group);
                        }
                        $alert.html(msg).show();
                    } else {
                        dialog.msg(msg);
                    }
                },
                submit: function () {
                    var formValidity = this.isFormValid();
                    if (formValidity) {
                        if (typeof CKEDITOR == 'object') {
                            for (var instanceName in CKEDITOR.instances) {
                                CKEDITOR.instances[instanceName].updateElement();
                            }
                        }
                        $($el).ajaxSubmit(options);
                    }
                    return false;
                }
            });
            $($el).find("button").attr("disabled", false);
        });
    };


    /**
     * 时间日期
     * @param $el
     * @param config
     */
    owner.date = function ($el, config) {
        var defaultConfig = {
            language: 'zh-CN',
            format: 'yyyy-mm-dd',
            autoclose: true
        };
        Do('date', function () {
            config = $.extend(defaultConfig, config);
            $($el).datetimepicker(config);

        });
    };

    /**
     * 地区选择
     * @param $el
     * @param config
     */
    owner.location = function ($el, config) {
        var defaultConfig = {};
        config = $.extend(defaultConfig, config);
        Do('distpicker', function () {
            $($el).distpicker(config);
        });
    };

    /**
     * 编辑器
     * @param $el
     * @param config
     */
    owner.editor = function ($el, config) {
        var toolbar = [
            {name: 'document', groups: ['mode', 'document', 'doctools']},
            {name: 'clipboard', groups: ['clipboard', 'undo']},
            {name: 'links'},
            {name: 'insert'},
            {name: 'forms'},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
            {name: 'tools'},
            {name: 'others'},
            '/',
            {name: 'styles'},
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
            {name: 'colors'}
        ];

        var defaultConfig = {
            textarea: $el,
            toolbar: toolbar,
            upload: true,
            editorUploadUrl: rootUrl + '/' + roleName + '/system/Upload/editor',
            multiUploadUrl: rootUrl + '/' + roleName + '/system/Upload/index'
        };
        config = $.extend(defaultConfig, config, $(this).data());

        var editorConfig = {
            height: 450,
            autoUpdateElement: true,
            allowedContent: true,
            toolbarGroups: toolbar,
            extraPlugins: 'multiupload,html5video,html5audio,baidumap',
            mathJaxLib: '//cdn.mathjax.org/mathjax/2.6-latest/MathJax.js?config=TeX-AMS_HTML',
            format_tags: 'p;h1;h2;h3;pre',
            removeDialogTabs: '',
            filebrowserUploadUrl: config.upload ? config.editorUploadUrl : '',
            multiUploadUrl: config.upload ? config.multiUploadUrl : ''
        };

        Do('editor', function () {
            var editor = CKEDITOR.replace(config.textarea, editorConfig);
            var name = $($el).attr("name") + 'Editor';
            window[name] = editor;
        });

    };

    /**
     * tag输入组件
     */
    owner.tags = function ($el, config) {
        var defaultConfig = {};
        config = $.extend(defaultConfig, config);
        Do('tags', function () {
            $($el).tagsinput(config);
        });
    };

    /**
     * 下拉选择
     */
    owner.select = function ($el, config) {
        var defaultConfig = {
            language: "zh-CN"
        };
        config = $.extend(defaultConfig, config);
        Do('select2', function () {
            if (config.user) {
                var ajaxConfig = {
                    ajax: {
                        url: config.url,
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term,
                                page: params.page
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;

                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        cache: false
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    minimumInputLength: 2,
                    templateResult: formatRepo,
                    templateSelection: formatRepoSelection
                };

                function formatRepo(repo) {
                    if (repo.loading) return repo.text;

                    var markup = "<div class='select2-result-repository am-clearfix'>" +
                        "<div class='select2-result-repository__avatar'><img src='" + repo.image + "' /></div>" +
                        "<div class='select2-result-repository__meta'>" +
                        "<div class='select2-result-repository__title'>" + repo.text + "</div>";
                    markup += "<div class='select2-result-repository__description'>" + repo.desc ? repo.desc : '' + "</div>";
                    markup += "</div></div>";
                    return markup;
                }

                function formatRepoSelection(repo) {
                    return repo.text;
                }

                config = $.extend(config, ajaxConfig);
            }
            $($el).select2(config);
        });
    };

    /**
     * 颜色选择器
     */
    owner.color = function ($el, config) {
        var defaultConfig = {};
        config = $.extend(defaultConfig, config);
        Do('chosen', function () {
            var preview = $($el).find('[data-color-preview]');
            var list = $($el).parent().find('[data-color-list]');
            list.on('click', 'a', function () {
                var data = $(this).data();
                preview.css('background-color', data.color);
                if (typeof config.callback === 'function') {
                    config.callback.call($el, data);
                }
                if (typeof config.callback === 'string' && config.callback) {
                    window[config.callback].call($el, data);
                }
            });
        });
    };

    /**
     * 地图组件
     * @param $el
     * @param config
     */
    owner.map = function ($el, config) {
        var defaultConfig = {};
        config = $.extend(defaultConfig, config);
        var id = $($el).data('id');
        $($el).on('click', function () {
            layer.open({
                title: '地图选择',
                type: 2,
                id: 'dialog-' + id,
                area: ['500px', '400px'],
                fix: false,
                btn: ['确定', '取消'],
                content: rootUrl + '/' + roleName + '/site/FormField/map?id=' + id,
                yes: function (index, layero) {
                    var iframe = $(layero).find("iframe");
                    iframe[0].contentWindow.getMap(id);
                    dialog.close();
                }
            });
        });

    };

    /**
     * 上传
     * @param $el
     * @param config
     */
    owner.upload = function ($el, config) {
        var defaultConfig = {
            url: rootUrl + '/' + roleName + '/system/Upload/index',
            type: '*',
            size: 0,
            num: 0,
            multi: true,
            resize: {},
            target: '',
            callback: '',
            relative: 'false'
        };
        config = $.extend(defaultConfig, config);
        Do('upload', function () {
            var uploader = new plupload.Uploader({
                runtimes: 'html5,html4',
                browse_button: $($el).get(0),
                url: config.url,
                filters: {
                    mime_types: [
                        {title: "指定文件", extensions: config.type}
                    ]
                },
                max_file_size: config.size,
                multipart: config.multi,
                resize: config.resize,
                init: {
                    PostInit: function () {
                        //初始化

                    },
                    FilesAdded: function (up, files) {
                        if (config.num > 0) {
                            if (up.files.length > config.num) {
                                dialog.msg('超过上传数量限制!');
                                uploader.removeFile(files);
                                return;
                            }
                        }
                        //添加文件
                        $($el).attr('disabled', true).append(' <span class="prs">[<strong>0%</strong>]</span>');
                        uploader.start();
                    },
                    UploadProgress: function (up, file) {
                        //上传进度
                        $($el).find('span').text(file.percent + '%');
                    },
                    FileUploaded: function (up, file, response) {
                        //文件上传完毕
                        var data = JSON.parse(response.response);
                        if (!data.status) {
                            dialog.msg(data.info);
                            return;
                        }
                        //赋值地址
                        if (config.target) {
                            $(config.target).val(data.data.url);
                        }
                        //设置回调
                        if (typeof config.callback === 'function') {
                            config.callback.call($el, data.data);
                        }
                        if (typeof config.callback === 'string' && config.callback) {
                            window[config.callback].call($el, data.data);
                        }
                    },
                    Error: function (up, err) {
                        //错误信息
                        $($el).attr('disabled', false).find('span').remove();
                        dialog.msg(err.message);
                    },
                    UploadComplete: function (up, num) {
                        //队列上传完毕
                        $($el).attr('disabled', false).find('span').remove();
                    }
                }
            });
            uploader.init();
        });
    };
    /**
     * 组图
     * @param $el
     * @param config
     */
    owner.images = function ($el, config) {
        var defaultConfig = {
            imgWarp: '',
            imgName: '',
            imgList: {},
            imgField: '',
            tplEl: ''
        };
        config = $.extend(defaultConfig, config);
        Do('sortable', 'tpl', function () {

            var imgFields = [];

            if (config.imgField) {
                imgFields = config.imgField.split(",");
            }
            var tpl = '<li>' +
                '<img src="{{ d.data.url }}">' +
                '<div class="info">' +
                '<span class="title">{{ d.data.title }}</span>' +
                '<a class="del">删除</a>' +
                '</div>' +
                '<input type="hidden" name="{{ d.name }}[url][]" value="{{ d.data.url }}">' +
                '<input type="hidden" name="{{ d.name }}[title][]" value="{{ d.data.title }}">';
            if (imgFields.length > 0) {
                $.each(imgFields, function (k, v) {
                    tpl += '<input type="hidden" name="{{ d.name }}[' + v + '][]" value="{{ d.data.' + v + ' }}">';
                });
            }

            if (config.tplEl) {
                tpl = $(config.tplEl).html();
            }

            tpl += '</li>';
            $(config.imgWarp).on('click', '.del', function () {
                $(this).parents('li').remove();
            });
            owner.upload($el, $.extend(config, {
                callback: function (data) {
                    laytpl(tpl).render({name: config.imgName, data: data}, function (html) {
                        $(config.imgWarp).append(html);
                    });
                    $(config.imgWarp).sortable();
                }
            }));
            if (config.imgList) {
                $.each(config.imgList, function (index, item) {
                    laytpl(tpl).render({name: config.imgName, data: item}, function (html) {
                        $(config.imgWarp).append(html);
                    });
                });
                $(config.imgWarp).sortable();
            }

        });
    };

    /**
     * 图片预览
     * @param $el
     * @param config
     */
    owner.imgShow = function ($el, config) {
        var defaultConfig = {
            target: ''
        };
        config = $.extend(defaultConfig, config);
        $($el).on('click', function () {
            Do('dialog', function () {
                var image = $(config.target).val();
                if (!image) {
                    dialog.msg('请先上传图片!');
                    return;
                }
                window.open(image);
            });
        });
    };

    /**
     * 多文件
     * @param $el
     * @param config
     */
    owner.files = function ($el, config) {
        var defaultConfig = {
            fileWarp: '',
            fileName: '',
            fileList: {}
        };
        config = $.extend(defaultConfig, config);
        Do('sortable', 'tpl', function () {
            var tpl = '<li>' +
                '<span class="title"><input type="text" name="{{ d.name }}[title][]" value="{{ d.data.title }}">.{{ d.data.ext }} ({{ (d.data.size/1024).toFixed(2) }}kb)</span> ' +
                '<a class="del">删除</a>' +
                '<input type="hidden" name="{{ d.name }}[url][]" value="{{ d.data.url }}">' +
                '<input type="hidden" name="{{ d.name }}[ext][]" value="{{ d.data.ext }}">' +
                '<input type="hidden" name="{{ d.name }}[size][]" value="{{ d.data.size }}">' +
                '</li>';
            $(config.fileWarp).on('click', '.del', function () {
                $(this).parents('li').remove();
            });
            owner.upload($el, $.extend(config, {
                callback: function (data) {
                    laytpl(tpl).render({name: config.fileName, data: data}, function (html) {
                        $(config.fileWarp).append(html);
                    });
                    $(config.fileWarp).sortable();
                }
            }));
            if (config.fileList) {
                $.each(config.fileList, function (index, item) {
                    laytpl(tpl).render({name: config.fileName, data: item}, function (html) {
                        $(config.fileWarp).append(html);
                    });
                });
                $(config.fileWarp).sortable();
            }

        });
    };


}(jQuery, window.form = {}));


(function ($, owner) {

    /**
     * TAB组件
     * @param $el
     * @param config
     */
    owner.tab = function ($el, config) {
        var defaultConfig = {
            active: "active"
        };
        config = $.extend(defaultConfig, config);
        var els = [];
        $($el).find('a').each(function () {
            els.push($(this).data('el'));
        });
        var switchTab = function (obj) {
            $(els.join(',')).hide();
            $($(obj).data('el')).show();
        };
        $($el).on('click', 'a', function () {
            $($el).find('li').removeClass(config.active);
            $(this).parents('li').addClass(config.active);
            switchTab(this);
        });
        switchTab($($el).find('.' + config.active).find('a'));
    };

    /**
     * 分享组件
     * @param $el
     * @param config
     */
    owner.share = function ($el, config) {
        var defaultConfig = {
            disabled: ['google', 'facebook', 'twitter', 'diandian', 'tencent']
        };
        config = $.extend(defaultConfig, config);
        Do('share', function () {
            $($el).share(config);
        });
    };

    /**
     * 步骤
     * @param $el
     * @param config
     */
    owner.step = function ($el, config) {
        var defaultConfig = {};
        config = $.extend(defaultConfig, config);
        $($el).find('.active').prevAll().addClass("active");
    };

    /**
     * 地图
     */
    owner.tmap = function ($el, config) {
        var defaultConfig = {
            lat: null,
            lng: null,
            address: null,
            callback: ''
        };
        config = $.extend(defaultConfig, config);
        window['tmapInit'] = function () {
            var position = new qq.maps.LatLng(config.lat ? config.lat : 39.916527, config.lng ? config.lng : 116.397128);
            var myOptions = {
                center: position,
                zoom: 14,

                mapTypeId: qq.maps.MapTypeId.ROADMAP
            };
            var id = $($el).attr('id');
            var map = new qq.maps.Map($($el)[0], myOptions);

            if (config.address) {
                var callbacks = {
                    complete: function (result) {
                        position = result.detail.location;
                        map.setCenter(position);
                        new qq.maps.Marker({
                            map: map,
                            position: position
                        });
                    },
                };
                geocoder = new qq.maps.Geocoder(callbacks);
                geocoder.getLocation(config.address);
            } else {
                if (config.lat && config.lng) {
                    new qq.maps.Marker({
                        map: map,
                        position: position
                    });
                }
            }

            if (config.callback != undefined && config.callback != '') {
                window[config.callback](map, position, $el);
            }
        };
        Do('tmap');
    };

    owner.qrcode = function ($el, config) {
        var defaultConfig = {};
        config = $.extend(defaultConfig, config);
        Do('qrcode', function () {
            var QRCode = $.AMUI.qrcode;
            $($el).html(new QRCode(config));
        });
    };

    owner.listAction = function ($el, config) {
        var defaultConfig = {
            width: 70
        };
        config = $.extend(defaultConfig, config);

        $($el).unbind('click').unbind('touchstart').unbind('touchmove').unbind('touchend').on({
            'touchmove': function (event) {
                if (event.originalEvent.targetTouches.length == 1) {
                    var touch = event.originalEvent.targetTouches[0], leftX;
                    leftX = touch.pageX - this.startX;
                    this.isMove = true;
                    this.leftX = leftX;
                    this.style.webkitTransition = "-webkit-transform 0s ease";
                    if (leftX < 0) {
                        this.re = 'l';
                        if (leftX < -config.width) {
                            leftX = -config.width;
                        }
                        if (this.stats == 'r') {
                            this.style.webkitTransform = 'translateX(' + leftX + 'px)';
                        }
                    } else {
                        this.re = 'r';
                        if (leftX > config.width) {
                            leftX = config.width;
                        }
                        if (this.stats == 'l') {
                            this.style.webkitTransform = 'translateX(' + (leftX - config.width) + 'px)';
                        }
                    }
                    if (Math.abs(leftX) > 10) {
                        return false;
                    } else {
                        this.style.webkitTransform = 'translateX(0px)';
                    }
                }
            }, 'touchstart': function (event) {
                if (event.originalEvent.targetTouches.length == 1) {
                    if (!this.stats) {
                        this.stats = 'r';
                    }
                    this.startTime = new Date().getTime();
                    var touch = event.originalEvent.targetTouches[0];
                    this.startX = touch.pageX;
                    this.isMove = false;
                }
            }, 'touchend': function (event) {
                this.style.webkitTransition = "-webkit-transform 0.5s ease";
                if (this.re == 'r') {
                    this.style.webkitTransform = 'translateX(0px)';
                    this.stats = 'r';
                } else {
                    if (this.leftX > -config.width / 2) {
                        this.style.webkitTransform = 'translateX(0px)';
                        this.stats = 'r';
                    } else {
                        this.style.webkitTransform = 'translateX(-' + config.width + 'px)';
                        this.stats = 'l';
                    }
                }
            }
        }, '[data-item]');

    }
}(jQuery, window.show = {}));

/**
 * 通知组件
 */
(function ($, owner) {
    owner.success = function (config) {
        var defaultConfig = {
            content: "处理成功",
            time: 6,
            icon: 'am-icon-check'
        };
        config = $.extend(defaultConfig, config, {status: 'success'});
        owner.show(config);
    };
    owner.warning = function (config) {
        var defaultConfig = {
            content: "处理中断",
            time: 6,
            icon: 'am-icon-info'
        };
        config = $.extend(defaultConfig, config, {status: 'warning'});
        owner.show(config);
    };
    owner.error = function (config) {
        var defaultConfig = {
            content: "处理失败",
            time: 6,
            icon: 'am-icon-close'

        };
        config = $.extend(defaultConfig, config, {status: 'error'});
        owner.show(config);
    };
    owner.show = function (config) {
        Do('notify', function () {
            var status = {
                success: ['ok', '#27ae60'],
                warning: ['warning', '#e0690c'],
                error: ['error', '#dd514c']
            };
            console.log(status[config.status][1]);
            $.amaran({
                position: 'top center',
                delay: config.time * 1000,
                content: {
                    themeName: 'dux ' + status[config.status][0],
                    message: config.content,
                    color: status[config.status][1],
                    icon: config.icon
                },
                themeTemplate: function (data) {
                    return '<div class="icon" style="background: ' + data.color + '"><i class="' + data.icon + '"></i></div><div class="info">' + data.message + '</div>';
                }
            });
        });
    };
}(jQuery, window.notify = {}));


(function ($, owner) {
    /**
     * ajax列表
     * @param $el
     * @param config
     */
    owner.ajax = function ($el, config) {
        Do('more', 'tpl', function () {
            var defaultConfig = {
                page: 1,
                url: '',
                list: '',
                tpl: ''
            };
            config = $.extend(defaultConfig, config);
            var page = config.page;
            var pageStatus = 1;
            $($el).dropload({
                scrollArea: window,
                loadDownFn: function (me) {
                    if (!pageStatus) {
                        me.noData(true);
                        me.resetload();
                        return false;
                    }
                    app.ajax({
                        type: 'GET',
                        url: config.url,
                        data: {
                            'page': page
                        },
                        success: function (info) {
                            var tpl = $(config.tpl).html();
                            laytpl(tpl).render(info.data, function (html) {
                                page++;
                                $(config.list).append(html);
                            });
                            me.resetload();
                        },
                        error: function (xhr, type) {
                            pageStatus = 0;
                            me.noData(true);
                            me.resetload();
                        }
                    });
                }
            });
        });
    }
}(jQuery, window.list = {}));

/**
 * 常用方法
 */
(function ($, owner) {
    /**
     * 调试方法
     * @param msg
     */
    owner.debug = function (msg) {
        if (typeof(console) != 'undefined') {
            console.log(msg);
        }
    };
    /**
     * AJAX请求
     * @param config
     */
    owner.ajax = function (config) {
        var defaultConfig = {};
        config = $.extend(defaultConfig, config);
        if (config.loading) {
            dialog.loading();
        }
        $.ajax({
            url: config.url,
            type: config.type,
            data: config.data,
            dataType: 'json',
            success: function (json) {
                if (config.loading) {
                    dialog.loading('', false);
                }
                if (typeof config.success == 'function') {
                    config.success(json.message, json.url);
                }
            },
            error: function (e) {
                if (config.loading) {
                    dialog.loading('', false);
                }
                try {
                    var json = eval('(' + e.responseText + ')');
                    var msg = json.message;
                } catch (e) {
                    var msg = null;
                }
                if (msg == '' || msg == null) {
                    msg = '数据请求失败，请刷新后再试！';
                }

                if (e.status == 404) {
                    app.error('请求操作不存在!');
                    return;
                }
                if (e.status == 401) {
                    if (typeof config.login == 'function') {
                        config.login(msg);
                        return;
                    } else {
                        app.error(msg, json.url);
                        return;
                    }
                }
                if (typeof config.error == 'function') {
                    config.error(msg);
                    return;
                }
                app.error(msg);
            }
        });
    };
    /**
     * 成功提示
     * @param msg
     * @param url
     */
    owner.success = function (msg, url) {
        if (url) {
            window.location.href = url;
        } else {
            dialog.msg(msg);
        }
    };
    /**
     * 失败提示
     * @param msg
     * @param url
     */
    owner.error = function (msg, url) {
        if (url) {
            dialog.confirm({
                title: msg,
                callback: [function () {
                    window.location.href = url;
                }]
            });
        } else {
            dialog.msg(msg);
            return false;
        }
    };

    /**
     * 移动端检测
     * @returns {boolean}
     */
    owner.mobile = function () {
        var check = false;
        if (navigator.userAgent.match(/(mobile|iPhone|iPod|Android|ios)/i)) {
            check = true;
        } else if (screen.width <= 1024) {
            check = true;
        }
        return check;
    };

    /**
     * 复制内容
     * @param $el
     */
    owner.copy = function ($el) {
        Do('copy', 'dialog', function () {
            var client = new ZeroClipboard($el);
            client.on("aftercopy", function (event) {
                dialog.msg('复制成功，请直接粘贴使用！');
            });

        });
    };

    /**
     * 唯一ID生成
     * @returns {string}
     */
    owner.guid = function () {
        function S4() {
            return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
        }

        return (S4() + S4() + "-" + S4() + "-" + S4() + "-" + S4() + "-" + S4() + S4() + S4());
    };

    owner.datetime = function (unix) {
        var now = new Date(parseInt(unix) * 1000);
        return now.toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
    }
}(jQuery, window.app = {}));