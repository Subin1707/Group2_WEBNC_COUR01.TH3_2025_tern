@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">📩 Hỗ trợ khách hàng</h4>

    @if(auth()->user()->role === 'user')
        <a href="{{ route('support.create') }}" class="btn btn-primary mb-3">
            ➕ Tạo ticket mới
        </a>
    @endif

    <div class="card">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tiêu đề</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
                        <td>{{ $ticket->subject }}</td>
                        <td>{{ ucfirst($ticket->category) }}</td>
                        <td>
                            <span class="badge bg-{{ $ticket->status === 'closed' ? 'secondary' : 'info' }}">
                                {{ strtoupper($ticket->status) }}
                            </span>
                        </td>
                        <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('support.show', $ticket) }}"
                               class="btn btn-sm btn-outline-primary">
                                💬 Xem
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Chưa có ticket nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $tickets->links() }}
    </div>
</div>
@endsection
