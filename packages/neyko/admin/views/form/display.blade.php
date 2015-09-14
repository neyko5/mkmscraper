<div class="form-group">
	<label  class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-9"><p class="display-p">@if(isset($field['function'])) {{$item->$field['function']()}} @else {{$item->$field['name']()}} @endif</p></div>
</div>