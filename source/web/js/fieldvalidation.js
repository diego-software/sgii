$(document).ready(function(){ 
    $("body").on('keydown', '.numeric-input', function(event) {
        if(event.shiftKey)
        {
            event.preventDefault();
        }
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 110 || event.keyCode == 190)    {
        }
        else {
            if (event.keyCode < 95) {
                if (event.keyCode < 48 || event.keyCode > 57) {
                    event.preventDefault();
                }
            } 
            else {
              if (event.keyCode < 96 || event.keyCode > 105) {
                  event.preventDefault();
              }
            }
        }
    });
});
