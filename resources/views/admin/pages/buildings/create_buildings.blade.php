@extends('master_layout')
@section('title', 'Thêm mới tòa nhà')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Thêm mới tòa nhà</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý tòa nhà</li>
                        <li class="breadcrumb-item active">Thêm mới tòa nhà</li>
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
                        <form method="post" action="{{route("buildings.store")}}" id="quickForm">
                            @csrf
                            <div class="card-body">                                
                                <div class="form-group">
                                    <label>Tên tòa nhà</label>
                                    <input type="text" name="name" class="form-control" placeholder="Nhập tên tòa nhà" value="{{ old('name') }}">
                                </div>       
                                <div class="form-group">
                                    <label>Cơ sở</label>
                                    <select name="branch_id" class="form-control select2bs4">
                                        <option value="0" {{ old('branch_id') == 0 ? 'selected' : '' }}>---Chọn cơ sở---</option>
                                        @foreach($listBranch as $item);
                                            <option value="{{$item->branch_id}}" {{ old('branch_id') == $item->branch_id ? 'selected' : '' }}>{{$item->branch_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label asp-for="description">Mô tả thêm</label>
                                    <textarea class="form-control mb-3" name="description" placeholder="Nhập mô tả thêm" style=" height: 100px">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('buildings.index')}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
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
                        required: "Tên tòa nhà không được để trống",
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

            setTimeout(function() {
                $("#myAlert").fadeOut(500);
            },3500);
        });
    </script>
@endsection
