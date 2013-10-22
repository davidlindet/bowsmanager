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
                        $('.error-message').html(BowsManager.copies.errorSaveClient);
                    }
                }
            });
        });
    }

    function del(){
        $(".client-delete").click(function() {
            var clientId = $(this).data('id');
            var section = $(this).data('section');
            if(confirm(BowsManager.copies.deleteClient)){
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

BowsManager.bow = (function() {

    function add(){
        $("#bow-form").submit(function( event ) {
            event.preventDefault();
            var params = $("#bow-form").serializeForm();
            $.ajax({
                url: "/bow-save",
                method: "POST",
                data: params,
                success: function(data) {
                    if(data.success){
                        window.location.href = '/bow/details/'+data.id;
                    }
                    else {
                        $('.error-message').html("Impossible d'enregistrer l'archet");
                    }
                }
            });
        });
    }

    function del(){
        $(".bow-delete").click(function() {
            var bowId = $(this).data('id');
            var section = $(this).data('section');
            if(confirm("Voulez vous vraiment supprimer cet archet?")){
                $.ajax({
                    url: "/bow-delete",
                    method: "POST",
                    data: {id: bowId},
                    success: function(data) {
                        if(data.success){
                            if(section == "list") {
                                $("#bow-"+bowId).fadeOut("slow");
                            }
                            else {
                                window.location.href = '/bow';
                            }
                        }
                        else {
                            $('.error-message').html("Impossible de supprimer l'archet");
                        }
                    }
                });
            }
        });
    }

    return {
        add: add,
        del: del
    }
})();

BowsManager.search = (function() {

    function search(){

        $("#search-form").submit(function( event ) {
            event.preventDefault();
            var params = $("#search-form").serializeForm();

            $('#client-results').html("");
            $('#bow-results').html("");
            $('.error-message').html("");

            $.ajax({
                url: "/search/search",
                method: "POST",
                data: params,
                success: function(data) {
                    if(data.success){
                        $('#client-results').html(data.clientHTML);
                        $('#bow-results').html(data.bowHTML);
                    }
                    else {
                        $('.error-message').html(data.error);
                    }
                }
            });
        });
    }

    return {
        search: search
    }
})();