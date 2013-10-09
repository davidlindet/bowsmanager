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

    function listInitFilters(){
        $(".client-filter").click(function() {
            var filter = this.id;
            $(".data").hide();
            if(filter == "ALL"){
                $(".data").show();
            }
            else {
                $("."+filter).show();
            }
        });
    }

    return {
        add: add,
        listInitFilters : listInitFilters
    }
})();