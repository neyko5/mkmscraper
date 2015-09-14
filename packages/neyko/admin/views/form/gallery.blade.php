<div class="form-group">
    <label class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-3">
        <div class="ace-file-input">
            <input type="file" class="galleryupload" id="{{$field['name']}}-upload" name="ajax_picture_upload" data-url="/admin/ajax/uploadpicture"  multiple>
            <label data-title="Choose" class="file-label" for="{{$field['name']}}-upload">
                <span class="btn btn-primary" data-title="{{$item[$field['name']]}}">
                    <i class="fa fa-upload"></i> Upload picture
                </span>
            </label>
            <a class="remove" href="#">
                <i class="icon-remove"></i>
            </a>
        </div>
        <input id="{{$field['name']}}-gcount" class="gcount" type="hidden" name="{{$field['name']}}-gcount" data-name="{{$field['name']}}" value="{{sizeof($field['pictures'])}}" />
        <div class="progress file-progress">
            <div style="width: 0%;" class="bar"></div>
        </div>
        <div class="gallery-container">
            <ul class="gallery-drag ace-thumbnails" >
                @foreach($field['pictures'] as $key=>$picture)
                <li>
                    <a href="/files/@if(isset($field['prepath'])){{$field['prepath']}}/{{$item->$field['preid']}}/@endif{{$field['path']}}/@if(isset($field['subpath'])){{$item->id}}/{{$field['subpath']}}/@endif{{$field['thumb']}}/{{$picture->picture}}" title="{{$field['name']}}" data-rel="colorbox" class="cboxElement">
                        <img alt="100x100" src="/files/@if(isset($field['prepath'])){{$field['prepath']}}/{{$item->$field['preid']}}/@endif{{$field['path']}}/@if(isset($field['subpath'])){{$item->id}}/{{$field['subpath']}}/@endif{{$field['thumb']}}/{{$picture->picture}}" class='image-upload'>
                        <input type='hidden' name='{{$field['name']}}-{{$key}}' value='{{$picture->picture}}'>
                        <input type='hidden' name='{{$field['name']}}-id-{{$key}}' value='{{$picture->id}}'>
                        <input type="hidden" name="{{$field['name']}}-fresh-{{$key}}" value="0">
                        <input type="hidden" class="gallery-position" name="{{$field['name']}}-position-{{$key}}" value="{{$picture->position}}">
                    </a>
                    @if(isset($field['extrafields']))
                    <div class="tools">
                        <a href="#" data-toggle="modal" data-target="#modal-{{$field['name']}}-{{$key}}">
                            <i class="fa fa-pencil"></i>
                        </a>
                        
                        <div class="modal fade" id="modal-{{$field['name']}}-{{$key}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">{{Lang::get("admin::templates.21")}} <b>{{$picture->picture}}</b></h4>
                              </div>
                              <div class="modal-body">
                                <img alt="100x100" src="/files/{{$field['path']}}/{{$item->id}}/{{$field['subpath']}}/{{$field['thumb']}}/{{$picture->picture}}" class='image-upload' style="margin-bottom: 10px;">
                                @foreach($field['extrafields'] as $extrakey=>$extrafield)
                                    @if($extrafield['type']=='text')
                                        @if(isset($extrafield['lang'])&&$extrafield['lang'])
                                        @foreach(\Config::get("admin/admin.langs") as $lang)
                                        <div class="form-group clearfix" style="margin-top: 10px;">
                                            <label class="col-sm-3 control-label no-padding-right">{{$extrafield['label']}} [{{strtoupper($lang)}}]</label>
                                            <div class="col-sm-9" style="text-align: left;">
                                                <input type="text" name="{{$field['name']}}-extra-{{$extrakey}}-{{$key}}_{{$lang}}" value="{{$picture->translate($lang)->$extrakey}}">
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="form-group clearfix" style="margin-top: 10px;">
                                            <label class="col-sm-3 control-label no-padding-right">{{$extrafield['label']}}</label>
                                            <div class="col-sm-9" style="text-align: left;">
                                                <input type="text" name="{{$field['name']}}-extra-{{$extrakey}}-{{$key}}" value="{{$picture->$extrakey}}">
                                            </div>
                                        </div>
                                        @endif
                                    @endif

                                    @if($extrafield['type']=='textarea')
                                        @if(isset($extrafield['lang'])&&$extrafield['lang'])
                                        @foreach(\Config::get("admin/admin.langs") as $lang)
                                        <div class="form-group clearfix" style="margin-top: 10px;">
                                            <label class="col-sm-3 control-label no-padding-right">{{$extrafield['label']}} [{{strtoupper($lang)}}]</label>
                                            <div class="col-sm-9" style="text-align: left; ">
                                                <textarea name="{{$field['name']}}-extra-{{$extrakey}}-{{$key}}_{{$lang}}" class="autosize-transition" style="resize:vertical;">{{$picture->translate($lang)->$extrakey}}</textarea> 
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="form-group clearfix" style="margin-top: 10px;">
                                            <label class="col-sm-3 control-label no-padding-right">{{$extrafield['label']}}</label>
                                            <div class="col-sm-9" style="text-align: left; ">
                                                <textarea name="{{$field['name']}}-extra-{{$extrakey}}-{{$key}}" class="autosize-transition" style="resize:vertical;">{{$picture->$extrakey}}</textarea> 
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                @endforeach
                              </div>
                              <div class="modal-footer">
                                    <button data-dismiss="modal" type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> {{Lang::get("admin::templates.22")}}</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <a href="#">
                            <i class="fa fa-trash red close-gallery"></i>
                        </a>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="forjs" style="display: none;">
    <div class="tools" >
        @if(isset($field['extrafields']))
        <a href="#" data-toggle="modal" data-target="#modal-##num##">
            <i class="fa fa-pencil"></i>
        </a>
        
        <div class="modal fade" id="modal-##num##" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{Lang::get("admin::templates.21")}} <b class="filename"></b></h4>
              </div>
              <div class="modal-body">
                    <img alt="100x100" src="" class='image-upload thumb-modal' style="margin-bottom: 10px;">
                    @foreach($field['extrafields'] as $extrakey=>$extrafield)
                        @if($extrafield['type']=='text')
                            @if(isset($extrafield['lang'])&&$extrafield['lang'])
                            @foreach(\Config::get("admin/admin.langs") as $lang)
                            <div class="form-group clearfix" style="margin-top: 10px;">
                                <label class="col-sm-3 control-label no-padding-right">{{$extrafield['label']}} [{{strtoupper($lang)}}]</label>
                                <div class="col-sm-9" style="text-align: left;">
                                    <input type="text" name="{{$field['name']}}-extra-{{$extrakey}}-##num##_{{$lang}}" value="">
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="form-group clearfix" style="margin-top: 10px;">
                                <label class="col-sm-3 control-label no-padding-right">{{$extrafield['label']}}</label>
                                <div class="col-sm-9" style="text-align: left;">
                                    <input type="text" name="{{$field['name']}}-extra-{{$extrakey}}-##num##" value="">
                                </div>
                            </div>
                            @endif
                        @endif

                        @if($extrafield['type']=='textarea')
                            @if(isset($extrafield['lang'])&&$extrafield['lang'])
                            @foreach(\Config::get("admin/admin.langs") as $lang)
                            <div class="form-group clearfix" style="margin-top: 10px;">
                                <label class="col-sm-3 control-label no-padding-right">{{$extrafield['label']}} [{{strtoupper($lang)}}]</label>
                                <div class="col-sm-9" style="text-align: left; ">
                                    <textarea name="{{$field['name']}}-extra-{{$extrakey}}-##num##_{{$lang}}" class="autosize-transition" style="resize:vertical;"></textarea> 
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="form-group clearfix" style="margin-top: 10px;">
                                <label class="col-sm-3 control-label no-padding-right">{{$extrafield['label']}}</label>
                                <div class="col-sm-9" style="text-align: left; ">
                                    <textarea name="{{$field['name']}}-extra-{{$extrakey}}-##num##" class="autosize-transition" style="resize:vertical;"></textarea> 
                                </div>
                            </div>
                            @endif
                        @endif
                    @endforeach
              </div>
              <div class="modal-footer">
                    <button data-dismiss="modal" type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> {{Lang::get("admin::templates.22")}}</button>
              </div>
            </div>
          </div>
        </div>
        @endif
        <a href="#">
            <i class="fa fa-trash red close-gallery"></i>
        </a>
    </div>
</div>
<script>
$(document).ready(function(){
    $('.galleryupload').fileupload({
        dataType: 'json',
        sequentialUploads:true,
        done: function (e, data) {
            piccount=parseInt($("input#{{$field['name']}}-gcount").val())+1;
            var fieldname=$(this).parents(".form-group").find("input.gcount").val(piccount).attr("data-name");
            var controls = $('.forjs').html().replace(/##num##/gi, piccount);
            $(this).parents(".form-group").find("ul").append('<li><a href="'+data.result.image+'" title="title" data-rel="colorbox" class="cboxElement">'+
                    '<img alt="100x100" src="'+data.result.image+'" class="image-upload">'+
                    '<input type="hidden" name="'+fieldname+'-'+piccount+'" value="'+data.result.name+'">'+
                    '<input type="hidden" name="'+fieldname+'-fresh-'+piccount+'" value="true">'+
                    '<input type="hidden" class="gallery-position" name="'+fieldname+'-position-'+piccount+'" value="'+piccount+'">'+
                    '<input type="hidden" name="'+fieldname+'-title-'+piccount+'" value="'+fieldname+'-'+piccount+'"></a>'+
                    controls +
            '</li>');
            $(this).parents(".form-group").find(".thumb-modal").attr("src",data.result.image);
            $(this).parents(".form-group").find(".filename").text(data.result.name);
            
            $(".close-gallery").on("click",function(){
                $(this).parents("li").remove(); 
            });
            $(".draggable").draggable();
            $(this).parents(".form-group").find(".progress").hide();
            $(this).parents(".form-group").find(".bar").css('width','0%');
            $('#{{$field['name']}}-gcount').val(piccount);
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
    $(".close-gallery").on("click",function(){
        $(this).parents("li").remove(); 
        var oldval = parseInt($('#{{$field['name']}}-gcount').val());
        $('#{{$field['name']}}-gcount').val(oldval - 1);
        return false;
    });
});
</script>