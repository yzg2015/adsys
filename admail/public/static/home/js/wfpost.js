var wfload = {
    getheight: function () {
        if ($(window).width() < 751) {
            $(".wffhcont").css("height", 260)
        } else {
            $(".wffhcont").css("height", $(".wfform").height() - 172)
        }
        var wfheight = $(".wforder").height() + 15;
        document.cookie = "wfheight=" + wfheight + ";path=/"
    }, getprovince: function () {
        $.getScript('http://180.149.136.219/iplookup/iplookup.php?format=js', function (data) {
            var data = remote_ip_info;
            var myprovince = data['province'] ? data['province'] : '';
            var mycity = data['city'] ? data['city'] : '';
            $("#wfuprovince").val(myprovince);
            $("#wfucity").val(mycity)
        })
    }
};


function total(o) {
    switch (o) {
    case 'select':
        var d = $("#wfproduct option:selected").attr('title');
        break;
    case 'checkbox':
        var d = 0;
        $("input:checkbox:checked").each(function () {
            d += parseFloat(this.title)
        });
        break;
    default:
        var d = $("input[name='wfproduct']:checked").attr('title');
        break
    }
    var n = $("#wfnums").val();
    var z = $("#wfpayzk").val();
    var p = parseFloat(d) * n * z;
    $("#wfnums").val(n);
    $("#wfproup").val(d);
    $("#wfpayzk").val(z);
    $("#wfprice").val(p.toFixed(2));
    $("#showprice").html(p.toFixed(2))
}

function numlnc() {
    var n = $("#wfnums").val();
    var d = $("#wfproup").val();
    var z = $("#wfpayzk").val();
    var p = $("#wfprice").val();
    var n = parseInt(n) + 1;
    var p = n * parseFloat(d) * z;
    $("#wfnums").val(n);
    $("#wfproup").val(d);
    $("#wfpayzk").val(z);
    $("#wfprice").val(p.toFixed(2));
    $("#showprice").html(p.toFixed(2))
}

function numdec() {
    var n = $("#wfnums").val();
    var d = $("#wfproup").val();
    var z = $("#wfpayzk").val();
    var p = $("#wfprice").val();
    var n = parseInt(n) - 1;
    var p = n * parseFloat(d) * z;
    if (n < 1) {
        layer.msg('數量不能小於1件！', {
            icon: 5
        });
        return false
    }
    $("#wfnums").val(n);
    $("#wfproup").val(d);
    $("#wfpayzk").val(z);
    $("#wfprice").val(p.toFixed(2));
    $("#showprice").html(p.toFixed(2))
}



function pay_total(z) {
    var n = $("#wfnums").val();
    var d = $("#wfproup").val();
    var p = $("#wfprice").val();
    var p = n * parseFloat(d) * z;
    $("#wfnums").val(n);
    $("#wfproup").val(d);
    $("#wfpayzk").val(z);
    $("#wfprice").val(p.toFixed(2));
    $("#showprice").html(p.toFixed(2))
}

function paypstab(i) {
    var k = 6;
    for (var j = 1; j <= k; j++) {
        if (j == i) {
            document.getElementById("payps" + j).style.display = "block"
        } else {
            document.getElementById("payps" + j).style.display = "none"
        }
    }
}

function wfrefresh() {
    var thissrc = document.getElementById("wfvcode").src;
    document.getElementById("wfvcode").src = thissrc + "&temp=" + Math.random()
}

function wfismob() {
    if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios)/i))) {
        $("#wfismob").val('wap')
    } else {
        $("#wfismob").val('pc')
    }
}

function getCookie(name) {
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg)) return unescape(arr[2]);
    else return ''
}

function getUrlstr(name) {
    var wfreg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
    var wfres = window.location.search.substr(1).match(wfreg);
    if (wfres != null) return unescape(wfres[2]);
    else return ''
}

function wfgetLLURL() {
    var WFLLURL = window.top.document.referrer;
    var IFWFLLURL = getCookie('WFLLURL');
    if (IFWFLLURL == '' || IFWFLLURL == null) {
        document.cookie = "WFLLURL=" + escape(WFLLURL) + ";path=/"
    }
}

function wfgetDDURL() {
    var WFDDURL = null;
    if (parent !== window) {
        WFDDURL = document.referrer
    } else {
        if (top !== window) {
            WFDDURL = top.location.href
        } else {
            WFDDURL = window.location.href
        }
    }
    $("#WFDDURL").val(WFDDURL)
}

function wfgetwfid() {
    var wfddsource = getUrlstr('wfid');
    var IFwfddsource = getCookie('wfddsource');
    //if (IFwfddsource == '' || IFwfddsource == null) {
        document.cookie = "wfddsource=" + escape(wfddsource) + ";path=/"
    //}
}

function wfgetdate() {
    var dd = new Date();
    dd.setDate(dd.getDate() + 0);
    var y = dd.getFullYear();
    var m = dd.getMonth() + 1;
    var d = dd.getDate();
    var now = y + "-" + m + "-" + d;
    $('.showdate').text(now)
}

function wfautoscroll(obj) {
    $(obj).find("ul").animate({
        marginTop: "-91px"
    }, 1000, function () {
        $(this).css({
            marginTop: "0px"
        }).find("li:first").appendTo(this)
    })
}
$(function (e) {
    try {
        wfload.getprovince();
        wfload.getheight();
        wfgetdate();
        wfgetLLURL()
    } catch (e) {}
    $('.area').citys();
    wfgetDDURL();
    wfgetwfid();
    wfismob()
});