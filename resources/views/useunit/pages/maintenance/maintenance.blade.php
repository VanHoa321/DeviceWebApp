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
                            <div id="review">
                                @if ($maintenance->status == 3 && $review->status == 0)
                                    <a type="button" class="btn btn-success" data-toggle="modal" data-target="#model-review">
                                        <i class="fa-solid fa-star" title="Đánh giá công việc"></i>
                                    </a>
                                @else
                                    <h3>Chi tiết đơn bảo trì</h3>
                                @endif
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
                                            <td><img src="{{ $items->user->avatar }}" class="" alt="" style="width: 80px; height: 80px"></td>
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
                                            <a href="{{route('main.detail', $items->detail_id)}}" class="btn btn-info btn-sm" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>                                                         
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('main.index')}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
                        </div>    
                    </div>
                </div>
                <div class="modal fade" id="model-review">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Đánh giá công việc</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Chất lượng làm việc</label>
                                    <select name="quality" class="form-control select2bs4">
                                        <option value="1" {{ $review->quality == 1 ? 'selected' : '' }}>Rất tệ</option>
                                        <option value="2" {{ $review->quality == 2 ? 'selected' : '' }}>Tệ</option>
                                        <option value="3" {{ $review->quality == 3 ? 'selected' : '' }}>Bình thường</option>
                                        <option value="4" {{ $review->quality == 4 ? 'selected' : '' }}>Hài lòng</option>
                                        <option value="5" {{ $review->quality == 5 ? 'selected' : '' }}>Rất hài lòng</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Thái độ làm việc</label>
                                    <select name="attitude" class="form-control select2bs4">
                                        <option value="1" {{ $review->attitude == 1 ? 'selected' : '' }}>Rất tệ</option>
                                        <option value="2" {{ $review->attitude == 2 ? 'selected' : '' }}>Tệ</option>
                                        <option value="3" {{ $review->attitude == 3 ? 'selected' : '' }}>Bình thường</option>
                                        <option value="4" {{ $review->attitude == 4 ? 'selected' : '' }}>Hài lòng</option>
                                        <option value="5" {{ $review->attitude == 5 ? 'selected' : '' }}>Rất hài lòng</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Phản ứng công việc</label>
                                    <select name="response" class="form-control select2bs4">
                                        <option value="1" {{ $review->response == 1 ? 'selected' : '' }}>Rất tệ</option>
                                        <option value="2" {{ $review->response == 2 ? 'selected' : '' }}>Tệ</option>
                                        <option value="3" {{ $review->response == 3 ? 'selected' : '' }}>Bình thường</option>
                                        <option value="4" {{ $review->response == 4 ? 'selected' : '' }}>Hài lòng</option>
                                        <option value="5" {{ $review->response == 5 ? 'selected' : '' }}>Rất hài lòng</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Mô tả thêm</label>
                                    <textarea class="form-control mb-3" name="description" placeholder="Nhập mô tả thêm" style="height: 100px">{{ $review->description }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <button type="button" data-id="{{$review->review_id}}" class="btn btn-success btn-save-review">Đánh giá</button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal -->
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script src="{{asset("assets/plugins/select2/js/select2.full.min.js")}}"></script>
<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

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
                            $('a[data-id="' + id + '"]').closest('td').find('.btn-cancel-main').hide();
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

        $('body').on('click', '.btn-save-review', function (e) {
            e.preventDefault();
            
            var quality = $('select[name="quality"]').val();
            var attitude = $('select[name="attitude"]').val();
            var response = $('select[name="response"]').val();
            var description = $('textarea[name="description"]').val();
            var review_id = $(this).data('id');
            $.ajax({
                url: "/use-unit/review",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    review_id: review_id,
                    quality: quality,
                    attitude: attitude,
                    response: response,
                    description: description,
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#model-review').modal('hide');
                        $('#review').html(`
                            <h3>Chi tiết đơn bảo trì</h3>
                        `);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error:", error);
                    toastr.error('Có lỗi khi gửi đánh giá');
                }
            });
        });
    })
</script>                              
@endsection

