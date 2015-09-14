

<h3 class="header smaller lighter blue">
    {{trans('admin::templates.66')}}
    <small>{{trans('admin::templates.67')}}</small>
</h3>

@if($item->id!=$administrator->id)
    @foreach(\Neyko\Admin\Model\AdminModule::orderBy("label","ASC")->get() as $adminmodule)
    <div class="form-group">
        <input @if($item->hasAccessToModule($adminmodule->id))checked="checked" @endif type="checkbox"  name="admin_modules[]" class="minimal" value="{{$adminmodule->id}}" />
        <span class="lbl"> {{$adminmodule->label}}</span>
    </div>
    @endforeach
@endif
