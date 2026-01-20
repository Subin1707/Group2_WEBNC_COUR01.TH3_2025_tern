@extends('layouts.app')

@section('content')

<div class="container">
    <h4 class="mb-3">📩 Hỗ trợ khách hàng</h4>

```
{{-- USER tạo ticket --}}
@if(auth()->user()->isUser())
    <a href="{{ route('support.create') }}" class="btn btn-primary mb-3">
        ➕ Tạo ticket mới
    </a>
@endif

<div class="card shadow-sm">
    <table class="table mb-0 align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Tiêu đề</th>
                <th>Danh mục</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th class="text-end"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
                <tr>
                    <td>#{{ $ticket->id }}</td>

                    <td>
                        {{ $ticket->subject }}
                        @if($ticket->booking)
                            <div class="small text-muted">
                                🎟 Booking #{{ $ticket->booking->id }}
                            </div>
                        @endif
                    </td>

                    <td>{{ ucfirst($ticket->category) }}</td>

                    <td>
                        @php
                            $statusColor = match($ticket->status) {
                                'open' => 'warning',
                                'processing' => 'primary',
                                'answered' => 'success',
                                'closed' => 'secondary',
                                default => 'light'
                            };
                        @endphp
                        <span class="badge bg-{{ $statusColor }}">
                            {{ strtoupper($ticket->status) }}
                        </span>
                    </td>

                    <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>

                    <td class="text-end">
                        <a href="{{ route('support.show', $ticket) }}"
                           class="btn btn-sm btn-outline-primary">
                            💬 Xem chat
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
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
```

</div>
@endsection
