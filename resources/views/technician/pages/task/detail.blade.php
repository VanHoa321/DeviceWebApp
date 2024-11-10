@extends('master_layout')
@section('title', 'Chi tiết bảo trì')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý bảo trì</li>
                        <li class="breadcrumb-item active">Chi tiết bảo trì</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 d-flex justify-content-center align-items-center">
                                    <div class="form-group text-center mt-2">
                                        <img src="{{ $detail->device->image ?? 'default-image.jpg' }}"
                                            style="width:200px; height:200px; border:2px solid #ccc"
                                            class="mx-auto d-block mb-4" 
                                        />
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h4 class="text-info mb-3 mt-1">Thông tin thiết bị</h4>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Tên thiết bị</label>
                                                <input type="text" class="form-control" value="{{ $detail->device->name ?? 'Không có dữ liệu' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Số hiệu</label>
                                                <input type="text" class="form-control" value="{{ $detail->device->code ?? 'Không có dữ liệu' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Năm sử dụng</label>
                                                <input type="date" class="form-control" value="{{ $detail->device->years ?? '' }}">
                                            </div> 
                                        </div>
                                    </div>                               
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Vị trí thiết bị</label>
                                                <input type="text" class="form-control" 
                                                    value="{{ $detail->device->room->name ?? '' }}, {{ $detail->device->room->building->name ?? '' }}, {{ $detail->device->room->building->branch->branch_name ?? '' }}, {{ $detail->device->room->building->branch->address ?? '' }}">
                                            </div>
                                        </div>                                        
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">                               
                                <div class="col-md-3 d-flex justify-content-center align-items-center">
                                    @if($detail->status != 1 && $detail->status != 2)
                                        <div class="form-group text-center mt-2">
                                            <img src="{{ $sender->avatar }}"
                                                style="width:200px; height:200px"
                                                class="mx-auto d-block mb-4" 
                                            />
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h4 class="text-info mb-3 mt-1">Thông tin người báo hỏng</h4>
                                    @if($detail->status == 1 || $detail->status == 2)
                                        <div class="alert alert-info alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <i class="icon fas fa-exclamation-triangle"></i>Chưa phân công kỹ thuật viên
                                        </div>                                       
                                    @else
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Họ tên</label>
                                                    <input type="text" class="form-control" value="{{ $sender->full_name ?? 'Chưa cập nhật' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Số điện thoại</label>
                                                    <input type="text" class="form-control" value="{{ $sender->phone ?? 'Chưa cập nhật' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Ngày sinh</label>
                                                    <input type="date" class="form-control" value="{{ $sender->dob ?? 'Chưa cập nhật' }}">
                                                </div> 
                                            </div>
                                        </div>                               
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Địa chỉ</label>
                                                    <input type="text" class="form-control" value="{{ $sender->address ?? 'Chưa cập nhật'}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" value="{{ $sender->email ?? 'Chưa cập nhật' }}">
                                                </div>
                                            </div>                                          
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">                               
                                <div class="col-md-12">
                                    <h4 class="text-info mb-3 mt-1">Kết quả công việc</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kết quả xử lý</label>
                                                <input type="hidden" id="detal-id" class="form-control" value="{{ $detail->detail_id }}">
                                                <textarea class="form-control mb-3" id="result-tast" placeholder="Nhập kết quả xử lý" style=" height: 100px">{{$detail->expense}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group ml-2">
                                                <label>Minh chứng công việc</label>
                                                <div class="form-group mt-2">
                                                    <div class="row">
                                                        @if ($detail->status == 3)
                                                            <div class="col-md-12" id="upload-task">
                                                                <a id="lfm" class="btn btn-info" data-input="thumbnail" data-preview="holder"><i class="fa-solid fa-folder-plus" style="font-size:40px"></i></a>
                                                                <input id="thumbnail" class="form-control" width="100%" type="hidden" name="files[]" multiple>
                                                            </div>
                                                        @endif
                                                        @if ($detail->status == 3)
                                                            <div class="col-md-12 mt-2">
                                                                <ul id="fileList" class="mailbox-attachments d-flex align-items-stretch clearfix"></ul>
                                                                <div id="fileInputs"></div>
                                                            </div>
                                                        @else
                                                        <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                                            @foreach ($files as $file)
                                                                @php
                                                                    $fileUrl = asset($file->file_path);
                                                                    $fileExtension = pathinfo($file->file_path, PATHINFO_EXTENSION);
                                                                @endphp
                                                                <li class="file-item">
                                                                    @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                                                        <!-- Image -->
                                                                        <span class="mailbox-attachment-icon has-img">
                                                                            <img src="{{ $fileUrl }}" alt="Image" style="width:100%; height:130px;">
                                                                        </span>
                                                                        <div class="mailbox-attachment-info">
                                                                            <a href="{{ $fileUrl }}" class="mailbox-attachment-name" target="_blank">
                                                                                <i class="fas fa-paperclip"></i> {{ basename($file->file_path) }}
                                                                            </a>
                                                                        </div>
                                                                    @elseif (in_array(strtolower($fileExtension), ['mp4', 'avi', 'mov']))
                                                                        <!-- Video -->
                                                                        <span class="mailbox-attachment-icon has-img">
                                                                            <video src="{{ $fileUrl }}" controls style="width:100%; height:130px;"></video>
                                                                        </span>
                                                                        <div class="mailbox-attachment-info">
                                                                            <a href="{{ $fileUrl }}" class="mailbox-attachment-name" target="_blank">
                                                                                <i class="fas fa-paperclip"></i> {{ basename($file->file_path) }}
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        @endif
                                                    </div>
                                                </div>                                               
                                            </div> 
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>                       
                        <div class="card-footer">
                            <a href="{{route('tech.task')}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
                            @if ($detail->status == 3)
                                <button id="save-main-task" class="btn btn-success"><i class="fa-solid fa-floppy-disk" title="Lưu"></i></button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
    <script>
        const selectedFiles = [];

        $('#thumbnail').on('change', function() {
            var url = $('#thumbnail').val();
            if (selectedFiles.length < 6 && url && !selectedFiles.includes(url)) {
                selectedFiles.push(url);
                addFileToList(url);
            } else {
                toastr.error('Bạn chỉ có thể tải tối đa 6 file');
            }
        });

        function addFileToList(url) {
            const fileList = document.getElementById("fileList");
            const listItem = document.createElement("li");
            if (url.match(/\.(jpeg|jpg|gif|png|bmp)$/i)) {
                listItem.innerHTML = `
                    <span class="mailbox-attachment-icon has-img">
                        <img src="${url}" alt="Image" style="width:100%; height:130px;">
                    </span>
                    <div class="mailbox-attachment-info">
                        <a href="${url}" class="mailbox-attachment-name" target="_blank">
                            <i class="fas fa-paperclip"></i> ${url.split('/').pop()}
                        </a>
                        <span class="mailbox-attachment-size clearfix mt-1 delele-file">
                            <a href="#" class="btn btn-default btn-sm float-right" onclick="removeFile(this, '${url}', event)">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </span>
                    </div>`;
            }
            else if (url.match(/\.(mp4|webm|ogg)$/i)) {
                listItem.innerHTML = `
                    <span class="mailbox-attachment-icon has-img">
                        <video src="${url}" controls style="width:100%; height:130px;"></video>
                    </span>
                    <div class="mailbox-attachment-info">
                        <a href="${url}" class="mailbox-attachment-name" target="_blank">
                            <i class="fas fa-paperclip"></i> ${url.split('/').pop()}
                        </a>
                        <span class="mailbox-attachment-size clearfix mt-1 delele-file">
                            <a href="#" class="btn btn-default btn-sm float-right" onclick="removeFile(this, '${url}', event)">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </span>
                    </div>`;
            }
            fileList.appendChild(listItem);
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "file[]";
            input.value = url;
            document.getElementById('fileInputs').appendChild(input);
        }

        function removeFile(element, url, event) {
            event.preventDefault();
            element.closest('li').remove();
            const inputs = document.querySelectorAll('input[name="file[]"]');
            inputs.forEach(input => {
                if (input.value === url) {
                    input.remove();
                }
            });
            const index = selectedFiles.indexOf(url);
            if (index !== -1) {
                selectedFiles.splice(index, 1);
            }
        }

        $('#save-main-task').on('click', function() {
            var result = $('#result-tast').val();
            var detail_id = $('#detal-id').val();
            if (!result) {
                toastr.error('Vui lòng nhập kết quả xử lý!');
                return;
            }
            if (selectedFiles.length === 0) {
                toastr.error('Cần tải lên kết quả công việc!');
                return;
            }
            $.ajax({
                url: '/technician/updateTask',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    urls: selectedFiles,
                    result: result,
                    detail_id: detail_id,
                    _token: '{{ csrf_token() }}'
                }),
                success: function(response) {
                    if (response.success) {
                        toastr.success('Bảo trì thiết bị thành công');
                        $('#save-main-task').hide();
                        $('#upload-task').hide();
                        $('.delele-file').hide();
                    } else {
                        toastr.error('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Đã xảy ra lỗi:", error);
                    console.log("Lỗi chi tiết:", xhr.responseText);
                }
            });
        });
    </script>
@endsection