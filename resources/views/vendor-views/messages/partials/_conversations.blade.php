<style>
    div.scroll-down {
        max-height: 300px;
        overflow-y: scroll;
    }

</style>
<div class="card h-100">
    <!-- Header -->
    <div class="card-header">
        <div class="chat-user-info w-100 d-flex align-items-center">
            <div class="chat-user-info-img">
                <img class="avatar-img"
                    src="{{asset('storage/app/public/profile/'.$user['image'])}}"
                    onerror="this.src='{{asset('public/assets/admin')}}/img/160x160/img1.jpg'"
                    alt="Image Description">
            </div>
            <div class="chat-user-info-content">
                <h5 class="mb-0 text-capitalize">
                    {{$user['f_name'].' '.$user['l_name']}}</h5>
                <span>{{ $user['phone'] }}</span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="scroll-down">
            @foreach($convs as $con)
                @if($con->sender_id != $vendor->id)
                    <div class="pt1 pb-1">
                        <div class="conv-reply-1">
                            <h6>{{$con->message}}</h6>
                            @if($con->file!=null)
                            @foreach (json_decode($con->file) as $img)
                            <br>
                                <img style="width:100%"
                                src="{{asset('storage/app/public/conversation').'/'.$img}}">
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="pl-1">
                        <small>{{date('d M Y',strtotime($con->created_at))}} {{date(config('timeformat'),strtotime($con->created_at))}}</small>
                    </div>
                @else
                    <div class="pt-1 pb-1">
                        <div class="conv-reply-2">
                            <h6>{{$con->message}}</h6>
                            @if($con->file!=null)
                            @foreach (json_decode($con->file) as $img)
                            <br>
                                <img style="width:100%"
                                src="{{asset('storage/app/public/conversation').'/'.$img}}">
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="text-right pr-1">
                        <small>{{date('d M Y',strtotime($con->created_at))}} {{date(config('timeformat'),strtotime($con->created_at))}}</small>
                        @if ($con->is_seen == 1)
                        <span class="text-primary"><i class="tio-checkmark-circle"></i></span>
                        @else
                        <span><i class="tio-checkmark-circle-outlined"></i></span>
                        @endif
                    </div>
                @endif
            @endforeach
            <div id="scroll-here"></div>
        </div>

    </div>
    <!-- Body -->
    <div class="card-footer border-0 conv-reply-form">

        <form action="javascript:" method="post" id="reply-form-vnd" enctype="multipart/form-data" class="conv-txtarea">
            @csrf
            <div class="quill-custom_">
                <!-- <label for="msg" class="layer-msg"></label> -->
                <textarea id="conv-textarea" class="form-control pr--180" id="msg" rows = "1" name="reply" placeholder="{{translate('Start a new message')}}"></textarea>
                <div class="upload__box">
                    <div class="upload__img-wrap"></div>
                    <div id="file-upload-filename" class="upload__file-wrap"></div>
                    <div class="upload-btn-grp">
                        <label class="m-0">
                            <img src="{{asset('/public/assets/admin/img/gallery.png')}}" alt="">
                            <input type="file" name="images[]" class="d-none upload_input_images" data-max_length="2"  multiple="" >
                        </label>
                        {{-- <label class="m-0">
                            <img src="{{asset('/public/assets/admin/img/file.png')}}" alt="">
                            <input type="file" class="d-none" id="file-upload">
                        </label> --}}
                        <label class="m-0 emoji-icon-hidden">
                            <img src="{{asset('/public/assets/admin/img/emoji.png')}}" alt="">
                        </label>
                    </div>
                </div>

                <button type="submit"
                        class="btn btn-primary btn--primary con-reply-btn">{{translate('messages.send')}}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#conv-textarea").emojioneArea({
            pickerPosition: "top",
            tonesStyle: "bullet",
                events: {
                    keyup: function (editor, event) {d
                        console.log(editor.html());
                        console.log(this.getText());
                    }
                }
            });
    });
</script>


<script>
    // Image Upload
    jQuery(document).ready(function () {
        ImgUpload();
    });
    function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $('.upload_input_images').each(function () {
        $(this).on('change', function (e) {
        imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
        var maxLength = $(this).attr('data-max_length');

        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        console.log(filesArr);
        var iterator = 0;
        filesArr.forEach(function (f, index) {

            if (!f.type.match('image.*')) {
            return;
            }

            if (imgArray.length > maxLength) {
            return false
            } else {
            var len = 0;
            for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i] !== undefined) {
                len++;
                }
            }
            if (len > maxLength) {
                return false;
            } else {
                imgArray.push(f);

                var reader = new FileReader();
                reader.onload = function (e) {
                var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                imgWrap.append(html);
                iterator++;
                }
                reader.readAsDataURL(f);
            }
            }
        });
        });
    });

    $('body').on('click', ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
        if (imgArray[i].name === file) {
            imgArray.splice(i, 1);
            break;
        }
        }
        $(this).parent().parent().remove();
    });
    }

    //File Upload
    $('#file-upload').change(function(e){
        var fileName = e.target.files[0].name;
        $('#file-upload-filename').text(fileName)
    });

    $(document).ready(function () {
        $('.scroll-down').animate({
            scrollTop: $('#scroll-here').offset().top
        },0);
    });

    $(function() {
        $("#coba").spartanMultiImagePicker({
            fieldName: 'images[]',
            maxCount: 3,
            rowHeight: '55px',
            groupClassName: 'attc--img',
            maxFileSize: '',
            placeholderImage: {
                image: '{{ asset('public/assets/admin/img/attatchments.png') }}',
                width: '100%'
            },
            dropFileLabel: "Drop Here",
            onAddRow: function(index, file) {

            },
            onRenderedPreview: function(index) {

            },
            onRemoveRow: function(index) {

            },
            onExtensionErr: function(index, file) {
                toastr.error('{{ translate('messages.please_only_input_png_or_jpg_type_file') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            },
            onSizeErr: function(index, file) {
                toastr.error('{{ translate('messages.file_size_too_big') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        });
    });


    $('#reply-form-vnd').on('submit', function() {
        $('button[type=submit], input[type=submit]').prop('disabled',true);
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('vendor.message.store', ['user_id'=>$user->id,'user_type'=>$user_type]) }}',
                data: $('reply-form-vnd').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.errors && data.errors.length > 0) {
                        $('button[type=submit], input[type=submit]').prop('disabled',false);
                        toastr.error('Write something to send massage!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else{

                        toastr.success('Message sent', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#view-conversation').html(data.view);
                        converationList();
                    }
                },
                error() {
                    toastr.error('Write something to send massage!', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
</script>
