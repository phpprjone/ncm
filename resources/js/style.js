// JavaScript Document

//Collapse open row in table when another rpw is opened
function collapseOthers() {
    $('.collapse').on('show.bs.collapse', function () {
        $('.collapse.in').collapse('hide');
    });
};

function toggleAccordian() {
    $("img.accordianRight").click(function () {  
		$('td:first-child').each(function() {
           var hasImage = $('img',this).length > 0;
           var imageClass = $(this).find('img').attr('class');
           if (hasImage && imageClass == 'accordianRight accordianDown') {
            $(this).find('img').toggleClass("accordianDown");
           }
       });
        $(this).toggleClass("accordianDown");
    });
};

$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});

function myFunction() {
    document.getElementById("username").innerHTML = "! Username is required.";
}
