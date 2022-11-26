//This Delete Data Is Done From Javascript

    $(document).on("click",".delete_form",function(){
    var id = $(this).attr('rel');
    var record = $(this).attr('record');
    // alert(id);
    swal({
            title: "Are you sure?",
            text: "You will not able to recover this record again!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it",
        },
        function() {
            window.location.href = "delete-" + record + "/" + id;
        }
    );
});


$(document).ready(function(){
    //check admin passwod is correct or not
    $("#current_pwd").keyup(function(){
     var current_pwd = $("#current_pwd").val();
    // alert(current_pwd);
    $.ajax({
           type:'post',
           url:'/admin/check-current-pwd',
           data:{current_pwd:current_pwd},
           success:function(resp){
            if(resp=="false"){
                $("#chkCurrentPwd").html("<font color=red>Current Password is incorrect</font>");
            }else if(resp=="true"){
                $("#chkCurrentPwd").html("<font color=green>Current Password is correct</font>");
            }
           },error:function(){
               alert("Error");
           }
    });
    });

    //Confirm Delete Sweetalert



    //ajax update section status
        $(document).on("click",".updateSectionStatus",function(){
        var status = $(this).children("i").attr("status");
        var section_id= $(this).attr("section_id");
        $.ajax({
            type:'post',
            url:'/admin/update-section-status',
            data:{
                status:status,
                section_id:section_id
            },
            success:function(response) {
                if(response['status']==0) {
                    $("#section-"+section_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                }else if(response['status']==1){
                    $("#section-"+section_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            },error:function(){
                alert("Error");
            }
        });
    });


        //ajax update brand status
            $(document).on("click",".updateBrandStatus",function(){
            var status = $(this).children("i").attr("status");
            // alert(status); return false;
            var brand_id= $(this).attr("brand_id");
            $.ajax({
                type:'post',
                url:'/admin/update-brand-status',
                data:{
                    status:status,
                    brand_id:brand_id
                },
                success:function(response) {
                    if(response['status']==0) {
                        $("#brand-"+brand_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                    }else if(response['status']==1){
                        $("#brand-"+brand_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                    }
                },error:function(){
                    alert("Error");
                }
            });
        });

    //ajax update category status
        $(document).on("click",".updateCategoryStatus",function(){
        var status = $(this).children("i").attr("status");
        var category_id= $(this).attr("category_id");
        $.ajax({
            type:'post',
            url:'/admin/update-category-status',
            data:{
                status:status,
                category_id:category_id
            },
            success:function(response) {
                if(response['status']==0) {
                    $("#category-"+category_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                }else if(response['status']==1){
                    $("#category-"+category_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

        //ajax update product status
            $(document).on("click",".updateProductStatus",function(){
            var status = $(this).children("i").attr("status");
            var product_id= $(this).attr("product_id");
            $.ajax({
                type:'post',
                url:'/admin/update-product-status',
                data:{
                    status:status,
                    product_id:product_id
                },
                success:function(response) {
                    if(response['status']==0) {
                        $("#product-"+product_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                    }else if(response['status']==1){
                        $("#product-"+product_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                    }
                },error:function(){
                    alert("Error");
                }
            });
        });


         //ajax update Attribute status
            $(document).on("click",".updateAttributeStatus",function(){
            var status = $(this).children("i").attr("status");
            var attribute_id= $(this).attr("attribute_id");
            $.ajax({
                type:'post',
                url:'/admin/update-attribute-status',
                data:{
                    status:status,
                    attribute_id:attribute_id
                },
                success:function(response) {
                    if(response['status']==0) {
                        $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                    }else if(response['status']==1){
                        $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                    }
                },error:function(){
                    alert("Error");
                }
            });
        });

        
         //ajax  Image status
        $(document).on("click",".updateImagestatus",function(){
        var status = $(this).children("i").attr("status");
        var image_id= $(this).attr("image_id");
        $.ajax({
            type:'post',
            url:'/admin/update-image-status',
            data:{
                status:status,
                image_id:image_id
            },
            success:function(response) {
                if(response['status']==0) {
                    $("#image-"+image_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                }else if(response['status']==1){
                    $("#image-"+image_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

       //ajax update Banner status
       $(document).on("click",".updateBannerStatus",function(){
        var status = $(this).children("i").attr("status");
         //alert("hello"); return false;
        var banner_id= $(this).attr("banner_id");
        $.ajax({
            type:'post',
            url:'/admin/update-banner-status',
            data:{
                status:status,
                banner_id:banner_id
            },
            success:function(response) {
                if(response['status']==0) {
                    $("#banner-"+banner_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                }else if(response['status']==1){
                    $("#banner-"+banner_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            },error:function(){
                alert("Error");
            }
        });
    });


//Products Attributes Add/Remove Scripts

        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="size[]" style="width:120px" placeholder="Size"/>&nbsp;<input type="text" name="sku[]" style="width:120px" placeholder="Sku"/>&nbsp;<input type="text" name="price[]" style="width:120px" placeholder="Price"/>&nbsp;<input type="text" name="stock[]" style="width:120px" placeholder="Stock"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Delete</a></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });

});

