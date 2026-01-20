@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">📊 Dashboard CSKH</h4>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>{{ $stats['open'] }}</h5>
                    <p>Ticket mở</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>{{ $stats['processing'] }}</h5>
                    <p>Đang xử lý</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>{{ $stats['closed'] }}</h5>
                    <p>Đã đóng</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
