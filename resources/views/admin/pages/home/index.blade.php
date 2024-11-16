@extends('master_layout')
@section('title', 'Trang chủ')
@section('content')
<style>
    .content-wrapper {
        min-height: 100%;
        height: auto;
    }
</style>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Trang chủ</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Quản trị viên</a></li>
                            <li class="breadcrumb-item active">Trang chủ</li>
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
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$deviceCount}}</h3>
                                <p>Thiết bị quản lý</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-laptop"></i>
                            </div>
                            <a href="{{route('device.index')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$buildingCount}}</h3>
                                <p>Dãy nhà được quản lý</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{route('buildings.index')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner text-white">
                                <h3>{{$userCount}}</h3>
                                <p>Người dùng hệ thống</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{route('user.index')}}" class="small-box-footer"><span style="color:white">Chi tiết <i class="fas fa-arrow-circle-right"></i></span></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$roomCount}}</h3>
                                <p>Phòng được quản lý</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{route('room.index')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Lọc thống kê</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="mb-1">
                                                <button type="button" id="filterDay" class="btn btn-info">Hôm nay</button>
                                            </div>
                                            <div class="mb-1">
                                                <button type="button" id="filterWeek" class="btn btn-info">Tuần này</button>
                                            </div>
                                            <div class="mb-1">
                                                <button type="button" id="filterMonth" class="btn btn-info">Tháng này</button>
                                            </div>
                                            <div class="mb-1">
                                                <button type="button" id="filterYear" class="btn btn-info">Năm này</button>
                                            </div>
                                            <div class="mb-1">
                                                <button type="button" id="all" class="btn btn-info">Tất cả</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="d-flex" id="customRange">
                                                    <!-- Từ ngày -->
                                                    <div class="col-md-6 mb-3 me-3">
                                                        <div class="d-flex align-items-center">
                                                            <label for="startDate" class="form-label mb-0 me-2 w-auto" style="min-width: 70px;">Từ ngày</label>
                                                            <input type="date" id="startDate" class="form-control">
                                                        </div>
                                                    </div>
                                                    <!-- Đến ngày -->
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <label for="endDate" class="form-label mb-0 me-2 w-auto" style="min-width: 70px;">Đến ngày</label>
                                                            <input type="date" id="endDate" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" id="filterButton" class="btn btn-success">
                                                    Tìm
                                                </button>                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-md-8">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Thiết bị hay hỏng</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example-table-2" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Hình ảnh</th>
                                                            <th>Tên thiết bị</th>
                                                            <th>Số hiệu</th>
                                                            <th>Số lần hỏng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $counter = 1;
                                                        @endphp
                                                        @foreach ($topDeviceReport as $item)
                                                            <tr>
                                                                <td>{{ $counter++ }}</td>
                                                                <td><img src="{{ $item->image}}" alt="Hình ảnh" width="70" height="70"></td>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->code }}</td>
                                                                <td>{{ $item->failure_count }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Thiết bị hay hỏng</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="donutChart" style="min-height: 386px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Phòng hay hỏng nhất</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChartRoom" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Phân loại hay hỏng</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </section>
    </div>
@endsection
<script>
    setTimeout(function() {
        $("#myAlert").fadeOut(500);
    }, 3500);
</script>
@section('scripts')
<script src="{{asset("assets/plugins/chart.js/Chart.min.js")}}"></script>
<script>
    $(document).ready(function() {
        loadData('all');

        $('#filterDay, #filterWeek, #filterMonth, #filterYear, #all').click(function () {
            var timeType = $(this).attr('id');
            loadData(timeType);
        });

        $('#filterButton').click(function () {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            if (!startDate || !endDate) {
                toastr.error('Vui lòng chọn thời gian thống kê');
                return;
            }

            var start = new Date(startDate);
            var end = new Date(endDate);
            if (start > end) {
                toastr.error('Ngày bắt đầu không thể lớn hơn ngày kết thúc');
                return;
            }
            loadData('custom', startDate, endDate);
        });

        function loadData(timeType, startDate = null, endDate = null) {
            $.ajax({
                url: '/admin/trang-chu',
                method: 'GET',
                data: {
                    timeType: timeType,
                    startDate: startDate,
                    endDate: endDate  
                },
                success: function (response) {
                    var topDeviceReport = response.topDeviceReport;
                    var failureByCategory = response.failureByCategory;
                    var topRoomsByFailures = response.topRoomsByFailures;

                    // Xử lý topDeviceReport (biểu đồ donut)
                    var labels = [];
                    var data = [];
                    topDeviceReport.forEach(function(item) {
                        labels.push(item.name);
                        data.push(item.failure_count);
                    });
                    renderDonutChart(labels, data);

                    // Xử lý failureByCategory (biểu đồ cột)
                    var categoryLabels = [];
                    var categoryData = [];
                    failureByCategory.forEach(function(item) {
                        categoryLabels.push(item.category_name);
                        categoryData.push(item.failure_count);
                    });
                    renderBarChart(categoryLabels, categoryData);

                    // Xử lý topRoomsByFailures (biểu đồ cột cho phòng)
                    var roomLabels = [];
                    var roomData = [];
                    topRoomsByFailures.forEach(function(item) {
                        roomLabels.push(item.room_name);
                        roomData.push(item.failure_count);
                    });
                    renderBarChartRoom(roomLabels, roomData);
                },
                error: function(xhr) {
                    console.error("Lỗi khi gọi AJAX:", xhr.responseText);
                }
            });
        }

        // Hàm render donut chart
        function renderDonutChart(labels, data) {
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
            var donutData = {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
                }]
            };
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData
            });
        }

        // Hàm render bar chart (thiết bị)
        function renderBarChart(labels, data) {
            var barChartCanvas = $('#barChart').get(0).getContext('2d');
            var barChartData = {
                labels: labels,
                datasets: [{
                    label: 'Số lần hỏng theo phân loại thiết bị',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    borderWidth: 1,
                    data: data,
                }]
            };
            
            var barChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true,
                        },
                        ticks: {
                            beginAtZero: true
                        },
                        barPercentage: 0.15,
                    }],
                    yAxes: [{
                        gridLines: {
                            display: true,
                        },
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    }]
                }
            };

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });
        }

        // Hàm render bar chart cho phòng
        function renderBarChartRoom(labels, data) {
            var barChartCanvas = $('#barChartRoom').get(0).getContext('2d');
            var barChartData = {
                labels: labels,
                datasets: [{
                    label: 'Số lần hỏng theo phòng',
                    backgroundColor: 'rgba(128, 128, 128, 0.8)',
                    borderColor: 'rgba(128, 128, 128, 1)',
                    borderWidth: 1,
                    data: data,
                }]
            };

            var barChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true,
                        },
                        ticks: {
                            beginAtZero: true
                        },
                        barPercentage: 0.15,
                    }],
                    yAxes: [{
                        gridLines: {
                            display: true,
                        },
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    }]
                }
            };

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });
        }

        // Hàm render area chart (biểu đồ đường)
        function renderAreaChart(labels, data) {
            var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
            var areaChartData = {
                labels: labels,
                datasets: [{
                    label: 'Số lần hỏng theo phòng',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: data
                }]
            };

            var areaChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        }
                    },
                    y: {
                        grid: {
                            display: true,
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    }
                }
            };

            new Chart(areaChartCanvas, {
                type: 'line',
                data: areaChartData,
                options: areaChartOptions
            });
        }
    });
</script>
@endsection