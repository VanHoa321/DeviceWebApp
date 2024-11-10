@extends('master_layout')
@section('title', 'Danh sách thiết bị')
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
                        <li class="breadcrumb-item active">Công việc của tôi</li>
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
                                <h3>Danh sách công việc</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ngày lập phiếu</th>
                                        <th>Người lập</th>
                                        <th>Thiết bị lỗi</th>
                                        <th>Số hiệu</th>
                                        <th>Trạng thái</th>                                      
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($tasks as $items)
                                    <tr id="task-{{ $items->detail_id }}">
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($items->maintenance->created_date)->format('d/m/Y') }}</td>
                                        <td>{{ $items->user->full_name }}</td>
                                        <td>{{ $items->device->name }}</td>
                                        <td>{{ $items->device->code }}</td>
                                        <td id="status-{{ $items->maintenance_id }}">
                                            @switch($items->status)
                                                @case(3)
                                                    <span class="btn btn-sm btn-primary" style="width:115px">Chờ xử lý</span>
                                                    @break
                                                @case(0)
                                                    <span class="btn btn-sm btn-danger" style="width:115px">Đã hủy</span>
                                                    @break
                                                @case(4)
                                                    <span class="btn btn-sm btn-success" style="width:115px">Đã hoàn thành</span>
                                                    @break
                                                @default
                                                    Không xác định
                                            @endswitch
                                        </td>                                                                                                                    
                                        <td>
                                            <a href="{{route('tech.detail', $items->detail_id)}}" class="btn btn-info btn-sm" title="Chi tiết">
                                                <i class="fa-solid fa-eye"></i></i>
                                            </a>
                                            @if($items->status == 1)
                                                <a href="#" class="btn btn-danger btn-sm btn-cancel-main" data-id="{{ $items->maintenance_id}}" title="Hủy phiếu bảo trì">
                                                    <i class="fa-solid fa-ban"></i>
                                                </a>
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
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {

        $('body').on('click', '.btn-cancel-main', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            Swal.fire({
                title: "Xác nhận hủy phiếu ?",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Hủy phiếu",
                cancelButtonText: "Không hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/use-unit/cancel/" + id,
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            // Ẩn nút hủy phiếu sau khi thành công
                            $('a[data-id="' + id + '"]').closest('td').find('.btn-cancel-main').hide();
                            // Cập nhật trạng thái hiển thị
                            const statusTd = $('#status-' + id);
                            statusTd.html('<span class="btn btn-sm btn-danger" style="width:115px">Đã hủy</span>');
                        },
                        error: function(xhr) {
                            toastr.error('Có lỗi khi hủy phiếu');
                        }
                    });
                }
            });
        });

        setTimeout(function() {
            $("#myAlert").fadeOut(500);
        },3500);
    })
</script>                              
@endsection