let folder = "";
let activeMail = "";
let ajax_list = "";
let ajax_mail = "";
let username = "";
let csrf = "";

$( document ).ready(function() {
    ajax_list = $('#ajax_list');
    ajax_mail = $('#ajax_mail');
    activeMail = $('#selected_mail');
    folder = $('#folder');
    username = $('#user_name').val();
    csrf = $('meta[name=csrf-token]').attr("content");
    ajax_refresh_list();
});


function ajax_refresh_list() {

    $.ajax({
        url: '/mailing/' + folder.val(),
        dataType: 'text',
        type: 'post',
        contentType: 'application/x-www-form-urlencoded',
        data: {
            'username': username,
            'selected': activeMail.val(),
            '_token': csrf
        },
        success: function( data, textStatus, jQxhr ){
            ajax_list.html( data );
        },
        error: function( jqXhr, textStatus, errorThrown ){
            ajax_list.html( jqXhr.responseText );
        }
    });
}

function ajax_refresh_content() {
    $.ajax({
        url: '/mails/' + activeMail.val(),
        dataType: 'text',
        type: 'get',
        contentType: 'application/x-www-form-urlencoded',
        data: {
            'username': username,
            'selected': activeMail.val(),
            '_token': csrf
        },
        success: function( data, textStatus, jQxhr ){
            ajax_mail.html( data );
            $('#mail_count').html($('#mail_count_ajax').val());
        },
        error: function( jqXhr, textStatus, errorThrown ){
            ajax_mail.html( jqXhr.responseText );
        }
    });
}

function empty_content() {
    ajax_mail.html( '' );
    $('#mail_count').html($('#mail_count_ajax').val());
}

function selectMail(id) {
    activeMail.val(id);
    ajax_refresh_content();
    ajax_refresh_list();
}
