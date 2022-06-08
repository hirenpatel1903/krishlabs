

"use strict";

jQuery(".file-upload-input").on('change', function() {
    var file = this.files;
    if (file.length > 0) {
        var file = file[0];
        jQuery(this).siblings().eq(0).text(file.name);
    } else {
        jQuery(this).siblings().eq(0).text('Choose file');
    }
});

jQuery(document).ready(function(){
    "use strict";

    jQuery(".delete").on("submit", function(){
        return confirm("Are you sure?");
    });
});
