@foreach($modules as $key=>$module)
<tr>
    <td class="pl-4">{{$key+1}}</td>
    <td>{{$module->id}}</td>
    <td>
        <span class="d-block font-size-sm text-body">
            {{Str::limit($module['module_name'], 20,'...')}}
        </span>
    </td>
    <td>
        <span class="d-block font-size-sm text-body text-capitalize">
            {{Str::limit($module['module_type'], 20,'...')}}
        </span>
    </td>
    <td>
        <label class="toggle-switch toggle-switch-sm" for="status-{{$module->id}}">
        <input type="checkbox" class="toggle-switch-input" onclick="toogleStatusModal(event,'status-{{$module->id}}','module-on.png','module-off.png','{{translate('Want_to_activate_this')}} <strong>{{translate('Business_Module?')}}</strong>','{{translate('Want_to_deactivate_this')}} <strong>{{translate('Business_Module?')}}</strong>',`<p>{{translate('If_you_activate_this_business_module,_all_its_features_and_functionalities_will_be_available_and_accessible_to_all_users.')}}</p>`,`<p>{{translate('If_you_deactivate_this_business_module,_all_its_features_and_functionalities_will_be_disabled_and_hidden_from_users.')}}</p>`)"  
        {{-- onclick="location.href='{{route('admin.business-settings.module.status',[$module['id'],$module->status?0:1])}}'" --}}
        class="toggle-switch-input" id="status-{{$module->id}}" {{$module->status?'checked':''}}>
            <span class="toggle-switch-label">
                <span class="toggle-switch-indicator"></span>
            </span>
        </label>
        <form action="{{route('admin.business-settings.module.status',[$module['id'],$module->status?0:1])}}" method="get" id="status-{{$module->id}}_form">
        </form>
    </td>
    <td class="text-center">{{$module->stores_count}}</td>
    <td>
        <div class="btn--container justify-content-center">
            <a class="btn action-btn btn--primary btn-outline-primary"
                href="{{route('admin.business-settings.module.edit',[$module['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.Business_Module')}}"><i class="tio-edit"></i>
            </a>
        </div>
    </td>
</tr>
@endforeach