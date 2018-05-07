/**
 * 初始化类库
 */
(function (win, doc) {
    /**
     * 设置包路径
     */
    var jsSelf = (function () {
        var files = doc.getElementsByTagName('script');
        return files[files.length - 1];
    })();
    window.packagePath = jsSelf.getAttribute('data-path');
    window.rootUrl = jsSelf.getAttribute('data-root');
    window.roleName = jsSelf.getAttribute('data-role');
    window.tplPath = jsSelf.getAttribute('data-tpl');
    window.commonPath = packagePath + '/common/js/';


    window.mobile = false;

    /**
     * 公共类
     */
    Do.add('common', {
        path: commonPath + '/common.js?v=1.1',
        type : 'js'
    });

    /**
     * 通知
     */
    Do.add('notifyCss', {
        path: commonPath + 'package/notify/amaran.min.css',
        type: 'css'
    });
    Do.add('notify', {
        path: commonPath + 'package/notify/jquery.amaran.min.js',
        requires: ['notifyCss']
    });

    /**
     * 图表
     */
/*    Do.add('chartCss', {
        path: commonPath + 'package/chart/chartist.min.css',
        type: 'css'
    });
    Do.add('chart', {
        path: commonPath + 'package/chart/chartist.min.js',
        type: 'js',
        requires: ['chartCss']
    });*/

    Do.add('chart', {
        path: commonPath + 'package/chart/Chart.min.js',
        type: 'js'
    });

    /**
     * 表单
     */
    Do.add('form', {
        path: commonPath + 'package/form/jquery.form.js',
        type: 'js'
    });

    /**
     * 上传
     */
    Do.add('uploadSrc', {
        path: commonPath + 'package/upload/plupload.full.min.js'
    });
    Do.add('upload', {
        path: commonPath + 'package/upload/zh_CN.js',
        requires: ['uploadSrc']
    });

    /**
     * 模板引擎
     */
    Do.add('tpl', {
        path: commonPath + 'package/tpl/laytpl.js',
        type: 'js'
    });

    /**
     * 拖动排序
     */
    Do.add('sortable', {
        path: commonPath + 'package/sortable/jquery.sortable.min.js',
        type: 'js'
    });

    /**
     * 取色器
     */
    Do.add('colorCss', {
        path: commonPath + 'package/color/iColor-min.css',
        type: 'css'
    });
    Do.add('color', {
        path: commonPath + 'package/color/iColor-min.js',
        requires: ['colorCss']
    });

    /**
     * 弹窗插件
     */
    Do.add('dialog', {
        path: commonPath + 'package/dialog/layer.js'
    });

    Do.add('dialog_mobile', {
        path: commonPath + 'package/dialog_mobile/layer.js'
    });

    Do.add('dialog_amazeui', {
        path: commonPath + 'package/dialog_amazeui/amazeui.dialog.js'
    });

    /**
     * 编辑器
     */
    Do.add('editorMdCss', {
        path: commonPath + 'package/editor_md/simplemde.min.css',
        type: 'css'
    });
    Do.add('editor_md', {
        path: commonPath + 'package/editor_md/simplemde.min.js',
        requires: ['editorMdCss']
    });
    Do.add('editor', {
        path: commonPath + 'package/editor/ckeditor.js'
    });

    /**
     * 日期选择
     */
    Do.add('dateCss', {
        path: commonPath + 'package/date/css/amazeui.datetimepicker.css',
        type: 'css'
    });
    Do.add('date', {
        path: commonPath + 'package/date/js/amazeui.datetimepicker.min.js',
        requires: ['dateCss']
    });

    /**
     * 地区选择
     */
    Do.add('distpicker', {
        path: commonPath + 'package/distpicker/distpicker.min.js'
    });

    /**
     * 拖动列表
     */
    Do.add('nestable', {
        path: commonPath + 'package/nestable/jquery.nestable.js'
    });

    /**
     * TAG输入
     */
    Do.add('tagsCss', {
        path: commonPath + 'package/tags/amazeui.tagsinput.css',
        type: 'css'
    });
    Do.add('tags', {
        path: commonPath + 'package/tags/amazeui.tagsinput.min.js',
        requires: ['tagsCss']
    });

    /**
     * 下拉增强
     */
    Do.add('select2Css', {
        path: commonPath + 'package/select2/select2.css',
        type: 'css'
    });
    Do.add('select2Src', {
        path: commonPath + 'package/select2/select2.full.min.js'
    });
    Do.add('select2', {
        path: commonPath + 'package/select2/i18n/zh-CN.js',
        requires: ['select2Css', 'select2Src']
    });

    /**
     * 切换
     */
    Do.add('tab', {
        path: commonPath + 'package/tab/jquery.idTabs.min.js'
    });

    /**
     * 打印
     */
    Do.add('print', {
        path: commonPath + 'package/print/jquery.print.js'
    });

    /**
     * 复制
     */
    Do.add('copy', {
        path : commonPath + 'package/copy/ZeroClipboard.min.js'
    });


    /**
     * 下拉加载
     */
    Do.add('moreCss', {
        path: commonPath + 'package/more/dropload.css',
        type: 'css'
    });
    Do.add('more', {
        path: commonPath + 'package/more/dropload.min.js',
        requires: ['moreCss']
    });

    /**
     * 图表
     */
    Do.add('shareCss', {
        path: commonPath + 'package/share/css/share.min.css',
        type: 'css'
    });
    Do.add('share', {
        path: commonPath + 'package/share/js/share.min.js',
        type: 'js',
        requires: ['shareCss']
    });

    /**
     * 腾讯地图
     */
    Do.add('tmap', {
        path: 'http://map.qq.com/api/js?v=2.exp&callback=tmapInit',
        type: 'js'
    });

    /**
     * 二维码
     */
    Do.add('qrcode', {
        path: commonPath + 'package/qrcode/qrcode.js',
        type: 'js'
    });

    /**
     * 旋转
     */
    Do.add('rotate', {
        path: commonPath + 'package/rotate/awardRotate.js',
        type: 'js'
    });

    /**
     * cookie
     */
    Do.add('cookie', {
        path: commonPath + 'package/cookie/js.cookie.js',
        type: 'js'
    });

    /**
     * fix
     */
    Do.add('inobounce', {
        path: commonPath + 'package/fix/inobounce.js',
        type : 'js'
    });

})(window, document);