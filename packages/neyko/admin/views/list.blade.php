@extends("admin::elements.main")

@section("content")

<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{$module->label}} {{Lang::get('admin::templates.38')}}</h3>
        @if(isset($add))
        <a href="/admin/{{$module->name}}/new" class="add btn btn-primary" style="float:right;">
            <i class="fa fa-plus"></i>
            {{Lang::get("admin::templates.19")}} {{$module->singular}}
        </a>
        @endif                                    
    </div>
    @if(isset($settings['filters']))
    <div class="col-md-4">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Filters</h3>
            </div>
            <div class="box-body">
                @foreach($settings['filters'] as $key=>$filter)
                <div class="form-group">
                    <label for="{{$key}}">{{$filter['title']}}: </label>
                    @if($filter['type']=="select")
                    @if($model=$filter['model'])
                    <select id="{{$key}}" class="form-control">
                        <option value="0">No {{$filter['title']}}</option>
                        @foreach($model::all() as $option)
                        <option value="{{$option->$filter['field']}}">{{$option->$filter['field']}}</option>
                        @endforeach
                    </select>
                    @endif
                    @elseif($filter['type']=="minimum")
                        <input type="text" id="{{$key}}" class="form-control" />
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="box-body table-responsive">
        <table id="table_report" class="table table-bordered table-hover">

            <thead>
                <tr>
                    @foreach($settings['fields'] as $field)
                    <th>{{$field['title']}}</th>
                    @endforeach
                    <th>{{Lang::get('admin::templates.52')}}</th>
                </tr>
            </thead>
            <tbody>
                @if($data->count())
                @foreach($data as $row)
                <tr @if (isset($settings['colors']))
                    @foreach($settings['colors'] as $color)
                    @if($color['value']==$row->$color['field'])
                        style="background-color:{{$color['color']}}; @if(isset($color['dark'])) color:white; @endif "
                    @endif
                    @endforeach
                    @endif
                >
                    @foreach($settings['fields'] as $key=>$field)
                        <td @if(isset($field['type']) && $field['type']=="switch") data-order="{{$row[$key]}}" @endif>
                        @if(isset($field['type']))
                            @if($field['type']=="label")
                                <span class="label label-sm">{{$row[$key]}}</span>
                            @elseif($field['type']=="picture")
                                @if(!empty($row[$key]))
                                <img src="/files/{{$field['path']}}/{{$row['id']}}@if(isset($field['subpath']))/{{$field['subpath']}}@endif/thumb/{{$row[$key]}}" class="small-list" />
                                @endif

                            @elseif($field['type']=="desc")
                                {{$row[$key]}}
                            @elseif($field['type']=="datetime")
                                {{date("d.m.Y H:i",strtotime($row->$key))}}

                            @elseif($field['type']=="link")
                                <a href="{{sprintf($field['string'],$row[$key])}}" target="_blank">Link</a>
                            @elseif($field['type']=="linkfunction")
                                <a href="{{sprintf($field['string'],$row->$key())}}" target="_blank">Link</a>
                            @elseif($field['type']=="function")
                                {{$row->$key()}}
                            @elseif($field['type']=="switch")
                                <input name="{{$key}}" data-module="{{$module->name}}" data-id="{{$row->id}}" class="ajax-checkbox" type="checkbox" @if($row[$key]=="1") checked="checked" @endif />
                            @endif
                        @else
                            {{$row->$key}}
                        @endif
                        </td>
                    @endforeach
                    <td class="td-actions">
                        @if(in_array('edit',$settings['options']))
                        <a href="/admin/{{$module->name}}/edit/{{$row['id']}}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> {{Lang::get('admin::templates.39')}}</a>
                        @endif

                        @if(in_array('copy',$settings['options']))
                        <a href="/admin/{{$module->name}}/edit/{{$row['id']}}?copy=1" class="btn btn-xs btn-success"><i class="fa fa-copy"></i> {{Lang::get('admin::templates.40')}}</a>
                        @endif

                        @if(in_array('login', $settings['options']))
                        <a href="/admin/{{$module->name}}/loginas/{{$row['id']}}" class="btn btn-xs btn-primary"><i class="fa fa-login"></i> {{Lang::get('admin::templates.63')}}</a>
                        @endif

                        @if(isset($settings['links']))
                        @foreach($settings['links'] as $link)
                        <a href="{{$row->$link['function']()}}" class="btn btn-xs btn-success"><i class="fa {{$link['icon']}}"></i> {{$link['label']}}</a>
                        @endforeach
                        @endif

                        @if(isset($settings['functions']))
                        @foreach($settings['functions'] as $function)
                        <button data-target="#{{$function['name']}}-{{$row->id}}" data-toggle="modal" class="btn btn-xs btn-success"><i class="fa {{$function['icon']}}"></i> {{$function['label']}}</button>
                        <div id="{{$function['name']}}-{{$row->id}}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button data-dismiss="modal" class="close" type="button">×</button>
                                        <h4>{{$function['label']}} <span style="text-transform: lowercase;">{{$module['name']}}</span></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{$function['label']}} <span style="text-transform: lowercase;">{{$module['name']}}</span> <b>{{$row->$module['main']}}</b>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="/admin/{{$module['name']}}/function/{{$function['name']}}/{{$row->id}}" class="btn btn-success"><i class="fa {{$function['icon']}}"></i> {{$function['label']}}</a>
                                        <button data-dismiss="modal" class="btn btn-danger" type="button">{{Lang::get('admin::templates.32')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        @if(in_array('delete', $settings['options']))
                        <button data-target="#delete-{{$row->id}}" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></i> {{Lang::get('admin::templates.41')}}</button>
                        <div id="delete-{{$row->id}}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button data-dismiss="modal" class="close" type="button">×</button>
                                        <h4>{{Lang::get('admin::templates.41')}} <span style="text-transform: lowercase;">{{$module->singular}}</span></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{Lang::get('admin::templates.42')}} <span style="text-transform: lowercase;">{{$module->singular}}</span> <b>{{$row}}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="/admin/{{$module->name}}/delete/{{$row->id}}" class="btn btn-danger"><i class="fa fa-trash fa-white"></i> {{Lang::get('admin::templates.41')}}</a>
                                        <button data-dismiss="modal" class="btn btn-primary" type="button"><i class="fa fa-remove fa-white"></i> {{Lang::get('admin::templates.32')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(in_array('send', $settings['options']))
                        <button data-target="#send-{{$row['id']}}" data-toggle="modal" class="btn btn-action"><i class="fa fa-envelope bigger-120"></i></i> {{Lang::get('admin::templates.43')}}</button>
                        <div id="send-{{$row['id']}}" class="modal hide">
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">×</button>
                                <h3>{{Lang::get('admin::templates.43')}}: {{$module->label}}</h3>
                            </div>
                            <div class="modal-body">
                                <p>{{Lang::get('admin::templates.44')}} {{$module->label}} <b>{{$row[1]}}</b>?</p>
                                <form method="post" action="/admin/post/send">
                                    <input type="hidden" name="id" value="{{$row['id']}}">
                                    <input type="hidden" name="module" value="{{$module->name}}">
                                    <button type="submit" class="btn btn-action"><i class="fa-envelope icon-white"></i>  {{Lang::get('admin::templates.45')}}</button>
                                    <button data-dismiss="modal" class="btn btn-primary" type="button"><i class="fa-remove icon-white"></i> {{Lang::get('admin::templates.32')}}</button>
                                </form>
                            </div>
                        </div>
                        @endif


                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('input').icheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '20%' // optional
        });


        var oTable1 = $('#table_report').DataTable({
            @if(isset($settings['order']))
            "order": [
            @foreach($settings['order'] as $order)
            [{{$order['column']}} , "{{$order['direction']}}" ],
            @endforeach
            ]
            @else
            "order": [[ 0, "desc" ]]
            @endif
        });

        $(".ajax-checkbox").change(function(){
            var value=$(this).is(":checked")?1:0;
            var field=$(this).attr("name");
            var module=$(this).attr("data-module");
            var id=$(this).attr("data-id");
            $.ajax({
                url: '/admin/post/switch',
                type: 'POST',
                dataType:"json",
                data:{
                    "value":value,
                    "id":id,
                    "field":field,
                    "module":module,
                    "_token":"{{csrf_token()}}"
                },
                success: function(data) {

                }
            });
        });

        @if(isset($settings['filters']))
        @foreach($settings['filters'] as $key=>$filter)
        @if($filter['type']=="select")
        $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var filter = $('#{{$key}}').val();
                    var field = data[{{$filter['column']}}]; // use data for the age column
                    if (( filter==field)||(filter=="0") ){
                        return true;
                    }
                    return false;
                }
        );
        $('#{{$key}}').change( function() {
            oTable1.draw();
        });
        @elseif($filter['type']=="minimum")
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var filter = parseInt($('#{{$key}}').val());
                var field = parseInt(data[{{$filter['column']}}]); // use data for the age column

                if ( ( isNaN( filter )) || ( filter <= field ))
                {
                    return true;
                }
                return false;
            }
        );
        $('#{{$key}}').keyup( function() {
            oTable1.draw();
        } );
        @endif
        @endforeach
        @endif



    });
</script>
@endsection