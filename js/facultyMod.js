$(document).ready( function() {
        $(".facItem").click(showInfo);
});

function showInfo()
{
    $( this ).css("float", "none");
    var thisChild = jQuery(this).find(".hours-table");
    thisChild.toggle();
    if(thisChild.css("display") == "none")
    {
        $( ".facItem ").toggle();
        $( this ).toggle();
        $( this ).css("float", "left");
        $( this ).width('30%');
    }
    else
    {
        $( ".facItem ").toggle();
        $( this ).toggle();        
        $( this ).css("float", "clear");
        $( this ).width('70%');
    }
}