@extends('admin.layout.master')

@section('content')
    <!-- Small boxes (Stat box) -->
    <form action="{{ route('admin.report.saleSummary') }}" method="GET">
        <div class="d-flex align-items-baseline mb-3">
            <div class="form-group mr-3">
                <input type="date" class="form-control" name="start_date" id="startDate"
                    value="{{ request('start_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
            </div>
            <div class="form-group mr-3">
                <input type="date" class="form-control" name="end_date" id="endDate"
                    value="{{ request('end_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
            </div>
            <button type="submit" class="btn btn-primary">Lọc báo cáo</button>
        </div>
    </form>
    <div class="row g-2">
        <div class="col-md-6 mb-3">
            <div class="card w-100">
                <div class="card-header">
                    <h3 class="card-title">
                        Tổng doanh thu
                    </h3>
                </div>
                <div>
                    <h3 class="p-3">{{ Number::currency($summaryData['netSale']) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Tổng hóa đơn
                    </h3>
                </div>
                <div>
                    <h3 class="p-3">{{ $summaryData['totalOrders'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-line mr-1"></i>
                Báo cáo doanh thu theo ngày
            </h3>
        </div>
        <div class="card-body d-flex justify-content-center align-items-center">
            <div class="w-100 h-100" id="daily_net_sale_chart"></div>
        </div>
    </div>
@endsection
@section('my-js')
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawDailyNetSaleChart);

        function drawDailyNetSaleChart() {
            var rawData = @json($dailyNetSaleReport);

            // Tạo DataTable
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Ngày');
            data.addColumn('number', 'Doanh thu');

            // Thêm các hàng dữ liệu từ rawData
            if (rawData.length > 1) {
                for (var i = 1; i < rawData.length; i++) {
                    data.addRow(rawData[i]);
                }
            }

            // Tính toán số ngày cuối cùng để đặt trục X
            // var daysInMonth = 0;
            // if (data.getNumberOfRows() > 0) {
            //     daysInMonth = data.getValue(data.getNumberOfRows() - 1, 0);
            // } else {
            //     daysInMonth = 31;
            // }

            // Tạo mảng các tick từ 1 đến daysInMonth
            // var ticksArray = [];
            // for (var i = 1; i <= daysInMonth; i++) {
            //     ticksArray.push(i);
            // }

            var options = {
                legend: {
                    position: 'none'
                },
                hAxis: {
                    slantedTextAngle: 45
                },
                vAxis: {
                    format: 'short'
                },
                pointSize: 5,
                colors: ['#34A853'],
                chartArea: {
                    left: '7%',
                    top: '10%',
                    width: '90%',
                    height: '80%'
                }
            };

            var chart = new google.visualization.AreaChart(document.getElementById('daily_net_sale_chart'));
            chart.draw(data, options);
        }
    </script>
@endsection
