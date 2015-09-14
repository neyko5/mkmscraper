<ul class="sidebar-menu">
    @foreach($administrator->modules as $mod)
    @if($mod->submodules->count()>0)
    <li class="treeview @if(isset($module) && ($module->name==$mod->name)||$mod->isParentOf($module->name)) open @endif ">
        <a href="#" class="dropdown-toggle">
            <i class="fa {{$mod->icon}}"></i> 
            <span>{{$mod->label}}</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu" @if(isset($module) && ($module->name==$mod->name)||$mod->isParentOf($module->name)) style="display:block;" @endif>
            <li @if(isset($module) && $module->name==$mod->name)class="active"@endif>
                <a href="/admin/{{$mod->name}}"><i class="fa fa-angle-double-right"></i> {{$mod->label}}</a>
            </li>
            @foreach($mod->submodules as $submod)
            @if($administrator->hasAccessToModule($submod->id))
            <li @if(isset($module) && $module->name==$submod->name)class="active"@endif>
                <a href="/admin/{{$submod->name}}"><i class="fa fa-angle-double-right"></i> {{$submod->label}}</a>
            </li>
            @endif
            @endforeach
        </ul>
    </li>
    @else
    <li @if(isset($module) && $module->name==$mod->name)class="active"@endif>
        <a href="/admin/{{$mod->name}}">
            <i class="fa {{$mod->icon}}"></i> 
            <span class="menu-text">{{$mod->label}}</span>
        </a>
    </li>
    @endif
    @endforeach
</ul>