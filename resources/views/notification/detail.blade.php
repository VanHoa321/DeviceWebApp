@extends('master_layout')
@section('title', 'Chi tiết thông báo')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý thông báo</li>
                        <li class="breadcrumb-item active">Chi tiết thông báo</li>
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
                                <div class="col-md-12">
                                    <h4 class="text-info mb-3 mt-1">Chi tiết thông báo</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ngày nhận</label>
                                                <input type="date" class="form-control" value="{{ $noti->created_at }}">
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Người gửi</label>
                                                <input type="text" class="form-control" value="{{ $noti->user->full_name }}">
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <input type="text" class="form-control" value="{{ $noti->user->phone }}">
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" value="{{ $noti->user->email }}">
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Đơn vị</label>
                                                <input type="text" class="form-control" value="{{ $noti->user->unit->name }}">
                                            </div> 
                                        </div>
                                    </div>                                     
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nội dung</label>
                                                <textarea class="form-control" rows="5">{{$noti->message}}</textarea>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('noti.index')}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
