<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-3">
        <div class="ace-file-input">
            <input type="file" class="filegalleryupload" id="{{$field['name']}}-upload" name="ajax_file_upload" data-url="/admin/ajax/uploadfile"  multiple>
            <label data-title="Choose" class="file-label" for="{{$field['name']}}-upload">
                <span class="file-name" data-title="Add files to gallery...">
                    <i class="icon-upload-alt"></i>
                </span>
            </label>
            <a class="remove" href="#">
                <i class="icon-remove"></i>
            </a>
        </div>
        <input id="{{$field['name']}}-gcount" class="gcount" type="hidden" name="{{$field['name']}}-gcount" data-name="{{$field['name']}}" value="{{sizeof($field['files'])}}" />
        <div class="progress file-progress">
            <div style="width: 0%;" class="bar"></div>
        </div>
        <div class="gallery-container">
            <ul class="gallery-drag ace-thumbnails" >
                @foreach($field['files'] as $key=>$file)
                <li>
                    <a href="/files/{{$field['path']}}/{{$item->id}}/{{$field['subpath']}}/{{$file->file}}" title="{{$file->file}}" target="_blank">
                        <div class="file-upload icondiv @if($file->file) {{pathinfo($file->file, PATHINFO_EXTENSION)}} @endif"></div>
                        <div class="text">
                            <div class="inner">{{$item[$field['name']]}}</div>
                        </div>
                        <input type='hidden' name='{{$field['name']}}-{{$key}}' value='{{$file->file}}'>
                        <input type='hidden' name='{{$field['name']}}-id-{{$key}}' value='{{$file->id}}'>
                        <input type="hidden" name="{{$field['name']}}-fresh-{{$key}}" value="0">
                        <input type="hidden" class="gallery-position" name="{{$field['name']}}-position-{{$key}}" value="{{$file->position}}">
                    </a>
                    @if($field['extrafields'])
                    <div class="tools">
                        <a href="#" data-toggle="modal" data-target="#modal-{{$field['name']}}-{{$key}}">
                            <i class="icon-pencil"></i>
                        </a>
                        
                        <div class="modal fade" id="modal-{{$field['name']}}-{{$key}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">{{Lang::get("admin::templates.65")}} <b>{{$file->file}}</b></h4>
                              </div>
                              <div class="modal-body">
                                <div class="file-upload icondiv @if($file->file) {{pathinfo($file->file, PATHINFO_EXTENSION)}} @endif"></div>
                                @foreach($field['extrafields'] as $extrakey=>$extrafield)
                                    @if($extrafield['type']=='text')
                                        @if(isset($extrafield['lang'])&&$extrafield['lang'])
                                        @foreach(\Config::get("admin/admin.langs") as $lang)
                                        <div class="form-group clearfix" style="margin-top: 10px;">
                                            <label class="col-sm-3 control-label no-padding-right">{{$extrafield['label']}} [{{strtoupper($lang)}}]</label>
                                            <div class="col-sm-9" style="text-align: left;">
                                                <input type="text" name="{{$field['name']}}-extra-{{$extrakey}}-{{$key}}_{{$lang}}" value="{{$file->translate($lang)->$extrakey}}">
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="form-group clearfix" style="margin-top: 10px;">
                                            <label class="col-sm-3 control-label no-padding-right">{{$extrafield['label']}}</label>
                                            <div class="col-sm-9" style="text-align: left;">
                                                <input type="text" name="{{$field['name']}}-extra-{{$extrakey}}-{{$key}}" value="{{$file->$extrakey}}">
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
                                                <textarea name="{{$field['name']}}-extra-{{$extrakey}}-{{$key}}_{{$lang}}" class="autosize-transition" style="resize:vertical;">{{$file->translate($lang)->$extrakey}}</textarea> 
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="form-group clearfix" style="margin-top: 10px;">
                                            <label class="col-sm-3 control-label no-padding-right">{{$extrafield['label']}}</label>
                                            <div class="col-sm-9" style="text-align: left; ">
                                                <textarea name="{{$field['name']}}-extra-{{$extrakey}}-{{$key}}" class="autosize-transition" style="resize:vertical;">{{$file->$extrakey}}</textarea> 
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
                            <i class="icon-remove red close-gallery"></i>
                        </a>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="forjs-{{$field['name']}}" style="display: none;">
    <div class="tools" >
        @if($field['extrafields'])
        <a href="#" data-toggle="modal" data-target="#modal-##num##">
            <i class="icon-pencil"></i>
        </a>
        <div class="modal fade" id="modal-##num##" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{Lang::get("admin::templates.21")}} <b class="filename"></b></h4>
              </div>
              <div class="modal-body">
                    <div class="file-upload icondiv"></div>
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
            <i class="icon-remove red close-gallery"></i>
        </a>
    </div>
</div>


<script>
$(document).ready(function(){
    $('.filegalleryupload').fileupload({
        dataType: 'json',
        sequentialUploads:true,
        done: function (e, data) {
            filecount=parseInt($("input#{{$field['name']}}-gcount").val())+1;
            var fieldname=$(this).parents(".form-group").find("input.gcount").val(filecount).attr("data-name");
            var controls = $('.forjs-{{$field['name']}}').html().replace(/##num##/gi, filecount);
            $(this).parents(".form-group").find("ul").append('<li><a href="'+data.result.file+'" title="'+data.result.name+'" target="_blank">'+
                        '<div class="file-upload icondiv '+data.result.extension+'"></div>'+
                        '<div class="text"><div class="inner">'+data.result.name+'</div></div>'+
                        '<input type="hidden" name="'+fieldname+'-'+filecount+'" value="'+data.result.name+'">'+
                        '<input type="hidden" name="'+fieldname+'-fresh-'+filecount+'" value="true">'+
                        '<input type="hidden" class="gallery-position" name="'+fieldname+'-position-'+filecount+'" value="'+filecount+'">'+
                        '<input type="hidden" name="'+fieldname+'-title-'+filecount+'" value="'+fieldname+'-'+filecount+'"></a></a>'+controls +'</li>');

            $(this).parents(".form-group").find(".icondiv").addClass(data.result.extension);
            $(this).parents(".form-group").find(".filename").text(data.result.name);
            
            $(".close-gallery").on("click",function(){
                $(this).parents("li").remove(); 
            });
            $(".draggable").draggable();
            $(this).parents(".form-group").find(".progress").hide();
            $(this).parents(".form-group").find(".bar").css('width','0%');
            $('#{{$field['name']}}-gcount').val(filecount);
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