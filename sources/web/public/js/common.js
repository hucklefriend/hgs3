/**
 * トグルボタンの切り替え
 *
 * @param check
 * @param on
 */
function toggleButton(check, on)
{
    check.prop('checked', on);

    if (on) {
        $(check.parent().get(0)).addClass('active');
    } else {
        $(check.parent().get(0)).removeClass('active');
    }
}


// 以下から拝借
// https://qiita.com/kuro123/items/b009e65cfac5eb1bb502

// delete  query string
// クエリストリング取得
/*
var urlQueryString = document.location.search;
var replaceQueryString = "";
if (urlQueryString !== "") {

    // クエリストリング毎に分割
    var params = urlQueryString.slice(1).split("&");

    // クエリストリング確認用
    for (var i = 0; i < params.length; i++) {
        var param = params[i].split("=");
        var key = param[0];
        var value = param[1];

        // 該当するクエリストリングは無視
        if (key === "delquery") continue;

        // 新たにクエリストリングを作成
        if (replaceQueryString !== "") {
            replaceQueryString += "&";
        } else {
            replaceQueryString += "?";
        }

        replaceQueryString += key + "=" + value;
    }
}

// URLに新しいクエリストリングを付与
history.pushState(null,null,replaceQueryString);
*/