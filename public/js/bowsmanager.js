var BowsManager = {};

BowsManager.tools = (function() {

    function datepicker(){
        var $input = $(".datepicker").click(function() { return $(this); });
        $input.datepicker({ dateFormat: 'dd-mm-yy'}).val();
    }

    var attachment = (function(){
        function getData(attachmentId, module){
            var formdata = new FormData();
            $(attachmentId).on("change", function(){
                for (var i = 0 ; i < this.files.length; i++) {
                    formdata.append("images[]", this.files[i]);
                }
            });
            module.attachment = formdata;
        }

        function upload(moduleName, objectId, formdata, callBack){
            console.log(formdata);

            $.ajax({
                url: "/upload-" + moduleName + "?id=" + objectId,
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (res) {
                   // callBack();
                }
            });
        }

        return {
            getData: getData,
            upload: upload
        }
    })();

    return {
        datepicker: datepicker,
        attachment: attachment
    }
})();

BowsManager.client = (function() {

    function details(){
        $(".table.clients .client td").click(function() {
            if(!$(this).hasClass("list-options")) {
                window.location.href = $(this).parent().data('url');
            }
        });
    }

    function add(){
        $("#client-form").submit(function( event ) {
            event.preventDefault();
            $("#save-client").html("<img src='/img/content/loading.gif' width='25' />"+BowsManager.copies.loading);
            var params = $("#client-form").serializeForm();
            $.ajax({
                url: "/client-save",
                method: "POST",
                data: params,
                success: function(data) {
                    if(data.success){
                        window.location.href = '/client-details/'+data.id;
                    }
                    else {
                        $('.error-message.client').html(data.error);
                    }
                }
            });
        });
    }

    function del(){
        $(".client.delete").click(function() {
            var clientId = $(this).data('id');
            var section = $(this).data('section');
            if(confirm(BowsManager.copies.deleteClient)){
                $.ajax({
                    url: "/client-delete",
                    method: "POST",
                    data: {id: clientId},
                    success: function(data) {
                        if(data.success){
                            if(section == "client-index") {
                                $("#client-"+clientId).fadeOut("slow");
                            }
                            else {
                                window.location.href = '/client';
                            }
                        }
                        else {
                            $('.error-message.client').html(data.error);
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
                $("."+filter.toLowerCase()).show();
            }
        });
    }

    return {
        details: details,
        add: add,
        del: del,
        listInitFilters : listInitFilters
    }
})();

BowsManager.bow = (function() {

    var attachment = false;

    function details(){
        $(".table.bows .bow td").click(function() {
            if(!$(this).hasClass("list-options")) {
                window.location.href = $(this).parent().data('url');
            }
        });
    }

    function add(){
        $("#bow-form").submit(function( event ) {
            event.preventDefault();
            $("#save-bow").html("<img src='/img/content/loading.gif' width='25' />"+BowsManager.copies.loading);
            var params = $("#bow-form").serializeForm();
            $.ajax({
                url: "/bow-save",
                method: "POST",
                data: params,
                success: function(data) {
                    if(data.success){
                        var callback = function(){
                            window.location.href = '/collection-details/'+data.collectionId+'/'+data.section;
                        };
                        BowsManager.tools.attachment.upload("bow",
                            data.id,
                            BowsManager.bow.attachment,
                            callback
                        );
                    }
                    else {
                        $('.error-message.bow').html(data.error);
                    }
                }
            });
        });
    }

    function del(){
       $(".bow.delete").click(function() {
            var bowId = $(this).data('id');
            var section = $(this).data('section');
            var collectionId = $(this).data('collectionid');

            if(confirm(BowsManager.copies.deleteBow)){
                $.ajax({
                    url: "/bow-delete",
                    method: "POST",
                    data: {id: bowId},
                    success: function(data) {
                        if(data.success){
                            if(typeof section == "undefined") {
                                $("#bow-"+bowId).fadeOut("slow");
                            }
                            else {
                                window.location.href = '/collection-details/'+collectionId+'/'+section;
                            }
                        }
                        else {
                            $('.error-message.bow').html(data.error);
                        }
                    }
                });
            }
        });
    }

    return {
        attachment: attachment,
        details: details,
        add: add,
        del: del
    }
})();

BowsManager.collection = (function() {

    var attachment = false;

    function details(){
        $(".table.collections .collection td").click(function() {
            if(!$(this).hasClass("list-options")) {
                window.location.href = $(this).parent().data('url');
            }
        });
    }

    function add(){
        $("#collection-form").submit(function( event ) {
            event.preventDefault();
            $("#save-collection").html("<img src='/img/content/loading.gif' width='25' />"+BowsManager.copies.loading);
            var params = $("#collection-form").serializeForm();
            $.ajax({
                url: "/collection-save",
                method: "POST",
                data: params,
                success: function(data) {
                    if(data.success){
                        var callback = function(){
                            window.location.href = '/collection-details/'+data.id+'/'+data.section;
                        };
                        BowsManager.tools.attachment.upload("collection",
                                                                data.id,
                                                                BowsManager.collection.attachment,
                                                                callback
                                                            );
                    }
                    else {
                        $('.error-message.collection').html(data.error);
                    }
                }
            });
        });
    }

    function del(){
        $(".collection.delete").click(function() {
            var collectionId = $(this).data('id');
            var clientId = $(this).data('clientid');
            var section = $(this).data('section');
            if(confirm(BowsManager.copies.deleteCollection)){
                $.ajax({
                    url: "/collection-delete",
                    method: "POST",
                    data: {id: collectionId},
                    success: function(data) {
                        if(data.success){
                            if(typeof clientId == "undefined") {
                                $("#collection-"+collectionId).fadeOut("slow");
                            }
                            else {
                                var url = "/collection";
                                if(section.indexOf("client") !== false){
                                    url = '/client-details/'+ clientId;
                                }
                                window.location.href = url;
                            }
                        }
                        else {
                            $('.error-message.collection').html(data.error);
                        }
                    }
                });
            }
        });
        return;
    }

    return {
        attachment: attachment,
        details: details,
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
            $('#collection-results').html("");
            $('.error-message.search').html("");

            $.ajax({
                url: "/search/search",
                method: "POST",
                data: params,
                success: function(data) {
                    if(data.success){
                        if(data.clientHTML){
                            $('#client-results').html(data.clientHTML);
                            BowsManager.client.details();
                            BowsManager.client.del();
                        }

                        if(data.bowHTML){
                            $('#bow-results').html(data.bowHTML);
                            BowsManager.bow.details();
                            BowsManager.bow.del();
                        }

                        if(data.collectionHTML){
                            $('#collection-results').html(data.collectionHTML);
                            BowsManager.collection.details();
                            BowsManager.collection.del();
                        }
                    }
                    else {
                        $('.error-message.search').html(data.error);
                    }
                }
            });
        });
    }

    return {
        search: search
    }
})();