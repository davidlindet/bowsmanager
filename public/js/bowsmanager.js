var BowsManager = {};

BowsManager.client = (function() {

    function add(){
        $("#client-form").submit(function( event ) {
            event.preventDefault();
            var params = $("#client-form").serializeForm();
            $.ajax({
                url: "/client-save",
                method: "POST",
                data: params,
                success: function(data) {
                    if(data.success){
                        window.location.href = '/client/details/'+data.id;
                    }
                    else {
                        $('.error-message').html("Impossible d'enregistrer client");
                    }
                }
            });
        });
    }

    function del(){
        $(".client-delete").click(function() {
            var clientId = $(this).data('id');
            var section = $(this).data('section');
            if(confirm("Voulez vous vraiment supprimer ce client?")){
                $.ajax({
                    url: "/client-delete",
                    method: "POST",
                    data: {id: clientId},
                    success: function(data) {
                        if(data.success){
                            if(section == "list") {
                                $("#client-"+clientId).fadeOut("slow");
                            }
                            else {
                                window.location.href = '/client';
                            }
                        }
                        else {
                            $('.error-message').html("Impossible de supprimer un client");
                        }
                    }
                });
            }
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
        del: del,
        listInitFilters : listInitFilters
    }
})();