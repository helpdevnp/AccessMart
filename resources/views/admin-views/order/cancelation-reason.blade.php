@extends('layouts.admin.app')

@section('title', translate('messages.order_cancellation_reasons'))

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-capitalize">
                <div class="card-header-icon d-inline-flex mr-2 img">
                    <img src="{{ asset('/public/assets/admin/img/email.png') }}" alt="public">
                </div>
                <span>
                    {{ translate('messages.order_cancellation_reasons') }}
                </span>
            </h1>
        </div>

        <div class="col-lg-12 pt-sm-3">
            <div class="report-card-inner mb-4 pt-3 mw-100">
                <form action="{{ route('admin.business-settings.order-cancel-reasons.store') }}" method="post">
                    @csrf
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-md-0 mb-3">
                        <div class="mx-1">
                            <h5 class="form-label mb-0">
                                {{ translate('messages.add_an_order_cancellation_reason') }}
                            </h5>
                        </div>
                    </div>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-7">
                            <div>
                                <label for="order_cancellation"></label>
                                <input type="text" class="form-control h--45px" name="reason" id="order_cancellation"
                                    value="{{ old('reason') }}" placeholder="Ex: Item is Broken" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <label for="order_cancellation_reason"></label>
                                <select name="user_type" id="order_cancellation_reason" class="form-control h--45px"
                                    required>
                                    <option value="">{{ translate('messages.select_user_type') }}</option>
                                    <option value="admin">{{ translate('messages.admin') }}</option>
                                    <option value="store">{{ translate('messages.store') }}</option>
                                    <option value="customer">{{ translate('messages.customer') }}</option>
                                    <option value="deliveryman">{{ translate('messages.deliveryman') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-auto">
                            <button type="submit"
                                class="btn btn--primary h--45px btn-block">{{ translate('messages.add_reason') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-md-0 mb-3">
                    <div class="mx-1">
                        <h5 class="form-label mb-4">
                            {{ translate('messages.order_cancellation_reason_list') }}
                        </h5>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body p-0">
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                            class="table table-borderless table-thead-bordered table-align-middle"
                            data-hs-datatables-options='{
                        "isResponsive": false,
                        "isShowPaging": false,
                        "paging":false,
                    }'>
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">{{ translate('messages.SL') }}</th>
                                    <th class="border-0">{{ translate('messages.Reason') }}</th>
                                    <th class="border-0">{{ translate('messages.type') }}</th>
                                    <th class="border-0">{{ translate('messages.status') }}</th>
                                    <th class="border-0 text-center">{{ translate('messages.action') }}</th>
                                </tr>
                            </thead>

                            <tbody id="table-div">
                                @foreach ($reasons as $key => $reason)
                                    <tr>
                                        <td>{{ $key + $reasons->firstItem() }}</td>

                                        <td>
                                            <span class="d-block font-size-sm text-body">
                                                {{ Str::limit($reason->reason, 25, '...') }}
                                            </span>
                                        </td>
                                        <td>{{ Str::title($reason->user_type) }}</td>
                                        <td>
                                            <label class="toggle-switch toggle-switch-sm"
                                                for="stocksCheckbox{{ $reason->id }}">
                                                <input type="checkbox"
                                                    onclick="location.href='{{ route('admin.business-settings.order-cancel-reasons.status', [$reason['id'], $reason->status ? 0 : 1]) }}'"class="toggle-switch-input"
                                                    id="stocksCheckbox{{ $reason->id }}"
                                                    {{ $reason->status ? 'checked' : '' }}>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </td>

                                        <td>
                                            <div class="btn--container justify-content-center">

                                                <button
                                                    class="btn action-btn btn--primary btn-outline-primary identifyingClass"
                                                    data-id={{ $reason['id'] }} title="{{ translate('messages.edit') }}"
                                                    onClick="javascript:showMyModal('{{ $reason['id'] }}', `{{ $reason->reason }}`, '{{ $reason->user_type }}')">
                                                    <i class="tio-edit"></i>
                                                </button>


                                                <a class="btn btn-sm btn--danger btn-outline-danger action-btn"
                                                    href="javascript:"
                                                    onclick="form_alert('order-cancellation-reason-{{ $reason['id'] }}','{{ translate('messages.want_to_delete_this_order_cancellation_reason') }}')"
                                                    title="{{ translate('messages.delete') }}">
                                                    <i class="tio-delete-outlined"></i>
                                                </a>
                                                <form
                                                    action="{{ route('admin.business-settings.order-cancel-reasons.destroy', [$reason['id']]) }}"
                                                    method="post" id="order-cancellation-reason-{{ $reason['id'] }}">
                                                    @csrf @method('delete')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table -->
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('messages.order_cancellation_reason') }}
                        {{ translate('messages.Update') }}</label></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.business-settings.order-cancel-reasons.update') }}" method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="reason_id" id="hiddenValue" />
                        <input class="form-control" name='reason' id="hiddenValuetext" required type="text">
                        <label for="hiddenValuetype"></label>
                        <select name="user_type" id="hiddenValuetype" class="form-control h--45px"
                            required>
                            <option value="">{{ translate('messages.select_user_type') }}</option>
                            <option value="admin">{{ translate('messages.admin') }}</option>
                            <option value="store">{{ translate('messages.store') }}</option>
                            <option value="customer">{{ translate('messages.customer') }}</option>
                            <option value="deliveryman">{{ translate('messages.deliveryman') }}</option>
                        </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ translate('Save_changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script_2')
    <script>
        function showMyModal(id, data, type) {
            $(".modal-body #hiddenValue").val(id);
            $(".modal-body #hiddenValuetext").val(data);
            $(".modal-body #hiddenValuetype").val(type);
            $('#exampleModal').modal('show');
        }
    </script>
@endpush
