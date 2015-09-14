<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-9">
        <input  type="text" value="{{$item[$field['name']]}}" name="{{$field['name']}}" id="{{$field['name']}}" class="video_field col-xs-10 col-sm-5" />
        <span for="{{$field['name']}}" class="help-inline col-xs-12 col-sm-7">@if(isset($field['help'])) {{$field['help']}} @endif</span>
        <div class="video-container">
            <div class="video-border" @if(!empty($item[$field['name']])) style="display:block" @endif >
                <div class="close-button close-video"></div>
                <div class="video_holder"></div>
            </div>
        </div>
    </div>
</div>