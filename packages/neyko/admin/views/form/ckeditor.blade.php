@if(isset($field['lang'])&&$field['lang'])

<div class="form-group">
    <label class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-4">
        <div class="tabbable tabs-below">
            <div class="tab-content">
                @foreach(\Config::get("admin/admin.langs") as $lang)
                <div id="{{$field['name'].'_'.$lang}}" class="tab-pane @if($lang==\App::getLocale()) active @endif">
                    <textarea class="rtf" id="cke-{{$field['name']}}_{{$lang}}" type="text" name="{{$field['name']}}_{{$lang}}" class="col-xs-10 col-sm-5">{{$item->translate($lang)->$field['name']}}</textarea>
                    <span for="{{$field['name']}}_{{$lang}}" class="help-inline col-xs-12 col-sm-7">@if(isset($field['help'.'_'.$lang])){{$field['help'.'_'.$lang]}}@endif</span>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#cke-{{$field['name']."_".$lang}}').ckeditor();
                        });
                    </script>
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
    <label class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-9">
        <textarea class="rtf" id="cke-{{$field['name']}}" type="text" name="{{$field['name']}}" class="col-xs-10 col-sm-5">{{$item [$field['name']]}}</textarea>
        <span for="{{$field['name']}}" class="help-inline col-xs-12 col-sm-7">@if(isset($field['help'])){{$field['help']}}@endif</span>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        CKEDITOR.replace('cke-{{$field['name']}}');
    });
</script>
@endif