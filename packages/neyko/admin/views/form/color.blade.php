<div class="form-group">
    <label  class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-3">
        <div class="input-group colorpicker-input">
            <input  type="text" value="{{$item->$field['name']}}" name="{{$field['name']}}" id="{{$field['name']}}" class="form-control" />
            <div class="input-group-addon">
                <i></i>
            </div>
        </div>
    </div>
</div>