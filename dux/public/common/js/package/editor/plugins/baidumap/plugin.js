(function () {
    CKEDITOR.plugins.add("baidumap", {
        requires: ["dialog"],
        allowedContent: 'iframe[src,frameborder,height,width];',
        init: function (editor) {
            var path = this.path;
            editor.addCommand("baidumap", new CKEDITOR.dialogCommand("baidumap"));
            editor.ui.addButton("baidumap", {
                label: "百度地图",
                command: "baidumap",
                icon: this.path + "images/location.png"
            });
            CKEDITOR.dialog.add("baidumap", function (s) {
                return {
                    title: "百度地图",
                    minWidth: "400px",
                    minHeight: "200px",
                    contents: [{
                        id: 'tab1',
                        label: "",
                        title: "",
                        expand: true,
                        width: "400px",
                        padding: 0,
                        elements: [{
                            type: 'hbox',
                            align: 'right',
                            className: 'cke_dialog_map_keyword',
                            children: [{
                                id: 'city',
                                type: 'text',
                                label: '城市',
                                'default' : '北京'
                                },{
                                    id: 'keyword',
                                    type: 'text',
                                    label: '地址'
                                },{
                                    id: 'dynamic',
                                    type: 'checkbox',
                                    label: '动态地图',
                                    style: 'display:inline-block;padding-top:25px;margin:2px;'
                                },{
                                    type: 'button',
                                    id: 'search',
                                    style: 'display:inline-block;margin-top:20px;',
                                    align: 'center',
                                    label: '搜索',
                                    onClick: function () {
                                        var dialog = this.getDialog();
                                        var keywordObj = dialog.getContentElement('tab1', 'keyword');
                                        var cityObj = dialog.getContentElement('tab1', 'city');
                                        var mapObj = dialog.getContentElement('tab1', 'mapPreview');
                                        $(window.parent.document).contents().find("#" + mapObj.domId)[0].contentWindow.search(cityObj.getValue(), keywordObj.getValue());
                                    }
                                }]
                        }, {
                            type: 'vbox',
                            height: '250px',
                            children: [{
                                type: 'html',
                                id: 'mapPreview',
                                style: 'width:430px;height:250px',
                                html: '<iframe src="' + path + 'baidu.html"></iframe>'
                            }]
                        }]
                    }],
                    onOk: function () {
                        var dialog = this;
                        var mapObj = dialog.getContentElement('tab1', 'mapPreview');
                        var checkbox = dialog.getContentElement('tab1', 'dynamic');
                        var html = $(window.parent.document).contents().find("#" + mapObj.domId)[0].contentWindow.getInfo(path, $("#" + checkbox.domId).find('input').prop('checked'));
                        s.insertHtml( html );
                    },
                    onCancel: function () {
                    },
                    onShow: function () {
                    }
                };

            });

        }

    });

})();