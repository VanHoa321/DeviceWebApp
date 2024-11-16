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
                            <li class="breadcrumb-item"><a href="#">Bộ phận sử dụng</a></li>
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
                        <div class="small-box bg-warning">
                            <div class="inner text-white">
                                <h3>Báo hỏng</h3>
                                <p>Tạo đơn bảo trì thiết bị</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <a href="{{route('report.index')}}" class="small-box-footer"><span style="color:white">Chi tiết <i class="fas fa-arrow-circle-right"></i></span></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$maintenanceCount}}</h3>
                                <p>Đơn bảo trì đã tạo</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{route('main.index')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$deviceCount}}</h3>
                                <p>Thiết bị đã báo hỏng</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-laptop"></i>
                            </div>
                            <a href="{{route('main.index')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>                   
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$completeCount}}</h3>
                                <p>Đơn bảo trì thành công</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{route('main.index')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
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
                                <h3 class="card-title">Thiết bị hay báo hỏng</h3>
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
                                <h3 class="card-title">Thiết bị hay báo hỏng</h3>
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
                                <h3 class="card-title">Trạng thái bảo trì</h3>
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
                                    <canvas id="donutChartStatus" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Phòng hay báo hỏng</h3>
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
                url: '/use-unit/trang-chu',
                method: 'GET',
                data: {
                    timeType: timeType,
                    startDate: startDate,
                    endDate: endDate  
                },
                success: function (response) {
                    var topDeviceReport = response.topDeviceReport;
                    var maintenanceStatus = response.maintenanceStatus;
                    var topRoomsByFailures = response.topRoomsByFailures;
                    // Xử lý topDeviceReport (biểu đồ donut)
                    var labels = [];
                    var data = [];
                    topDeviceReport.forEach(function(item) {
                        labels.push(item.name);
                        data.push(item.failure_count);
                    });
                    renderDonutChart(labels, data);

                    //Xử lý maintenanceStatus
                    var labelStatus = [];
                    var dataStatus = [];
                    maintenanceStatus.forEach(function(item) {
                        labelStatus.push(item.name);
                        dataStatus.push(item.failure_count);
                    });
                    renderDonutChartStatus(labelStatus, dataStatus);
                
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
                    backgroundColor: ['#f56954', '#17a2b8', '#f39c12', '#00c0ef', '#3c8dbc'],
                }]
            };
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData
            });
        }

        function renderDonutChartStatus(labels, data) {
            var donutChartCanvas = $('#donutChartStatus').get(0).getContext('2d');
            var donutData = {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#f56954', '#007bff', '#17a2b8', '#28a745'],
                }]
            };
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData
            });
        }

        // Hàm render bar chart cho phòng
        function renderBarChartRoom(labels, data) {
            var barChartCanvas = $('#barChartRoom').get(0).getContext('2d');
            var barChartData = {
                labels: labels,
                datasets: [{
                    label: 'Số lần hỏng theo phòng',
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