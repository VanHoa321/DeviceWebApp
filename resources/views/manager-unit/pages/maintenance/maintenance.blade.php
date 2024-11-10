@extends('master_layout')
@section('title', 'Danh sách phiếu bảo trì')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý bảo trì</li>
                        <li class="breadcrumb-item active">Danh sách thiết bị báo lỗi</li>
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
                        <div class="card-header">
                            <div>
                                <h3>Danh sách thiết bị lỗi</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Thiết bị</th>
                                        <th>Số hiệu</th>
                                        <th>Người sửa</th>
                                        <th>Tên người sửa</th>
                                        <th>Trạng thái</th>                                      
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($maintenanceDetails as $items)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td><img src="{{ $items->device->image }}" alt="" style="width: 80px; height: 80px"></td>
                                        <td>{{ $items->device->code }}</td>
                                        @if($items->status == 1 || $items->status == 2)
                                            <td><span class="text-danger">Chưa phân công</span></td>
                                            <td><span class="text-danger">Chưa phân công</span></td>
                                        @else
                                            <td><img src="{{ $items->user->avatar }}" alt="" style="width: 80px; height: 80px"></td>
                                            <td>{{ $items->user->full_name }}</td>
                                        @endif
                                        <td id="status-{{ $items->detail_id }}">
                                            @switch($items->status)
                                                @case(1)
                                                    <span class="btn btn-sm btn-primary" style="width:115px">Đang chờ duyệt</span>
                                                    @break
                                                @case(0)
                                                    <span class="btn btn-sm btn-danger" style="width:115px">Đã hủy</span>
                                                    @break
                                                @case(2)
                                                    <span class="btn btn-sm btn-info" style="width:115px">Chờ phân công</span>
                                                    @break
                                                @case(3)
                                                    <span class="btn btn-sm btn-success" style="width:115px">Đang bảo trì</span>
                                                    @break
                                                @case(4)
                                                    <span class="btn btn-sm btn-success" style="width:115px">Đã hoàn thành</span>
                                                    @break
                                                @default
                                                    Không xác định
                                            @endswitch
                                        </td>                                                                                                                    
                                        <td>
                                            <a href="{{route('mainM.detail', $items->detail_id)}}" class="btn btn-info btn-sm" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i></i>
                                            </a>
                                            @if($items->status == 2)
                                                <a href="#" class="btn btn-success btn-assign btn-sm" title="Phân công kỹ thuật viên" data-toggle="modal" data-target="#modal-user" data-id="{{ $items->detail_id }}">
                                                    <i class="fa-solid fa-user-check"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>                                                         
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('mainM.index')}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
                        </div>    
                    </div>
                </div>
            </div>
                    <!--modal -->
            <div class="modal fade" id="modal-user">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Phân công kỹ thuật viên</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">                                            
                                                <div class="card-body">
                                                    <table id="example-table-2" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                            <th>#</th>
                                                            <th>Hình ảnh</th>
                                                            <th>Họ tên</th>
                                                            <th>SĐT</th>  
                                                            <th>Bộ phận</th>
                                                            <th>Trạng thái</th>                                      
                                                            <th>Chức năng</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                            $counter = 1;
                                                        @endphp
                                                        @foreach ($users as $items)
                                                            <tr>
                                                                <td>{{ $counter++ }}</td>
                                                                <td><img src="{{ $items->avatar }}" alt="" style="width: 80px; height: 80px"></td>
                                                                <td>{{ $items->full_name }}</td>
                                                                <td>{{ $items->phone }}</td>
                                                                <td>{{ $items->unit ? $items->unit->name : 'N/A' }}</td>
                                                                <td class="status-column">
                                                                    @switch($items->status)
                                                                        @case(1)
                                                                            <span class="btn btn-sm btn-success" style="width:120px">Đang hoạt động</span>
                                                                            @break
                                                                        @case(0)
                                                                            <span class="btn btn-sm btn-warning" style="width:120px">Đã bị khóa</span>
                                                                            @break
                                                                        @default
                                                                            Không xác định
                                                                    @endswitch
                                                                </td>                                                                                                                    
                                                                <td>
                                                                    <a href="#" data-id="{{$items->user_id}}" class="btn btn-info btn-sm btn-confirm-assign" title="Phân công">
                                                                        <i class="fa-solid fa-check"></i>
                                                                    </a>                                                                   
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>                               
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->
        </div>
    </section>
</div>
@endsection
@section('scripts')     
    <script>
        let selectedDetailId;
        $(document).on('click', '.btn-assign', function () {
            selectedDetailId = $(this).data('id');
        });

        $(document).on('click', '.btn-confirm-assign', function () {
            const userId = $(this).data('id');
            $.ajax({
                url: '/manager-unit/phan-cong',
                type: 'POST',
                data: {
                    detail_id: selectedDetailId,
                    user_id: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#modal-user').modal('hide');
                        setTimeout(function() {
                            window.location.href = '/manager-unit/chi-tiet-bao-loi/'+selectedDetailId;
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Error details:", jqXHR);
                    console.log("Text status:", textStatus);
                    console.log("Error thrown:", errorThrown);
                    toastr.error('Đã xảy ra lỗi');
                }
            });
        });
    </script>                      
@endsection

