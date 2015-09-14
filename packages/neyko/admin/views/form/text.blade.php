@if(isset($field['lang'])&&$field['lang'])
<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-4">
        <div class="tabbable tabs-below">
            <div class="tab-content">
                @foreach(\Config::get("admin/admin.langs") as $lang)
                <div id="{{$field['name'].'_'.$lang}}" class="tab-pane @if($lang==\App::getLocale()) active @endif">
                    <input  type="text" value="{{$item->translate($lang)->$field['name']}}" name="{{$field['name']}}_{{$lang}}" id="{{$field['name']}}_{{$lang}}" style="width:100%;"/>
                </div>
                @endforeach
            </div>

            <ul class="nav nav-tabs" id="myTab2">
                 @foreach(\Config::get("admin/admin.langs") as $lang)
                 <li class="@if($lang==\App::getLocale()) active @endif">
                     <a data-toggle="tab" href="#{{$field['name'].'_'.$lang}}" >{{strtoupper($lang)}}</a>
                 </li>
                 @endforeach
            </ul>
        </div>
    </div>
</div>
@else
<div class="form-group">
	<label  class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-9">
        <input  type="text" value="{{$item->$field['name']}}" name="{{$field['name']}}" id="{{$field['name']}}" class="form-control"/>
    </div>
</div>
@endif