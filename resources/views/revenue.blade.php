@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center text-white">📊 Thống kê doanh thu</h2>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card bg-dark text-white shadow">
                <div class="card-header text-center">
                    <strong>Doanh thu theo tháng</strong>
                </div>
                <div class="card-body">
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card bg-dark text-white shadow">
                <div class="card-header text-center">
                    <strong>Doanh thu theo phim</strong>
                </div>
                <div class="card-body">
                    <canvas id="movieRevenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dữ liệu từ controller (chuyển sang JSON)
    const monthlyLabels = @json($monthlyRevenue['labels']);
    const monthlyData = @json($monthlyRevenue['data']);
    const movieLabels = @json($movieRevenue['labels']);
    const movieData = @json($movieRevenue['data']);

    // Biểu đồ 1: Doanh thu theo tháng
    new Chart(document.getElementById('monthlyRevenueChart'), {
        type: 'pie',
        data: {
            labels: monthlyLabels,
            datasets: [{
                data: monthlyData,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
            }]
        },
    });

    // Biểu đồ 2: Doanh thu theo phim
    new Chart(document.getElementById('movieRevenueChart'), {
        type: 'doughnut',
        data: {
            labels: movieLabels,
            datasets: [{
                data: movieData,
                backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF']
            }]
        },
    });
</script>
@endsection
