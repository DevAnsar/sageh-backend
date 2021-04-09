
let delete_url;
let token;
let send_array_data = false;
let _method = 'DELETE';
restore_row = function (url, t, message_text) {
    _method = 'post';
    delete_url = url;
    token = t;
    $("#msg").text(message_text);
    $('.message_div').show();
};
del_row = function (url, t, message_text) {
    _method = 'DELETE';
    delete_url = url;
    token = t;
    $("#msg").text(message_text);
    $(".message_div").show();
};
delete_row = function () {
    if (send_array_data) {

        $("#data_form").submit();
    }
    else {
        console.log(delete_url);
        let form = document.createElement('form');
        form.setAttribute('method', 'POST');
        form.setAttribute('action', delete_url);
        const hiddenField1 = document.createElement('input');
        hiddenField1.setAttribute('name', '_method');
        hiddenField1.setAttribute('value', _method);
        form.appendChild(hiddenField1);
        const hiddenField2 = document.createElement('input');
        hiddenField2.setAttribute('name', '_token');
        hiddenField2.setAttribute('value', token);
        form.appendChild(hiddenField2);
        document.body.appendChild(form);
        console.log('form');
        form.submit();
        document.body.removeChild(form);
    }
};
hide_box = function () {
    token = '';
    delete_url = '';
    $(".message_div").hide();
};

$('input.check_box').click(function () {
    console.log('check_box');
    send_array_data = false;
    const $checkboxes = $('.panel_content input[type="checkbox"]');
    const count = $checkboxes.filter(':checked').length;

    if (count > 0) {
        console.log('count',count);
        $("#destroy_items").removeClass('off');
        $("#restore_items").removeClass('off');
    }
    else {
        $("#destroy_items").addClass('off');
        $("#restore_items").addClass('off');
    }
});

$('.item_form').click(function () {
    console.log('item_form clicked');
    send_array_data = true;
    const $checkboxes = $('.panel_content input[type="checkbox"]');
    const count = $checkboxes.filter(':checked').length;
    if (count > 0) {
        const href = window.location.href.split('?');
        let action = href[0] + "/" + this.id;
        if (href.length == 2) {
            action = action + "?" + href[1];
        }
        $("#data_form").attr('action', action);
        $("#msg").text($(this).attr('msg'));
        $('.message_div').show();
    }
});
logout=function () {
    $('#LogOut').submit();
};