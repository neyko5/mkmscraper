<div class="form-group">
    <label class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-9">
        @foreach($field['values'] as $option)
        <div class="check-div">
            <label>
                <input type="checkbox" class="minimal" name="{{$field['name']}}[]" @if(isset($option['checked']))  checked="checked" @endif value="{{$option['value']}}" >
                <span class="lbl"> {{$option['description']}}</span>
            </label>
        </div>
        @endforeach
    </div>
</div>
