<div class="form-group">
    <label class="col-sm-3 right" for="{{$field['name']}}">{{$field['label']}}</label>
    <div class="col-sm-9">
        <div class="box">
            <div class="box-body table-responsive">
                <table id="table_report" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            @foreach($field['columns'] as $column)
                            <th>{{$column['title']}}</th>
                            @endforeach
                            <th>{{Lang::get('admin::templates.52')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($item->$field['name'] as $key=>$connection)
                        <tr>
                            @foreach($field['columns'] as $key=>$column)
                                <td>

                                @if(isset($column['type']))
                                    @if($column['type']=="text")
                                        {{$connection->$column['name']}}
                                    @elseif($column['type']=="datetime")
                                        {{date("d.m.Y H:i",strtotime($connection->$column['name']))}}
                                    @elseif($column['type']=="function")
                                        {{$connection->$column['name']()}}
                                    @endif
                                @else
                                    {{$connection->$column['name']}}
                                @endif

                                </td>
                            @endforeach
                            <td class="td-actions">
                                @if(in_array('edit',$field['options']))
                                <a href="/admin/{{$field['module']}}/edit/{{$connection->id}}" class="btn btn-xs btn-primary"><i class="icon-edit bigger-120"></i> {{Lang::get('admin::templates.39')}}</a>
                                @endif
                        
                                @if(in_array('delete', $field['options']))
                                <button data-target="#delete-{{$connection->id}}" data-toggle="modal" class="btn btn-xs btn-danger"><i class="icon-trash bigger-120"></i></i> {{Lang::get('admin::templates.41')}}</button>
                                <div id="delete-{{$connection->id}}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button data-dismiss="modal" class="close" type="button">×</button>
                                                <h4>{{Lang::get('admin::templates.41')}} <span style="text-transform: lowercase;">{{$field['module']}}</span></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{Lang::get('admin::templates.42')}} <span style="text-transform: lowercase;">{{$field['module']}}</span> <b>{{$connection[$module->main]}}</b>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="/admin/{{$field['module']}}/delete/{{$connection->id}}" class="btn btn-success">{{Lang::get('admin::templates.41')}}</a>
                                                <button data-dismiss="modal" class="btn btn-danger" type="button">{{Lang::get('admin::templates.32')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(isset($field['functions']))
                                @foreach($field['functions'] as $function)
                                <button data-target="#{{$function['name']}}-{{$connection->id}}" data-toggle="modal" class="btn btn-xs btn-success">{{$function['label']}}</button>
                                <div id="{{$function['name']}}-{{$connection->id}}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button data-dismiss="modal" class="close" type="button">×</button>
                                                <h4>{{$function['label']}} <span style="text-transform: lowercase;">{{$field['module']}}</span></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{$function['label']}} <span style="text-transform: lowercase;">{{$field['module']}}</span> <b>{{$connection->$field['main']}}</b>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="/admin/{{$field['module']}}/function/{{$function['name']}}/{{$connection->id}}" class="btn btn-success">{{$function['label']}}</a>
                                                <button data-dismiss="modal" class="btn btn-danger" type="button">{{Lang::get('admin::templates.32')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        var oTable1 = $('#table_inner').dataTable({
            "language": {
                "url": "/neyko/admin/js/plugins/datatables/{{\Config::get('app.locale')}}.lang"
            }
        });
    });
</script>
