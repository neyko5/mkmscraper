
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-9">
        <input type="text" value="{% if input.value is defined %}{{input.value}}{% endif %}" name="{{input.name}}" id="{{input.name}}" class="col-xs-10 col-sm-5 map-input"/>
        <span for="{{input.name}}" class="help-inline col-xs-12 col-sm-7">{% if input.help is defined %}{{input.help}}{% endif %}</span>
        <iframe src="#" width="100%" height="450" frameborder="0" style="border:0; display:none;"></iframe>
    </div>
</div>

<script>
$(function() {
	$('.map-input').focusout(function() {
		var val = $(this).val();
		src = $(val).attr('src');
		if (src && src != '') {
			$(this).siblings('iframe').attr('src', src).css('display', 'block');
			$(this).val(src);
		}
	});
	var src = $('.map-input').val();
	if (src && src != '') {
		$('.map-input').siblings('iframe').attr('src', src).css('display', 'block');
	}
});
</script>
