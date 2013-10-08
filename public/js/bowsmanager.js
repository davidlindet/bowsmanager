var BowsManager = {};

BowsManager.client = (function() {

    function add(){
        $("#client-form").submit(function( event ) {
            event.preventDefault();
            var params = $("#client-form").serializeForm();
            $.ajax({
                url: "/client-save",
                method: "POST",
                data: params
            });
        });
    }

    return {
        add: add
    }
})();