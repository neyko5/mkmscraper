@extends("admin::elements.main")

@section("content")
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            {!! \Form::open(array("method"=>"post", "url"=>"/admin/".$module->name."/edit","id"=>"main-form","role"=>"form")) !!}
                <div class="box-body">
                    @if($edit)<input type="hidden" name="id" value="{{$item->id}}">@endif
                    <input type="hidden" name="module" value="{{$module->name}}">

                    
                    @foreach($settings['fields'] as $field)
                        <div class="form-element">
                        @include("admin::form.".$field['type'],array('field'=>$field,'data'=>$item))
                        </div>
                    @endforeach
                    
                    <input type="hidden" id="draft" name="draft" value="0" />
                    <input type="hidden" id="return" name="return" value="0">
                    <input type="hidden" id="selectedlang" name="selectedlang" value="">
                </div>
                <div class="box-footer">
                    @if(in_array('saveandpublish', $settings['controls']))
                    <button type="submit" class="btn btn-yellow" name="submit" title="{{Lang::get('admin::templates.25')}}" value="saveandpublish" ><i class="fa fa-globe"></i> {{Lang::get('admin::templates.26')}}</button>
                    @endif

                    @if(in_array('draft', $settings['controls']))
                    <button type="submit" class="btn btn-primary" name="submit" title="{{Lang::get('admin::templates.27')}}" value="draft" ><i class="fa fa-copy"></i> {{Lang::get('admin::templates.28')}}</button>
                    @endif

                    @if(in_array('save', $settings['controls']))
                    <button type="submit" class="btn btn-primary" name="submit" title="{{Lang::get('admin::templates.25')}}" value="save" ><i class="fa fa-save"></i> {{Lang::get('admin::templates.29')}}</button>
                    @endif

                    @if(in_array('update', $settings['controls']))
                    <button type="submit" class="btn btn-success" name="submit" title="{{Lang::get('admin::templates.30')}}" value="update" id="update-form" ><i class="fa fa-reply-all"></i> {{Lang::get('admin::templates.31')}}</button>
                    @endif
                    <a href="/admin/{{$module->name}}" class="btn btn-danger"><i class="fa fa-mail-reply"></i> {{Lang::get('admin::templates.32')}}</a>
                </div>
            {!! \Form::close() !!}
        </div>
    </div>
</div>
@endsection
