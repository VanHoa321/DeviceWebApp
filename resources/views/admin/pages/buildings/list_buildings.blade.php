@extends('master_layout')
@section('title', 'Danh sách tòa nhà')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Danh sách tòa nhà</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý tòa nhà</li>
                        <li class="breadcrumb-item active">Danh sách tòa nhà</li>
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
                                 <a type="button" class="btn btn-success" href="{{route('buildings.create')}}">
                                    <i class="fa-solid fa-plus" title="Thêm mới tòa nhà"></i>
                                 </a>
                                <!--<a href="#" type="button" id="reloadButton" class="btn btn-secondary">
                                    <i class="fa-solid fa-rotate-right" style="color:white" title="Tải lại dữ liệu"></i>
                                </a>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên tòa nhà</th>
                                        <th>Cơ sở</th>                                        
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody id="showdata">
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($buildings as $items)
                                    <tr id="buildings-{{ $items->building_id }}">
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $items->name }}</td>
                                        <td>{{ $items->branch ? $items->branch->branch_name : 'N/A' }}</td>                                                                                                                    
                                        <td>
                                            <a href="{{route('buildings.edit', $items->building_id)}}" class="btn btn-info btn-sm" title="Sửa tòa nhà">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{{ $items->building_id }}" title="Xóa tòa nhà">
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
                title: "Xác nhận xóa tòa nhà?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/buildings/destroy/" + id,
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#buildings-'+id).remove();                           
                        },
                        error: function(xhr) {
                            toastr.error('Có lỗi khi xóa tòa nhà');
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

