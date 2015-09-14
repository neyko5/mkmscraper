function videoIframe(_el){  
    var url=_el.val();      
    var holder=_el.parent().find(".video_holder");
    var border=_el.parent().find(".video-border");
    if(url.length>0){
        var regExp_youtube = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match_youtube = url.match(regExp_youtube);
        var regExp_vimeo = new RegExp('.*?(vimeo).*?(\\d+)',["i"]);
        var match_vimeo = regExp_vimeo.exec(url);
        var action="action=getEmbedCode";
        var _iframe='';
        if (match_youtube && match_youtube[7].length==11){
            // youtube
            var videoId=match_youtube[7];
            _iframe='<iframe width="420" height="315" src="//www.youtube.com/embed/'+videoId+'?rel=0" frameborder="0" allowfullscreen></iframe>';
        }else if(match_vimeo && match_vimeo[2].length>6){
            // vimeo
            var videoId=match_vimeo[2];
            _iframe='<iframe src="//player.vimeo.com/video/'+videoId+'" width="420" height="236" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        }   
        holder.html(_iframe);
        border.show();
    }
    else{
        holder.html("");
        border.hide();
    }
}

function updateAllMessageForms(){
    for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
    }
}

$(document).ready(function () {
    $(".language-select").click(function(e){
        e.preventDefault();
        $("#selectedlang").val($(this).attr("attr-lang"));
        updateAllMessageForms()
        $("#update-form").click();
    });

    $('input').icheck({
        checkboxClass: 'icheckbox_square-blue',
        increaseArea: '20%' // optional
    });


    $("#saveonly").click(function(e){
        e.preventDefault();
        $("#draft").val("1");
        updateAllMessageForms()
        $("form").submit();
    });

    $("#saveandpublish").click(function(e){
        e.preventDefault();
        $("#draft").val("0");
        updateAllMessageForms()
        $("form").submit();
    });

    $(".video_field").each(function(){
        videoIframe($(this));
    });

    $(".video_field").blur(function(){
        videoIframe($(this));
    });

    $(".colorpicker-input").colorpicker();
    
    $('.date-picker').datepicker({
        orientation: "bottom left"
    });
    //$('.time-picker').timepicker();
    $(".select2").select2();

    $(".colorbox").colorbox();

    $(".gallery-drag").sortable({ 
        cursorAt: { top: 0,left:0 },
        stop: function(){
            var i=1;
            $.each($(this).children("li"), function(index,ev){
                $(this).find(".gallery-position").val(i);
                i++;
            });
        }
    }); 
    $(".gallery-drag").disableSelection();

    $(".close-picture").click(function(e){
        e.preventDefault();
        $(this).parents(".form-group").find("input").val("");
        $(this).parents(".form-group").find("img").attr("src","");
        $(this).parents(".form-group").find(".picture-square").hide();    
        $(this).parents(".form-group").find("span").attr("data-title","No file selected");
        return false;
    });

    $(".close-file").click(function(e){
        e.preventDefault();
        $(this).parents(".form-group").find("input").val("");
        $(this).parents(".form-group").find(".file-square").hide();    
        $(this).parents(".form-group").find("span").attr("data-title","No file selected");
        return false;
    });

    $(".close-video").on("click",function(){
        $(this).parents(".video-border").hide();
        $(this).parents(".form-group").find("input").val("");
        $(this).parents(".video-border").find(".video_holder").html();
    });
    $('.pictureupload').fileupload({
        dataType: 'json',
        done: function (e, data) {
            if(data.result.error){
                $(this).parents(".form-group").find(".bar").css('width','0%');
                $(this).parents(".form-group").find(".progress").hide();
                bootbox.alert({title:"Error",message:data.result.error});
            }
            else{
                $(this).parents(".form-group").find("img").attr("src",data.result.image);
                $(this).parents(".form-group").find(".image-border").show();
                $(this).parents(".form-group").find("input[type=hidden]").val(data.result.name);
                $(this).parents(".form-group").find(".progress").hide();
                $(this).parents(".form-group").find(".bar").css('width','0%');
                $(this).parents(".form-group").find(".picture-square").show();
            }
        },
        progressall: function (e, data) {
            $(this).parents(".form-group").find(".progress").show();
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(this).parents(".form-group").find(".bar").css(
                'width',
                progress + '%'
            );
        }
    });

    $('.fileupload').fileupload({
        dataType: 'json',
        done: function (e, data){
            if(data.result.error){
                $(this).parents(".form-group").find(".bar").css('width','0%');
                $(this).parents(".form-group").find(".progress").hide();
                bootbox.alert({title:"Error",message:data.result.error});
            }
            else{
                console.log($(this));
                $(this).parents(".form-group").find(".file-upload").removeClass().addClass("file-upload icondiv "+data.result.extension);
                $(this).parents(".form-group").find("input[type=hidden]").val(data.result.name);
                $(this).parents(".form-group").find("span.file-name").attr("data-title",data.result.name);
                $(this).parents(".form-group").find(".progress").hide();
                $(this).parents(".form-group").find(".bar").css('width','0%');
                $(this).parents(".form-group").find(".inner").text(data.result.name);
                $(this).parents(".form-group").find(".file-square").show();
            }
        },
        progressall: function (e, data) {
            $(this).parents(".form-group").find(".progress").show();
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(this).parents(".form-group").find(".bar").css(
                'width',
                progress + '%'
            );
        }
    });
});