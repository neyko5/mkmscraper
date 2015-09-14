<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-3">
        <div class="ace-file-input">
            <input type="file" class="fileupload" id="{{$field['name']}}-upload" name="ajax_file_upload" data-url="/admin/ajax/uploadfile">
            <label data-title="Choose" class="file-label" for="{{$field['name']}}-upload">
                <span class="file-name" data-title="{{$item[$field['name']]}}">
                    <i class="icon-upload-alt"></i>
                </span>
            </label>
            <a class="remove" href="#">
                <i class="icon-remove"></i>
            </a>
        </div>
        <input type="hidden" name="{{$field['name']}}" value="{{$item[$field['name']]}}">
        <input type="hidden" name="{{$field['name']}}-fresh" value="">
        <div class="progress file-progress">
            <div style="width: 0%;" class="bar"></div>
        </div>
        <div class="gallery-container">
            <ul class="ace-thumbnails" >
                <li class="file-square" @if(empty($item[$field['name']]))style="display:none;" @endif>
                    <a href="/files/{{$field['path']}}/{{$item->id}}/{{$field['subpath']}}/{{$item[$field['name']]}}" title="{{$field['name']}}">
                        <div class="file-upload icondiv @if($item[$field['name']]) {{pathinfo($item[$field['name']], PATHINFO_EXTENSION)}} @endif"></div>
                        <div class="text">
                            <div class="inner">{{$item[$field['name']]}}</div>
                        </div>
                    </a>
                    <div class="tools">
                        <a href="#">
                            <i class="icon-remove red close-file"></i>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
