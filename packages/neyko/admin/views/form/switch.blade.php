<div class="form-group">
    <label  class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-9">
        <label>
            <input name="{{$field['name']}}" type="checkbox"  @if($item->$field['name']=="1")checked="checked"@endif>
            <span class="lbl"></span>
        </label>
    </div>
</div>