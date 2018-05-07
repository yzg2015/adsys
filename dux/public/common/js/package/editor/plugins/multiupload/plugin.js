(function () {
    CKEDITOR.plugins.add("multiupload", {
        requires: ["dialog"],
        init: function (editor) {
            var config = editor.config;

            var path = this.path;
            CKEDITOR.scriptLoader.load([path + '/plupload/plupload.full.min.js'], function () {
                CKEDITOR.scriptLoader.load(path + '/plupload/i18n/zh_CN.js');
                CKEDITOR.document.appendStyleSheet(path + "multiupload.css");
            });

            editor.addCommand("multiupload", new CKEDITOR.dialogCommand("multiupload"));
            editor.ui.addButton("multiupload", {
                label: "批量上传",
                command: "multiupload",
                icon: this.path + "images/upload.png"
            });

            window['upload'] = [];

            CKEDITOR.dialog.add("multiupload", function (s) {
                var id = s.id + '_upload',uploader;
                var htmlUpload = [];
                var restUpload = function () {
                    $('#' + id).find('.tip').html('上传附件/图片');
                    htmlUpload = [];
                };
                return {
                    title: "批量上传",
                    minWidth: "300px",
                    minHeight: "200px",
                    contents: [{
                        id: 'tab1',
                        label: "",
                        title: "",
                        expand: true,
                        width: "300px",
                        height: "200px",
                        padding: 0,
                        elements: [{
                            type: "html",
                            style: "width:300px;height:200px",
                            html: '<div>' +
                            '<div id="' + id + '"><div  class="cke_multiupload" id="' + id + '"><span class="tip">上传附件/图片</span></div></div>' +
                            '</div>'
                        }]
                    }],
                    buttons: [CKEDITOR.dialog.cancelButton],
                    onOk: function () {
                        restUpload();
                    },
                    onCancel: function () {
                        restUpload();
                    },
                    onShow: function () {
                        if (window['upload'][id]) {
                            return true;
                        }

                        var uploader = new plupload.Uploader({
                            runtimes: 'html5,html4',
                            browse_button: $('#' + id).get(0),
                            url: config.multiUploadUrl,
                            init: {
                                FilesAdded: function (up, files) {
                                    //添加文件
                                    $('#' + id).find('.tip').html('<strong>0%</strong>');
                                    uploader.start();
                                },
                                UploadProgress: function (up, file) {
                                    //上传进度
                                    $('#' + id).find('.tip').find('strong').text(file.percent + '%');
                                },
                                FileUploaded: function (up, file, response) {
                                    //文件上传完毕
                                    var data = JSON.parse(response.response);
                                    if (!data.status) {
                                        restUpload();
                                        alert(data.info);
                                        return false;
                                    }
                                    var info = data.data, ext = info.ext.toLowerCase(), html = '';

                                    switch (ext) {
                                        case 'jpg':
                                        case 'jpeg':
                                        case 'gif':
                                        case 'png':
                                        case 'bmp':
                                            html = '<img src="' + info.url + '" alt="' + info.title + '" />';
                                            break;
                                        case 'mp4':
                                        case 'ogv':
                                        case 'webm':
                                            html = '<video src="' + info.url + '" controls="controls">您的浏览器暂不支持html5视频</video>';
                                            break;
                                        case 'mp3':
                                        case 'ogg':
                                        case 'wav':
                                            html = '<audio src="' + info.url + '" controls="controls">您的浏览器暂不支持html5音频</audio>';
                                            break;
                                        default:
                                            html = '<blockquote>附件：<a href="' + info.url + '" target="_blank" title="info.title">'+info.title+'</a></blockquote>';
                                            break;
                                    }

                                    htmlUpload.push(html);

                                },
                                Error: function (up, err) {
                                    restUpload();
                                    alert(err);
                                },
                                UploadComplete: function (up, num) {

                                    s.insertHtml( htmlUpload.join('<br>') );



                                    restUpload();
                                    CKEDITOR.dialog.getCurrent().hide();
                                }
                            }
                        });
                        uploader.init();
                        window['upload'][id] = true;
                    }
                };

            });

        }

    });

})();