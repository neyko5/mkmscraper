<div class="form-group">
    <label  class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-9">
        <select id="{{$field['name']}}" name="{{$field['name']}}" class="width-80 select2" data-placeholder="{{\Lang::get("admin::templates.24")}} {{$field['singular']}}">
        	<option @if($item[$field['name']] == 0)selected @endif value="0">none</option>
            @foreach($field['values'] as $option)
                <option @if($item[$field['name']] == $option['value'])selected @endif value="{{$option['value']}}">{{$option['description']}} @if(isset($option['extra_description']))({{$option['extra_description']}}) @endif</option>
            @endforeach
        </select>
    </div>
</div>
