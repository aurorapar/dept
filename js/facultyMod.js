$( document ).ready(function() {
        
        var pathname = window.location;
        if(pathname == 'http://localhost/dept/faculty.php')
        {
            $( ".content-focus" ).addClass("centeredItem").width(1250).css("background-color", "white");
        }        
});