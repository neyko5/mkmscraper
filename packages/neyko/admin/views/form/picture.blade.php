<div class="form-group">
    <label  class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-9">
        <div class="ace-file-input">
            <input type="file" class="pictureupload" id="{{$field['name']}}-upload" name="ajax_picture_upload" data-url="/admin/ajax/uploadpicture">
            <label for="{{$field['name']}}-upload">
                <span class="btn btn-primary" data-title="{{$item[$field['name']]}}">
                    <i class="fa fa-upload"></i> Upload picture
                </span>
            </label>
        </div>
        <input type="hidden" name="{{$field['name']}}" value="{{$item[$field['name']]}}">
        <input type="hidden" name="{{$field['name']}}-fresh" value="">
        <div class="progress file-progress">
            <div style="width: 0%;" class="bar"></div>
        </div>
         <div class="gallery-container">
            <ul class="ace-thumbnails" >
                @if($item[$field['name']])
                <li class="picture-square">
                    <a href="/files/@if(isset($field['prepath'])){{$field['prepath']}}/{{$item->$field['preid']}}/@endif{{$field['path']}}/@if(isset($field['subpath'])){{$item->id}}/{{$field['subpath']}}/@endif{{$field['thumb']}}/{{$item[$field['name']]}}" title="{{$field['name']}}" class="colorbox">
                        <img alt="100x100" src="/files/@if(isset($field['prepath'])){{$field['prepath']}}/{{$item->$field['preid']}}/@endif{{$field['path']}}/@if(isset($field['subpath'])){{$item->id}}/{{$field['subpath']}}/@endif{{$field['thumb']}}/{{$item[$field['name']]}}" class='image-upload'>
                    </a>
                    <div class="tools">
                        <a href="#">
                            <i class="fa fa-times red close-picture"></i>
                        </a>
                    </div>
                </li>
                @else
                <li class="picture-square" style="display:none;">
                    <a href="" title="{{$field['name']}}" data-rel="colorbox" class="colorbox">
                        <img alt="100x100" src="" class='image-upload'>
                    </a>
                    <div class="tools">
                        <a href="#">
                            <i class="fa fa-times red close-picture"></i>
                        </a>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
