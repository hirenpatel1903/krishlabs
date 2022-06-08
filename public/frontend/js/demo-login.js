(function($) {
    "use strict"; // Start of use strict

    $('#demoadmin').on("click", function() {
        $('#demoemail').val('admin@example.com');
        $('#demopassword').val('123456');
        $('#demopassword').attr('type','text');
    });

    $('#demoshopowner').on("click", function() {
        $('#demoemail').val('shopowner@example.com');
        $('#demopassword').val('123456');
        $('#demopassword').attr('type','text');
    });

    $('#demoshopowner2').on("click", function() {
        $('#demoemail').val('shopowner2@example.com');
        $('#demopassword').val('123456');
        $('#demopassword').attr('type','text');
    });

})(jQuery); // End of use strict
