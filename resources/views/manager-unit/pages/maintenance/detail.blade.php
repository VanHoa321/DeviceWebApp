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
                                            style="width:200px; height:200px; border:2px solid #ccc; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);"
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
                                                <label>Địa chỉ</label>
                                                <input type="text" class="form-control" 
                                                    value="{{ $detail->device->room->name ?? 'Không có dữ liệu' }} - {{ $detail->device->room->building->name ?? '' }} - {{ $detail->device->room->building->branch->branch_name ?? '' }} - {{ $detail->device->room->building->branch->address ?? '' }}">
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">                               
                                <div class="col-md-3 d-flex justify-content-center align-items-center">
                                    @if($detail->status != 1 && $detail->status != 2)
                                        <div class="form-group text-center mt-2">
                                            <img src="{{ $detail->user->avatar }}"
                                                style="width:200px; height:200px; border:2px solid #ccc; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);"
                                                class="mx-auto d-block mb-4" 
                                            />
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h4 class="text-info mb-3 mt-1">Thông tin kỹ thuật viên</h4>
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
                                                    <input type="text" class="form-control" value="{{ $detail->user->full_name ?? 'Chưa cập nhật' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Số điện thoại</label>
                                                    <input type="text" class="form-control" value="{{ $detail->user->phone ?? 'Chưa cập nhật' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Ngày sinh</label>
                                                    <input type="date" class="form-control" value="{{ $detail->user->dob ?? 'Chưa cập nhật' }}">
                                                </div> 
                                            </div>
                                        </div>                               
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Địa chỉ</label>
                                                    <input type="text" class="form-control" value="{{ $detail->user->address ?? 'Chưa cập nhật'}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" value="{{ $detail->user->email ?? 'Chưa cập nhật' }}">
                                                </div>
                                            </div>                                          
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('mainM.maintenance_detail', $main_id)}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
