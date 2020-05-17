let sidebarActive = null;

$(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        let collapser = $('#sidebarCollapse');

        if(sidebarActive === true){
            collapser.addClass('btn-outline-warning');
            collapser.removeClass('btn-primary');
            collapser.removeClass('btn-outline-primary');
            sidebarActive = false;

            $('#sidebar').addClass('active');
        }
        else if(sidebarActive === false){
            collapser.removeClass('btn-outline-warning');
            collapser.removeClass('btn-outline-primary');
            collapser.addClass('btn-primary');
            sidebarActive = null;

            $('#sidebar').removeClass('active');
        }
        else {
            collapser.removeClass('btn-primary');
            collapser.removeClass('btn-outline-warning');
            collapser.addClass('btn-outline-primary');
            sidebarActive = true;

            $('#sidebar').removeClass('active');
        }
    });

    $("#sidebar-detect").hover(function(){
        if(sidebarActive == null){
            $('#sidebar').removeClass('active');
        }
    });

    $("#sidebar").mouseout(function () {
        if(sidebarActive == null){
            $('#sidebar').addClass('active');
        }
    })
});
