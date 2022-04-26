$(document).ready(function(){
    $("select[name='level']").on('change', function(){
        if($(this).val() > 1){
            $.ajax({
               url : 'http://localhost:8000/api/showparentcategory',
               data : {
                   "level" : $(this).val()
                },
               type : 'POST',
               dataType : 'json',
               success:function(res){
                var select ="";
                for(i = 0; i < res.length; i++){
                    select += "<option value="+res[i].category_id+">"+res[i].category_name+"</option>";
                }
                $("#select_parent").html('<option value="">Pilih</option>'+select);
               },
            });
            $("#parent_category").show();
        }else{
            $("#parent_category").hide();
            $("#select_parent").html("");
        }
    });

    $('.selectkategori').select2({
        theme : "bootstrap4"
    });

    $('#artikel').summernote({
        height:400,
        maximumImageFileSize: 1000*1024, // 500 KB
        callbacks:{
            onImageUploadError: function(msg){
                console.log(msg + ' (1 MB)');
            }
        },
        imageAttributes: {
            icon: '<i class="note-icon-pencil"/>',
            figureClass: 'figureClass',
            figcaptionClass: 'captionClass',
            captionText: 'Caption Goes Here.',
            manageAspectRatio: true // true = Lock the Image Width/Height, Default to true
        },
        lang: 'en-US',
        popover: {
            image: [
                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']],
                ['custom', ['imageAttributes']],
            ],
        }
    });

    $(function () {
        bsCustomFileInput.init();
    });

    var buttonpressed;
    $('button[name="button"]').click(function() {
        buttonpressed = $(this).attr('id')
    });

    $('form#post').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('button',buttonpressed);
        formData.append('user_id',$("#user_id").val());
        if(buttonpressed == "cancel"){
            window.location.href="http://localhost:8000/home/post";
        }
        var url, method;
        if(buttonpressed == "save" || buttonpressed == "draft"){
            url = 'http://localhost:8000/api/savepost';
            method = "POST";
        }
        else if(buttonpressed == "update" || buttonpressed == "draftupdate" || buttonpressed == "approve" || buttonpressed == "reject" || buttonpressed == "unpublish"){
            url = 'http://localhost:8000/api/updatepost/'+$('#postid').val();
            method = "POST";
        }
        $.ajax({
            url : url,
            cache:false,
            contentType: false,
            processData: false,
            type : method,
            data : formData,
            dataType : 'json',
            beforeSend:function(){
                $("button#"+buttonpressed).attr('disabled',true);
                $("button#"+buttonpressed).html('Loading...');
            },
            success:function(res){
                var message = "";
                var font;
                if(buttonpressed == "cancel"){
                    font = "times";
                }else{
                    font = buttonpressed;
                }
                $("button#"+buttonpressed).html('<i class="fa fa-'+font+'"></i> '+buttonpressed.charAt(0).toUpperCase()+buttonpressed.slice(1));
                if(res.validate_error == true){
                    $.each(res.message, function(index,item){   
                        $.each(res.message[index], function(index2, item2){
                            message += res.message[index][index2]+"<br>";
                        });
                    });
                }else{
                    message = res.message;
                }
                if(res.error == true){
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    $("#alert").addClass('alert alert-danger');
                    $("#alert").css('display','block');
                    $("#alert").html(message);
                    console.log(message);
                    $("button#"+buttonpressed).attr('disabled',false);
                }else{
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    $("#alert").removeClass('alert alert-danger');
                    $("#alert").addClass('alert alert-success');
                    $("#alert").css('display','block');
                    $("#alert").html(message);
                    console.log(message);
                    setTimeout(function(){
                        window.location.href="http://localhost:8000/home/post";
                    },3000)
                }
            },
            error:function(){
                $("button#save").attr('disabled',false);
            }
        });
    });

    // if($("select[name='level']").val() !== ""){
    //     $.ajax({
    //         url : 'http://localhost:8000/api/showparentcategory',
    //         data : {"level" : $("select[name='level']").val() },
    //         type : 'POST',
    //         dataType : 'json',
    //         success:function(res){
    //          var select ="";
    //          for(i = 0; i < res.length; i++){
    //              select += "<option value="+res[i].category_id+">"+res[i].category_name+"</option>";
    //          }
    //          $("#select_parent").html('<option value="">Pilih</option>'+select);
    //         },
    //      });
    //     $("#parent_category").show();
    // }

});