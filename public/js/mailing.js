function Print() {

}

function Forward() {
    if(activeMail.val() != null && activeMail.val() != 0){
        window.location.href = '../mails/create?action=fw&mail=' + activeMail.val();
    }
}

function Reply() {
    if(activeMail.val() != null && activeMail.val() != 0){
        window.location.href = '../mails/create?action=re&mail=' + activeMail.val();
    }
}

function Sent() {
    $('#folder').val('sent');
    $('#selected_mail').val('0');
    empty_content();
    ajax_refresh_list();
}

function Inbox() {
    $('#folder').val('inbox');
    $('#selected_mail').val('0');
    empty_content();
    ajax_refresh_list();
}

function NewMail() {
    window.location.href = '../mails/create';
}
