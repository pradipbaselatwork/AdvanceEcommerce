$(document).ready(function(){
//   alert("test");
// $("#sort").on('change',function(){
//      this.form.submit();
// });

//Ajax Csrf Token in Laravel
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#sort").on('change',function(){
    var sort = $(this).val();
    var fabric = get_filter('fabric');
    var sleeve = get_filter('sleeve');
    var pattern = get_filter('pattern');
    var fit = get_filter('fit');
    var occassion = get_filter('occassion');
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
        data:{fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })
});

$(".fabric").on('click',function(){
    var fabric = get_filter('fabric');
    var sleeve = get_filter('sleeve');
    var pattern = get_filter('pattern');
    var fit = get_filter('fit');
    var occassion = get_filter('occassion');
    var sort = $("#sort option:selected").val();
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
          data:{fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })
});

$(".sleeve").on('click',function(){
    var fabric = get_filter('fabric');
    var sleeve = get_filter('sleeve');
    var pattern = get_filter('pattern');
    var fit = get_filter('fit');
    var occassion = get_filter('occassion');
    var sort = $("#sort option:selected").val();
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
          data:{fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })
});


$(".pattern").on('click',function(){
    var fabric = get_filter('fabric');
    var sleeve = get_filter('sleeve');
    var pattern = get_filter('pattern');
    var fit = get_filter('fit');
    var occassion = get_filter('occassion');
    var sort = $("#sort option:selected").val();
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
          data:{fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })
});



$(".fit").on('click',function(){
    var fabric = get_filter('fabric');
    var sleeve = get_filter('sleeve');
    var pattern = get_filter('pattern');
    var fit = get_filter('fit');
    var occassion = get_filter('occassion');
    var sort = $("#sort option:selected").val();
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
          data:{fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })
});



$(".occassion").on('click',function(){
    var fabric = get_filter('fabric');
    var sleeve = get_filter('sleeve');
    var pattern = get_filter('pattern');
    var fit = get_filter('fit');
    var occassion = get_filter('occassion');
    var sort = $("#sort option:selected").val();
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
          data:{fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })
});


function get_filter(class_name){
    var filter = [];
    $('.'+class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}


$("#getPrice").change(function(){
    var size = $(this).val();
    if(size== ""){
        alert("Please Select Size");
        return false;
    }
    var product_id = $(this).attr("product-id");
      $.ajax({
        url:'/get-product-price',
        data:{size:size,product_id:product_id},
        type:'post',
        success:function(resp){
        // alert(resp);
        $(".getAttrPrice").html("Rs. "+resp);
        },error:function(){
            alert("Error");
        }
      });
});

});