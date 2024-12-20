@extends('master_layout')
@section('title', 'Thêm mới phòng')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Thêm mới phòng</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý phòng</li>
                        <li class="breadcrumb-item active">Thêm mới phòng</li>
                    </ol>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div style="position: fixed; top: 70px; right: 16px; width: auto; z-index: 999" id="myAlert">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-check2 text-danger"></i> {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form method="post" action="{{route("room.store")}}" id="quickForm">
                            @csrf
                            <div class="card-body">                                
                                <div class="form-group">
                                    <label>Tên phòng</label>
                                    <input type="text" name="name" class="form-control" placeholder="Nhập tên phòng">
                                </div>       
                                <div class="form-group">
                                    <label>Tên tòa nhà</label>
                                    <select name="building_id" class="form-control select2bs4">
                                        <option value="0">---Chọn tòa nhà---</option>
                                        @foreach($listBuildings as $item);
                                        <option value="{{$item->building_id}}">{{$item->name}}, {{$item->branch->branch_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label asp-for="description">Mô tả thêm</label>
                                    <textarea class="form-control mb-3" name="description" placeholder="Nhập mô tả thêm" style=" height: 100px"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('room.index')}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk" title="Lưu"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
    <script src="{{asset("assets/plugins/jquery-validation/jquery.validate.min.js")}}"></script>
    <script src="{{asset("assets/plugins/jquery-validation/additional-methods.min.js")}}"></script>
    <script src="{{asset("assets/plugins/select2/js/select2.full.min.js")}}"></script>
    <script src="{{asset("assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js")}}"></script>

    <script>
        $(function () {
            $('#quickForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2,
                    }
                },
                messages: {
                    name: {
                        required: "Tên phòng không được để trống",
                        minlength: "Tên tòa nhà phải có ít nhất {0} ký tự!"
                    }                 
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
