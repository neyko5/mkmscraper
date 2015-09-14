<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="input-group">
            <input class="form-control " id="{{$field['name']}}" name="{{$field['name']}}" value="{{$item[$field['name']]}}" type="text" data-date-format="YYYY-MM-DD hh:mm:ss" />
            <span class="input-group-addon">
                <i class="icon-calendar bigger-110"></i>
            </span> 
        </div>      
    </div>
</div>
<script type="text/javascript"> 
    $(document).ready(function(){
        $('#{{$field['name']}}').datetimepicker({
        	format:'Y-d-m H:i:s'
        });
    });
</script>

