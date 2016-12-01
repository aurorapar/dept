$(document).ready( function() {
        $(".facItem facid1111 showColors").click(showInfo);
});

function showInfo()
{
    alert("clicked");
    var hidden = $( this ).css("display");
    if(hidden == "none")
    {
        $( this ).show();
    }
    else
    {
        $( this ).hide();
    }
}