<div class="modal fade" id="how-it-works">
    <div class="modal-dialog status-warning-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true" class="tio-clear"></span>
                </button>
            </div>
            <div class="modal-body pb-5 pt-0">
                <div class="single-item-slider owl-carousel">
                    <div class="item">
                        <div class="max-349 mx-auto mb-20 text-center">
                            <img src="{{asset('/public/assets/admin/img/landing-how.png')}}" alt="" class="mb-20">
                            <h5 class="modal-title">{{translate('Notice!')}}</h5>
                            <p>
                                {{translate("If you want to disable or turn off any section please leave that section empty, don’t make any changes there!")}}
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="max-349 mx-auto mb-20 text-center">
                            <img src="{{asset('/public/assets/admin/img/notice-2.png')}}" alt="" class="mb-20">
                            <h5 class="modal-title">{{translate('If You Want to Change Language')}}</h5>
                            <p>
                                {{translate("Change the language on tab bar and input your data again!")}}
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="max-349 mx-auto mb-20 text-center">
                            <img src="{{asset('/public/assets/admin/img/notice-3.png')}}" alt="" class="mb-20">
                            <h5 class="modal-title">{{translate('Let’s See The Changes!')}}</h5>
                            <p>
                                {{translate('Visit landing page to see the changes you made in the settings option!')}}
                            </p>
                            {{-- <div class="btn-wrap">
                                <a href="{{ route('home') }}" class="btn btn--primary w-100">{{ translate('Visit_Now') }}</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="slide-counter"></div>
                </div>
            </div>
        </div>
    </div>
</div>