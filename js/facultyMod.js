$(document).ready( function() {
        if(window.location.pathname == '/dept/adminFac.php')
        {
            $( ".content-focus" ).css("float", "none").width("70%").css("margin-left", "auto").css("margin-right", "auto").css("display", "block");

            $( ".content-focus:first" ).hide();
            
            // This would be passed via an authentication page
            var name = 'Joan Francioni';
            setCurrentDisplay(name);
            
            $( "td" ).width("10%");
        }
        else
        {
            //$(".fac :nth-child(4)" ).css("clear", "both");
            $(".facItem").click(showInfo);
        }
});

function showInfo()
{
    //$ ( ".fac" ).css();
    
    $( this ).css("float", "none");
    var thisChild = jQuery(this).find(".hours-table");
    thisChild.toggle();
    if(thisChild.css("display") == "none")
    {   
        $( ".facItem ").toggle();
        $( this ).toggle();
        $( this ).css("float", "left");
        $( this ).width('30%');
        $( this ).css("margin-left", "1%");
        $( this ).css("margin-right", "0%");
    }
    else
    {
        $( ".facItem ").toggle();
        $( this ).toggle();        
        $( this ).css("float", "clear");
        $( this ).width('70%');
        $( this ).css("margin-left", "auto");
        $( this ).css("margin-right", "auto");
        
        var changeMe = $( ".hours-table" );
        
        var request = $.ajax({
            url: "facResponse.php",
            type: "POST",
            data: {
                "profName": $( this ).find("h3 > a").text(),
            },
            dataType: "text"
        });
        request.done(function(msg) {
            changeMe.html(msg);
        });
        request.fail(function(msg) {
            alert("AJAX CALL FAILED");
        });
            
        event.preventDefault();
    }
}

function setCurrentDisplay(teacher)
{
        var changeMe = $( "#content" );
        
        var request = $.ajax({
            url: "adminResponse.php",
            type: "POST",
            data: {
                "profName": teacher,
            },
            dataType: "text"
        });
        request.done(function(msg) {
            changeMe.prepend(msg);
            $( ".facItem").css("float", "none").width("70%").css("margin-left", "auto").css("margin-right", "auto").css("display", "block");
            $( ".hours-table" ).show();
        });
        request.fail(function(msg) {
            alert("AJAX CALL FAILED");
        });
}
