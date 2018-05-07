/**
 * Created by along on 15/8/12.
 */

'use strict';

var amDialog = amDialog || {};

amDialog.alert = function (options) {
    options = options || {};
    options.title = options.title || '提示内容';
    options.onConfirm = options.onConfirm || function () {
        };
    var html = [];
    html.push('<div class="am-modal am-modal-alert" tabindex="-1">');
    html.push('<div class="am-modal-dialog">');
    html.push('<div class="am-modal-bd">' + options.title + '</div>');
    html.push('<div class="am-modal-footer"><span class="am-modal-btn">确定</span></div>');
    html.push('</div>');
    html.push('</div>');

    return $(html.join(''))
        .appendTo('body')
        .modal()
        .on('closed.modal.amui', function () {
            options.onConfirm();
            $(this).remove();
        });
};

amDialog.confirm = function (options) {
    options = options || {};
    options.title = options.title || '询问内容';
    options.btn = options.btn || ['确认', '取消'];
    options.callback = options.callback || [];

    var html = [];
    html.push('<div class="am-modal am-modal-confirm" tabindex="-1">');
    html.push('<div class="am-modal-dialog">');
    html.push('<div class="am-modal-bd">' + options.title + '</div>');
    html.push('<div class="am-modal-footer">');

    for (var item in options.btn) {
        html.push('<span class="am-modal-btn" data-dialog>'+options.btn[item]+'</span>');
    }

    html.push('</div>');
    html.push('</div>');
    html.push('</div>');

    var $cofirm = $(html.join('')).appendTo('body');
    $cofirm.on('click', '[data-dialog]', function () {
        var index = $cofirm.find('[data-dialog]').index(this);
        if (typeof options.callback[index] === 'function') {
            options.callback[index]();
        } else {
            $cofirm.modal('close');
        }
    });

    return $cofirm.modal({
        onConfirm: function (options) {
            options.onConfirm();
        },
        onCancel: function () {
            options.onCancel();
        }
    }).on('closed.modal.amui', function () {
        $(this).remove();
    });
};

amDialog.open = function (options) {
    options = options || {};
    options.title = options.title || '窗口';
    options.width = options.width || '600px';
    options.height = options.height || '400px';
    options.url = options.url || '#';
    var html = [];
    html.push('<div class="am-modal am-modal-alert" tabindex="-1">');
    html.push('<div class="am-modal-dialog">');
    html.push('<div class="am-modal-hd">' + options.title + '<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a></div>');
    html.push('<div class="am-modal-bd"><iframe frameborder="0" height="' + options.height + '" width="100%" src="' + options.url + '"></iframe></div>');
    html.push('</div>');
    html.push('</div>');

    var $iframe = $(html.join('')).appendTo('body');

    window['amDialogIframe'] = $iframe;

    return $iframe.modal({
        width: options.width
    })
        .on('closed.modal.amui', function () {
            $(this).remove();
        });
};


amDialog.msg = function (options) {
    options = options || {};
    options.title = options.title || '请稍等...';
    options.icon = options.icon || '';
    options.time = options.time || 3;

    var html = [];
    html.push('<div class="am-modal am-modal-loading am-modal-tip am-modal-no-btn" tabindex="-1" id="modal-msg">');
    html.push('<div class="am-modal-dialog"><div class="am-modal-bd">');
    if (options.icon) {
        html.push('<span class="am-icon-' + options.icon + '"></span> ');
    }
    html.push(options.title);
    html.push('</div></div>');
    html.push('</div>');

    var $msg = $(html.join('')).appendTo('body');

    return $msg.modal({
        dimmer: false
    }).on('opened.modal.amui', function () {
        setTimeout(function () {
            $msg.modal('close');
        }, options.time*1000);
    }).on('closed.modal.amui', function () {
            $(this).remove();
        });
};

amDialog.loading = function (options) {
    options = options || {};
    options.title = options.title || '正在载入...';

    var html = [];
    html.push('<div class="am-modal am-modal-loading am-modal-no-btn" tabindex="-1" id="modal-loading">');
    html.push('<div class="am-modal-dialog">');
    html.push('<div class="am-modal-hd">' + options.title + '</div>');
    html.push('<div class="am-modal-bd">');
    html.push('<span class="am-icon-spinner am-icon-spin"></span>');
    html.push('</div>');
    html.push('</div>');
    html.push('</div>');

    return $(html.join('')).appendTo('body').modal()
        .on('closed.modal.amui', function () {
            $(this).remove();
        });
};

amDialog.actions = function (options) {
    options = options || {};
    options.title = options.title || '您想整咋样?';
    options.items = options.items || [];
    options.onSelected = options.onSelected || function () {
            $acions.close();
        };
    var html = [];
    html.push('<div class="am-modal-actions">');
    html.push('<div class="am-modal-actions-group">');
    html.push('<ul class="am-list">');
    html.push('<li class="am-modal-actions-header">' + options.title + '</li>');
    options.items.forEach(function (item, index) {
        html.push('<li index="' + index + '">' + item.content + '</li>');
    });
    html.push('</ul>');
    html.push('</div>');
    html.push('<div class="am-modal-actions-group">');
    html.push('<button class="am-btn am-btn-secondary am-btn-block" data-am-modal-close>取消</button>');
    html.push('</div>');
    html.push('</div>');

    var $acions = $(html.join('')).appendTo('body');

    $acions.find('.am-list>li').bind('click', function (e) {
        options.onSelected($(this).attr('index'), this);
    });

    return {
        show: function () {
            $acions.modal('open');
        },
        close: function () {
            $acions.modal('close');
        }
    };
};

amDialog.popup = function (options) {
    options = options || {};
    options.title = options.title || '标题';
    options.content = options.content || '正文';
    options.onClose = options.onClose || function () {
        };

    var html = [];
    html.push('<div class="am-popup">');
    html.push('<div class="am-popup-inner">');
    html.push('<div class="am-popup-hd">');
    html.push('<h4 class="am-popup-title">' + options.title + '</h4>');
    html.push('<span data-am-modal-close  class="am-close">&times;</span>');
    html.push('</div>');
    html.push('<div class="am-popup-bd">' + options.content + '</div>');
    html.push('</div> ');
    html.push('</div>');
    return $(html.join('')).appendTo('body').modal()
        .on('closed.modal.amui', function () {
            $(this).remove();
            options.onClose();
        });
};

