@extends('master_layout')
@section('title', 'Báo hỏng thiết bị')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Tạo phiếu báo hỏng</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý thiết bị</li>
                        <li class="breadcrumb-item active">Báo hỏng thiết bị</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="branch_id">Cơ sở</label>
                                        <select id="branch_id" class="form-control select2bs4">
                                            <option value="0">---Chọn cơ sở---</option>
                                            @foreach($branchs as $item)
                                            <option value="{{$item->branch_id}}">{{$item->branch_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="building_id">Tòa nhà</label>
                                        <select id="building_id" class="form-control select2bs4" disabled>
                                            <option value="0">---Chọn tòa nhà---</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="room_id">Phòng</label>
                                        <select id="room_id" class="form-control select2bs4" disabled>
                                            <option value="0">---Chọn phòng---</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 d-none justify-content-between align-items-center mb-2" id="search-container">
                                <div class="input-group w-25 ml-auto">
                                    <input type="text" id="search-input" class="form-control mr-1" placeholder="Nhập số hiệu thiết bị">
                                    <button class="btn btn-info" type="button" id="search-button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-none" id="data-table">
                                    <table id="example-table">
                                        <thead id="table-head"></thead>
                                        <tbody id="table-body"></tbody>
                                    </table>
                                    <div id="pagination" class=""></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer" id="save-main">
                            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modal-default2" title="Tạo phiếu bảo trì">
                                <i class="fa-solid fa-floppy-disk"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-default2">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Nhập ghi chú phiếu bảo trì</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Mô tả thêm</label>
                                <textarea id="main-description" class="form-control mb-3" placeholder="Nhập mô tả phiếu bảo trì" style=" height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-success btn-save-main">Tạo phiếu</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="{{asset("assets/plugins/select2/js/select2.full.min.js")}}"></script>
<script src="{{asset("assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js")}}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        var branch_id = 0;
        var building_id = 0;
        var room_id = 0;
        // Khi chọn cơ sở
        $('#branch_id').on('change', function() {
            branch_id = $(this).val();
            $('#building_id').empty().append('<option value="0">---Chọn tòa nhà---</option>').prop('disabled', true);
            $('#room_id').empty().append('<option value="0">---Chọn phòng---</option>').prop('disabled', true);
            $('#table-head').empty();
            $('#table-body').empty();

            if (branch_id > 0) {
                $.ajax({
                    url: '/use-unit/get-buildings/' + branch_id,
                    method: 'GET',
                    success: function(data) {
                        $('#building_id').prop('disabled', false);
                        $.each(data, function(index, building) {
                            $('#building_id').append('<option value="' + building.building_id + '">' + building.name + '</option>');
                        });
                    }
                });
            }
            else{
                $('#data-table').addClass('d-none');
                $('#search-container').addClass('d-none');
                $('#example-table').removeClass('table table-bordered table-hover');
                building_id = 0;
                room_id = 0;
            }
        });

        // Khi chọn tòa nhà
        $('#building_id').on('change', function() {
            building_id = $(this).val();
            $('#room_id').empty().append('<option value="0">---Chọn phòng---</option>').prop('disabled', true);
            $('#table-head').empty();
            $('#table-body').empty();

            if (building_id > 0) {
                $.ajax({
                    url: '/use-unit/get-rooms/' + building_id,
                    method: 'GET',
                    success: function(data) {
                        $('#room_id').prop('disabled', false);
                        $.each(data, function(index, room) {
                            $('#room_id').append('<option value="' + room.room_id + '">' + room.name + '</option>');
                        });
                    }
                });
            }
            else{
                $('#data-table').addClass('d-none');
                $('#example-table').removeClass('table table-bordered table-hover');
                $('#search-container').addClass('d-none');
                room_id = 0;
            }
        });

        // Khi chọn phòng
        $('#room_id').on('change', function() {
            loadDevices(1);
        });

        $('#search-button').on('click', function() {
            loadDevices(1);
        });

        $('#search-input').on('input', function() {
            if ($(this).val() === '') {
                loadDevices(1);
            }
        });

        function loadDevices(page) {
            room_id = $('#room_id').val();
            const searchTerm = $('#search-input').val();
            $('#table-body').empty();
            $('#table-head').empty();
            if (room_id > 0) {
                $('#data-table').removeClass('d-none')
                $('#example-table').addClass('table table-bordered table-hover');
                $('#search-container').removeClass('d-none')
                $.ajax({
                    url: '/use-unit/get-devices/' + room_id + '?page=' + page,
                    method: 'GET',
                    data: {
                        search: searchTerm
                    },
                    success: function(data) {
                        const devices = data.devices.data;
                        const selectedDevices = data.selected_devices;
                        $('#table-head').empty();
                        $('#table-body').empty();
                        if (devices.length > 0) {
                            $('#table-head').append(`
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center" style="width:15%">Hình ảnh</th>
                                    <th class="text-center" style="width:25%">Tên thiết bị</th>
                                    <th class="text-center">Số hiệu</th>
                                    <th class="text-center" style="width: 30%;">Mô tả lỗi</th>
                                    <th class="text-center">Chức năng</th>
                                </tr>
                            `);

                            devices.forEach((device, index) => {
                                const isChecked = selectedDevices[device.device_id] ? 'checked' : '';
                                const description = selectedDevices[device.device_id]?.description || '';
                                $('#table-body').append(`
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle">${index + 1}</td>
                                        <td style="width:15%; text-align: center; vertical-align: middle"><img src="${device.image}" alt="" style="width: 80px; height: 80px"></td>
                                        <td style="width: 25%; text-align: center; vertical-align: middle">${device.name}</td>
                                        <td style="text-align: center; vertical-align: middle">${device.code}</td>
                                        <td style="width: 30%">
                                            <textarea class="form-control error-description" id="description_err-${device.device_id}" data-id="${device.device_id}" placeholder="Nhập mô tả lỗi">${description}</textarea>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle">
                                            <div class="icheck-success d-inline" style="transform: scale(1.5)">
                                                <input type="checkbox" class="device-checkbox" id="checkboxSuccess-${device.device_id}" data-id="${device.device_id}" ${isChecked}>
                                                <label for="checkboxSuccess-${device.device_id}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            $('#table-body').append(`
                                <tr>
                                    <td colspan="6" class="text-center text-danger">Không có thiết bị</td>
                                </tr>
                            `);
                        }

                        devices.forEach(device => {
                            const isChecked = selectedDevices[device.device_id] ? true : false;
                            const textarea = $(`#description_err-${device.device_id}`);
                            if (isChecked) {
                                textarea.prop('disabled', true);
                            }
                        });

                        $('.device-checkbox').change(function() {
                            const deviceId = $(this).data('id');
                            const textarea = $(`#description_err-${deviceId}`);

                            if ($(this).is(':checked')) {
                                if (textarea.val().trim() !== '') {
                                    textarea.prop('disabled', true);
                                }
                            } else {
                                textarea.prop('disabled', false);
                                textarea.val('');
                            }
                        });

                        // Hiển thị các nút phân trang
                        $('#pagination').empty();
                        $('#pagination').addClass('mt-3');
                        if (data.devices.last_page > 1) {
                            let paginationHTML = '<ul class="pagination justify-content-end">';

                            if (data.devices.current_page > 1) {
                                paginationHTML += `
                                    <li class="page-item">
                                        <a href="#" class="page-link" data-page="${data.devices.current_page - 1}">Trước</a>
                                    </li>`;
                            }

                            for (let i = 1; i <= data.devices.last_page; i++) {
                                paginationHTML += `
                                    <li class="page-item ${i == data.devices.current_page ? 'active' : ''}">
                                        <a href="#" class="page-link" data-page="${i}">${i}</a>
                                    </li>`;
                            }

                            if (data.devices.current_page < data.devices.last_page) {
                                paginationHTML += `
                                    <li class="page-item">
                                        <a href="#" class="page-link" data-page="${data.devices.current_page + 1}">Sau</a>
                                    </li>`;
                            }

                            paginationHTML += '</ul>';
                            $('#pagination').append(paginationHTML);
                        }
                    }
                });
            }
            else {
                $('#example-table').removeClass('table table-bordered table-hover');
                $('#pagination').empty();
                $('#pagination').removeClass('mt-3');
                $('#data-table').addClass('d-none');
                $('#search-container').addClass('d-none');
            }
        }

        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            loadDevices(page);
        });
    });
</script>
<script>
    $(document).on('click', '.btn-add-report', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var description = $('#description_err-'+id).val();

        if (description.trim() === "") {
            toastr.error("Vui lòng nhập mô tả lỗi trước khi thêm");
            return;
        }
        $.ajax({
            url: '/use-unit/add-to-report/' + id,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                error:description
            },
            success: function(response) {
                if (response.success) {
                    $('#count-report').text(response.count);
                    toastr.success(response.message);
                } else if (response.warning) {
                    toastr.warning(response.message);

                } else if (response.danger) {
                    toastr.danger(response.message);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi, vui lòng thử lại sau.');
            }
        });
    });

    $(document).on('change', '.device-checkbox', function () {
        var deviceId = $(this).attr('id').split('-')[1];
        var description = $('#description_err-' + deviceId).val();
        
        if ($(this).is(':checked')) {
            if (description.trim() === "") {
                toastr.error("Vui lòng nhập mô tả lỗi trước khi thêm");
                $(this).prop('checked', false);
                return;
            }
            
            $.ajax({
                url: '/use-unit/add-to-report/' + deviceId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    error: description
                },
                success: function (response) {
                    if (response.success) {
                        $('#count-report').text(response.count);
                        toastr.success(response.message);
                    } else if (response.warning) {
                        toastr.warning(response.message);
                        $('#description_err-' + deviceId).val('');
                        $(this).prop('checked', false);
                        $('#description_err-' + deviceId).prop('disabled', false);
                    } else if (response.danger) {
                        toastr.error(response.message);
                    }
                }.bind(this),
                error: function () {
                    alert('Đã xảy ra lỗi, vui lòng thử lại sau.');
                }
            });
        } else {
            $.ajax({
                url: '/use-unit/remove-report/' + deviceId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        $('#count-report').text(response.count);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function () {
                    alert('Đã xảy ra lỗi, vui lòng thử lại sau.');
                }
            });
        }
    });
    $('body').on('click', '.btn-save-main', function(e) {
        let mainDescription = $('#main-description').val();
        $.ajax({
            url: '/use-unit/save-maintenance',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                description: mainDescription
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Tạo phiếu bảo trì thành công!');
                    $('#modal-default2').modal('hide');
                    $('#count-report').text(response.count);
                    $('.error-description').val('');
                    $('.device-checkbox').prop('checked', false);
                    $('.error-description').prop('disabled', false);
                } else if (response.error) {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Có lỗi xảy ra: ' + xhr.responseText);
            }
        });
    });
</script>
@endsection