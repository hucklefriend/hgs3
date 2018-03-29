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