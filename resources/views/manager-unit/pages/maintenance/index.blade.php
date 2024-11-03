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
                        <li class="breadcrumb-item active">Danh sách bảo trì</li>
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
                                <h3>Danh sách bảo trì</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ngày lập phiếu</th>
                                        <th>Người lập</th>
                                        <th>Ghi chú</th>
                                        <th>Trạng thái</th>                                      
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($list as $items)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($items->created_date)->format('d/m/Y') }}</td>
                                        <td>{{Auth::user()->full_name }}</td>
                                        <td>{{ $items->description }}</td>
                                        <td id="status-{{ $items->maintenance_id }}">
                                            @switch($items->status)
                                                @case(1)
                                                    <span class="btn btn-sm btn-primary" style="width:115px">Đang chờ duyệt</span>
                                                    @break
                                                @case(0)
                                                    <span class="btn btn-sm btn-danger" style="width:115px">Đã hủy</span>
                                                    @break
                                                @case(2)
                                                    <span class="btn btn-sm btn-info" style="width:115px">Đang bảo trì</span>
                                                    @break
                                                @case(3)
                                                    <span class="btn btn-sm btn-success" style="width:115px">Đã hoàn thành</span>
                                                    @break
                                                @default
                                                    Không xác định
                                            @endswitch
                                        </td>                                                                                                                    
                                        <td>
                                            <a href="{{route('mainM.maintenance_detail', $items->maintenance_id)}}" class="btn btn-info btn-sm" title="Chi tiết">
                                                <i class="fa-solid fa-eye"></i></i>
                                            </a>
                                            @if($items->status == 1)
                                                <a href="#" class="btn btn-success btn-sm btn-confirm-main" data-id="{{ $items->maintenance_id}}" title="Duyệt phiếu bảo trì">
                                                    <i class="fa-solid fa-check"></i>
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

        $('body').on('click', '.btn-confirm-main', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            var $confirmButton = $(this);
            Swal.fire({
                title: "Xác nhận duyệt phiếu bảo trì ?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Duyệt",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/manager-unit/confirm/" + id,
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $confirmButton.hide();
                            $('#status-' + id).html('<span class="btn btn-sm btn-info" style="width:115px">Đang bảo trì</span>');
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