
@extends('master_layout')
@section('title', 'Thông báo')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý thông báo</li>
                        <li class="breadcrumb-item active">Danh sách thông báo</li>
                    </ol>
                </div>
            </div>
        </div>
        @if(Session::has('messenge') && is_array(Session::get('messenge')))
            @php
                $messenge = Session::get('messenge');
            @endphp
            @if(isset($messenge['style']) && isset($messenge['msg']))
                <div class="alert alert-{{ $messenge['style'] }}" role="alert" style="position: fixed; top: 70px; right: 16px; width: auto; z-index: 999" id="myAlert">
                    <i class="bi bi-check2 text-{{ $messenge['style'] }}"></i>{{ $messenge['msg'] }}
                </div>
                @php
                    Session::forget('messenge');
                @endphp
            @endif
        @endif
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3>Thông báo cá nhân</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ngày nhận</th>
                                        <th>Người gửi</th>
                                        <th>SĐT</th>
                                        <th>Email</th>   
                                        <th>Trạng thái</th>                                      
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($noti as $items)
                                    <tr id="noti-{{ $items->id }}">
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($items->created_at)->format('d/m/Y') }}</td>
                                        <td>{{ $items->user->full_name }}</td>
                                        <td>{{ $items->user->phone }}</td>
                                        <td>{{ $items->user->email }}</td>
                                        <td class="status-column">
                                            @switch($items->is_read)
                                                @case(1)
                                                    <span class="btn btn-sm btn-success" style="width:120px">Đã đọc</span>
                                                    @break
                                                @case(0)
                                                    <span class="btn btn-sm btn-warning" style="width:120px">Chưa đọc</span>
                                                    @break
                                                @default
                                                    Không xác định
                                            @endswitch
                                        </td>                                                                                                                    
                                        <td>
                                            <a href="{{route('noti.detail', $items->id)}}" class="btn btn-info btn-sm" title="Xem thông báo">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{{ $items->id}}" title="Xóa thông báo">
                                                <i class="fa-solid fa-trash"></i>
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
@endsection
@section('scripts')
<script>
    $(document).ready(function () {

        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            Swal.fire({
                title: "Xác nhận xóa thông báo?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/noti/destroy/" + id,
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#noti-'+id).remove();                           
                        },
                        error: function(xhr) {
                            toastr.error('Có lỗi khi xóa thông báo');
                        }
                    });
                }
            });
        })

        setTimeout(function() {
            $("#myAlert").fadeOut(500);
        },3500);
    })
</script>                              
@endsection

