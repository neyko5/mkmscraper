<div class="form-group">
    <label class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="input-group">
            <input class="form-control date-picker " name="{{$field['name']}}" value="@if($item[$field['name']]) {{$item[$field['name']]}} @endif" type="text" data-date-format="yyyy-mm-dd" />
            <span class="input-group-addon">
                <i class="fa fa-calendar bigger-110"></i>
            </span>
        </div>
    </div>
</div>
