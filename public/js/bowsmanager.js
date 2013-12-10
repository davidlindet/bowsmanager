var BowsManager = {};

/**
 * Generic tools
 */
BowsManager.tools = (function() {

    /**
     * Calendar - used in collection form
     */
    function datepicker(){
        var $input = $(".datepicker").click(function() { return $(this); });
        $input.datepicker({ dateFormat: 'dd-mm-yy'}).val();
    }

    /**
     * Upload files with AJAX
     */
    var attachment = (function() {

        /**
         * Get informations about each files we want to upload
         * when their selected
         * @param attachmentId
         * @param module
         */
        function getData(attachmentId, module){
            var formdata = new FormData();
            $(attachmentId).on("change", function(){
                for (var i = 0 ; i < this.files.length; i++) {
                    formdata.append("images[]", this.files[i]);
                }
            });
            module.attachment = formdata;
        }

        /**
         *  Upload files with ajax
         * @param moduleName
         * @param objectId
         * @param formdata
         * @param callBack
         */
        function upload(moduleName, objectId, formdata, callBack){
            $.ajax({
                url: "/upload-" + moduleName + "?id=" + objectId,
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (res) {
                   callBack();
                }
            });
        }

        return {
            getData: getData,
            upload: upload
        }
    })();

    /**
     * Change the style of files we want to delete in
     * collection and bow form
     */
    function updateStyleDeleteAttachment() {
        $(".files").on("change", function(){
            var $file = $(this).parent().children("a");
            if(!$file.hasClass("del-attachment")){
                $file.addClass("del-attachment");
            }
            else {
                $file.removeClass("del-attachment");
            }
        });
    }

    return {
        datepicker: datepicker,
        attachment: attachment,
        updateStyleDeleteAttachment: updateStyleDeleteAttachment
    }
})();

/**
 * Popup functions
 */
BowsManager.popup = (function() {

    /**
     * Add a loading popup
     */
    function add(){
        $("body").addClass("popup-open").append("<div class='overlay'><div class='popup loading'> <img src='/img/content/loading.gif' width='25' />"+BowsManager.copies.loading +"</div></div>");
    }

    /**
     * Load content of the popup
     */
    function load(data){
        $(".overlay .popup").removeClass("loading").html(data);
    }

    /**
     * remove popup
     */
    function remove(){
        $(".back.ajax").click(function(){
            $("body").removeClass("popup-open");
            $(".overlay").remove();
        });
    }

    return {
        add: add,
        load: load,
        remove: remove
    }
})();


/**
 * Functions related to clients
 */
BowsManager.client = (function() {

    /**
     * In client list when user click on a client row
     * He's forward on client details page
     */
    function details(){
        $(".table.clients .client td").click(function() {
            if(!$(this).hasClass("list-options")) {
                window.location.href = $(this).parent().data('url');
            }
        });
    }

    /**
     * Update style form to add or update a client
     * and send data to save
     */
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

    /**
     * Send data to delete client
     */
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
                            // if on list client page hide the row
                            if(section == "client-index") {
                                $("#client-"+clientId).fadeOut("slow");
                            }
                            else {
                                // we're on client details page so forward on list client page
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

    /**
     * Display / Hide client rows
     * When user click on filter
     */
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


/**
 * Functions related to bills
 */
BowsManager.bill = (function() {

    /**
     * Files to update
     */
    var attachment = false;

    /**
     * In bill list when user click on a bill row
     * He's forward on bill details page
     */
    function details(){
        $(".table.bills .bill td").click(function() {
            if(!$(this).hasClass("bill-options")  && !$(this).hasClass("bill-is-paid") ) {
                BowsManager.popup.add();
                var billId = $(this).parent().data('id');
                var sectionId = $(this).parent().data('section');
                $.ajax({
                    url: "/bill-details/"+billId+"/"+sectionId+"/ajax",
                    method: "GET",
                    success: function(data) {
                        BowsManager.popup.load(data);
                        BowsManager.popup.remove();
                    }
                });
            }
        });
    }

    /**
     * Display a popup to add bill data
     */
    function add(){
        $(".bill.add").click(function() {
            BowsManager.popup.add();

            var collectionId = $(this).data('collection');
            var section = $(this).data('section');

            $.ajax({
                url: "/bill-add/"+collectionId+"/"+section+"/ajax",
                method: "GET",
                success: function(data) {
                    BowsManager.popup.load(data);
                    BowsManager.popup.remove();
                }
            });
        });
    }


    /**
     * Display a popup to edit bill data
     */
    function edit(){
        $(".bill.edit").click(function() {
            BowsManager.popup.add();

            var billId = $(this).data('id');
            var section = $(this).data('section');

            $.ajax({
                url: "/bill-edit/"+billId+"/"+section+"/ajax",
                method: "GET",
                success: function(data) {
                    BowsManager.popup.load(data);
                    BowsManager.popup.remove();
                }
            });
        });
    }

    /**
     * Update style form to add or update a bill
     * and send data to save
     */
    function save(){
        // init - update style of file list we want to delete (update form)
        BowsManager.tools.updateStyleDeleteAttachment();

        // init action done when submit form
        $("#bill-form").submit(function( event ) {
            event.preventDefault();
            $("#save-bill").html("<img src='/img/content/loading.gif' width='25' />"+BowsManager.copies.loading);
            var params = $("#bill-form").serializeForm();
            //Send data to save
            $.ajax({
                url: "/bill-save",
                method: "POST",
                data: params,
                success: function(data) {
                    if(data.success){
                        var callback = function(){
                            if(data.section == "bill-index"){
                                // return on bill list page
                                window.location.href = '/bill/'+data.id+'/'+data.section;
                            }
                            else {
                                // return on collection details page
                                window.location.href = '/collection-details/'+data.collectionId+'/'+data.section;
                            }
                        };
                        //upload files
                        BowsManager.tools.attachment.upload("bill",
                            data.id,
                            BowsManager.bill.attachment,
                            callback
                        );
                    }
                    else {
                        $('.error-message.bill').html(data.error);
                    }
                }
            });
        });
    }

    /**
     * Send data to delete bill
     */
    function del(){
        $(".bill.delete").click(function() {
            var billId = $(this).data('id');
            var section = $(this).data('section');

            if(confirm(BowsManager.copies.deleteBill)){
                $.ajax({
                    url: "/bill-delete",
                    method: "POST",
                    data: {id: billId},
                    success: function(data) {
                        if(data.success){
                            // on bill list page so hide row
                            if(typeof section == "undefined") {
                                $("#bill-"+billId).fadeOut("slow");
                            }
                            else {
                                //on bill details page so return on collection details page
                                window.location.href = '/bill/'+section;
                            }
                        }
                        else {
                            $('.error-message.bill').html(data.error);
                        }
                    }
                });
            }
        });
    }

    /**
     * Display a confirm and if positive change isPaid status
     * to true
     */
    function paid() {
        $(".bill-is-paid").click(function(e) {
            var $isPaidElement = $(this);
            var billId = $isPaidElement.data('id');
            if(confirm(BowsManager.copies.isBillPaid)){
                $.ajax({
                    url: "/bill-is-paid",
                    method: "POST",
                    data: {id: billId},
                    success: function(data) {
                        if(data.success){
                            $isPaidElement.removeClass("bill-is-paid").html("<img src='/img/content/valid.png' />");
                        }
                        else {
                            $('.error-message.bill').html(data.error);
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
        edit: edit,
        save: save,
        del: del,
        paid: paid
    }
})();

/**
 * Functions related to bows
 */
BowsManager.bow = (function() {

    /**
     * Files to update
     */
    var attachment = false;

    /**
     * In bow list when user click on a bow row
     * He's forward on bow details page
     */
    function details(){
        $(".table.bows .bow td").click(function() {
            if(!$(this).hasClass("list-options") && !$(this).hasClass("bow-is-it-done")) {
                window.location.href = $(this).parent().data('url');
            }
        });
    }

    /**
     * Update style form to add or update a bow
     * and send data to save
     */
    function add(){
        // init - update style of file list we want to delete (update form)
        BowsManager.tools.updateStyleDeleteAttachment();

        // init action done when submit form
        $("#bow-form").submit(function( event ) {
            event.preventDefault();
            $("#save-bow").html("<img src='/img/content/loading.gif' width='25' />"+BowsManager.copies.loading);
            var params = $("#bow-form").serializeForm();
            //Send data to save
            $.ajax({
                url: "/bow-save",
                method: "POST",
                data: params,
                success: function(data) {
                    if(data.success){
                        var callback = function(){
                            // return on collection details page
                            window.location.href = '/collection-details/'+data.collectionId+'/'+data.section;
                        };
                        //upload files
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

    /**
     * Display a popup to edit bow data
     */
    function edit(){
        $(".bow.edit").click(function() {
            BowsManager.popup.add();

            var bowId = $(this).data('id');
            var section = $(this).data('section');

            $.ajax({
                url: "/bow-edit/"+bowId+"/"+section+"/ajax",
                method: "GET",
                success: function(data) {
                    BowsManager.popup.load(data);
                    BowsManager.popup.remove();
                }
            });
        });
    }

    /**
     * Send data to delete bow
     */
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
                            // on bow list page so hide row
                            if(typeof section == "undefined") {
                                $("#bow-"+bowId).fadeOut("slow");
                            }
                            else {
                                //on bow details page so return on collection details page
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

    /**
     * Display a confirm and if positive change isDone status
     * to true
     */
    function done() {
        $(".bow-is-it-done").click(function(e) {
            e.stopPropagation();
            var $isDoneElement = $(this);
            var bowId = $isDoneElement.data('id');
            if(confirm(BowsManager.copies.isDoneBow)){
                $.ajax({
                    url: "/bow-is-done",
                    method: "POST",
                    data: {id: bowId},
                    success: function(data) {
                        if(data.success){
                            $isDoneElement.removeClass("bow-is-it-done").html("<img src='/img/content/valid.png' />");
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
        edit: edit,
        del: del,
        done: done
    }
})();

/**
 * Functions related to collections
 */
BowsManager.collection = (function() {

    /**
     * In bow list when user click on a collection row
     * He's forward on collection details page
     */
    function details(){
        $(".table.collections .collection td").click(function() {
            if(!$(this).hasClass("list-options")) {
                window.location.href = $(this).parent().data('url');
            }
        });
    }

    /**
     * Update style form to add or update a collection
     * and send data to save
     */
    function add(){
        // init action done when submit form
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
                        window.location.href = '/collection-details/'+data.id+'/'+data.section;
                    }
                    else {
                        $('.error-message.collection').html(data.error);
                    }
                }
            });
        });
    }

    /**
     * Send data to delete collection
     */
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
                                // on collection list page so hide row
                                $("#collection-"+collectionId).fadeOut("slow");
                            }
                            else {
                                //on collection details page so return on client details page
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
        details: details,
        add: add,
        del: del
    }
})();


/**
 * Functions related to suppliers
 */
BowsManager.supplier = (function() {

    /**
     * In supplier list when user click on a supplier row
     * He's forward on supplier details page
     */
    function details(){
        $(".table.suppliers .supplier td").click(function() {
            if(!$(this).hasClass("supplier-options")) {
                window.location.href = $(this).parent().data('url');
            }
        });
    }

    /**
     * Display a popup to add supplier data
     */
    function add(){
        $(".supplier.add").click(function() {
            BowsManager.popup.add();

            var section = $(this).data('section');

            $.ajax({
                url: "/supplier-add/"+section+"/ajax",
                method: "GET",
                success: function(data) {
                    BowsManager.popup.load(data);
                    BowsManager.popup.remove();
                }
            });
        });
    }


    /**
     * Display a popup to edit supplier data
     */
    function edit(){
        $(".supplier.edit").click(function() {
            BowsManager.popup.add();

            var supplierId = $(this).data('id');
            var section = $(this).data('section');

            $.ajax({
                url: "/supplier-edit/"+supplierId+"/"+section+"/ajax",
                method: "GET",
                success: function(data) {
                    BowsManager.popup.load(data);
                    BowsManager.popup.remove();
                }
            });
        });
    }

    /**
     * Update style form to add or update a supplier
     * and send data to save
     */
    function save(){
        // init action done when submit form
        $("#supplier-form").submit(function( event ) {
            event.preventDefault();
            $("#save-supplier").html("<img src='/img/content/loading.gif' width='25' />"+BowsManager.copies.loading);
            var params = $("#supplier-form").serializeForm();
            //Send data to save
            $.ajax({
                url: "/supplier-save",
                method: "POST",
                data: params,
                success: function(data) {
                    if(data.success){
                        if(data.section == "supplier-index"){
                            // return on bill list page
                            window.location.href = '/supplier-list/'+data.section;
                        }
                        else {
                            // return on collection details page
                            window.location.href = '/supplier-details/'+data.id+'/'+data.section;
                        }
                    }
                    else {
                        $('.error-message.supplier').html(data.error);
                    }
                }
            });
        });
    }

    /**
     * Send data to delete supplier
     */
    function del(){
        $(".supplier.delete").click(function() {
            var supplierId = $(this).data('id');
            var section = $(this).data('section');

            if(confirm(BowsManager.copies.deleteSupplier)){
                $.ajax({
                    url: "/supplier-delete",
                    method: "POST",
                    data: {id: supplierId},
                    success: function(data) {
                        if(data.success){
                            // on bill list page so hide row
                            if(typeof section == "undefined") {
                                $("#supplier-"+supplierId).fadeOut("slow");
                            }
                            else {
                                //on bill details page so return on collection details page
                                window.location.href = '/supplier-list/'+section;
                            }
                        }
                        else {
                            $('.error-message.supplier').html(data.error);
                        }
                    }
                });
            }
        });
    }

    /**
     * Display / Hide supplier rows
     * When user click on filter
     */
    function listInitFilters(){
        $(".supplier-filter").click(function() {
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
        edit: edit,
        save: save,
        del: del,
        listInitFilters : listInitFilters
    }
})();

/**
 * Functions related to product types
 */
BowsManager.productType = (function() {

    /**
     * In product type list when user click on a product type row
     * He's forward on product type details page
     */
    function details(){
        $(".table.product-types .product-type td").click(function() {
            if(!$(this).hasClass("product-type-options")) {
                window.location.href = $(this).parent().data('url');
            }
        });
    }

    /**
     * Display a popup to add product type data
     */
    function add(){
        $(".product-type.add").click(function() {
            BowsManager.popup.add();

            var section = $(this).data('section');

            $.ajax({
                url: "/product-type-add/"+section+"/ajax",
                method: "GET",
                success: function(data) {
                    BowsManager.popup.load(data);
                    BowsManager.popup.remove();
                }
            });
        });
    }


    /**
     * Display a popup to edit product-type data
     */
    function edit(){
        $(".product-type.edit").click(function() {
            BowsManager.popup.add();

            var productTypeId = $(this).data('id');
            var section = $(this).data('section');

            $.ajax({
                url: "/product-type-edit/"+productTypeId+"/"+section+"/ajax",
                method: "GET",
                success: function(data) {
                    BowsManager.popup.load(data);
                    BowsManager.popup.remove();
                }
            });
        });
    }

    /**
     * Update style form to add or update a product-type
     * and send data to save
     */
    function save(){
        // init action done when submit form
        $("#product-type-form").submit(function( event ) {
            event.preventDefault();
            $("#save-product-type").html("<img src='/img/content/loading.gif' width='25' />"+BowsManager.copies.loading);
            var params = $("#product-type-form").serializeForm();
            //Send data to save
            $.ajax({
                url: "/product-type-save",
                method: "POST",
                data: params,
                success: function(data) {
                    if(data.success){
                        if(data.section == "product-type-index"){
                            // return on bill list page
                            window.location.href = '/product-type-list/'+data.section;
                        }
                        else {
                            // return on collection details page
                            window.location.href = '/product-type-details/'+data.id+'/'+data.section;
                        }
                    }
                    else {
                        $('.error-message.product-type').html(data.error);
                    }
                }
            });
        });
    }

    /**
     * Send data to delete product-type
     */
    function del(){
        $(".product-type.delete").click(function() {
            var productTypeId = $(this).data('id');
            var section = $(this).data('section');

            if(confirm(BowsManager.copies.deleteProductType)){
                $.ajax({
                    url: "/product-type-delete",
                    method: "POST",
                    data: {id: productTypeId},
                    success: function(data) {
                        if(data.success){
                            // on product type list page so hide row
                            if(typeof section == "undefined") {
                                $("#product-type-"+productTypeId).fadeOut("slow");
                            }
                            else {
                                //on product type details page so return on collection details page
                                window.location.href = '/product-type-list/'+section;
                            }
                        }
                        else {
                            $('.error-message.product-type').html(data.error);
                        }
                    }
                });
            }
        });
    }

    return {
        details: details,
        add: add,
        edit: edit,
        save: save,
        del: del
    }
})();

/**
 * Functions related to the search
 */
BowsManager.search = (function() {

    function search(){

        $("#search-form").submit(function( event ) {
            event.preventDefault();
            var params = $("#search-form").serializeForm();

            //reset results
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
                        //update client results
                        if(data.clientHTML){
                            $('#client-results').html(data.clientHTML);
                            BowsManager.client.details();
                            BowsManager.client.del();
                        }

                        //update bow results
                        if(data.bowHTML){
                            $('#bow-results').html(data.bowHTML);
                            BowsManager.bow.details();
                            BowsManager.bow.del();
                        }

                        //update collection results
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