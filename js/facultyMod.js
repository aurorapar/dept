$(document).ready( function() {
        if(window.location.pathname.endsWith('adminFac.php'))
        {            
            setStyles();            
            $( "#update" ).click(sendValues);
        }
        else
        {
            //$(".fac :nth-child(4)" ).css("clear", "both");
            $(".facItem").click(showInfo);
        }
});

function sendValues()
{
    
    tinyMCE.triggerSave();
    data = $( "#updateForm" ).serialize();
    
    var request = $.ajax({
            url: "update.php",
            type: "POST",
            data: {
                "data": $( "#updateForm").serialize(),
            },
            dataType: "text"
        });
        request.done(function(msg) {
            $( ".facItem" ).html(msg);
            setStyles();
        });
        request.fail(function(msg) {
            alert("AJAX CALL FAILED");
        });
            
    event.preventDefault();    
       
}   

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
            changeMe.append("Click to close.");
        });
        request.fail(function(msg) {
            alert("AJAX CALL FAILED");
        });
            
        event.preventDefault();
    }
}


function setStyles()
{
    $( ".content-focus" ).css("float", "none").width("70%").css("margin-left", "auto").css("margin-right", "auto").css("display", "block");
    $( ".facItem").css("float", "none").width("70%").css("margin-left", "auto").css("margin-right", "auto").css("display", "block");
    setTimeButtons();
    $( ".hours-table" ).show();
    $( ".content-focus:first" ).hide();
    $ ( "input[type=hidden" ).val( $( "h3 > a" ).text());
}
