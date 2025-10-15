@csrf

{{-- Hiển thị lỗi validation --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label">Phim</label>
    <select name="movie_id" class="form-select" required>
        <option value="">-- Chọn phim --</option>
        @foreach($movies as $movie)
            <option value="{{ $movie->id }}"
                {{ old('movie_id', $showtime->movie_id ?? '') == $movie->id ? 'selected' : '' }}>
                {{ $movie->title }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Phòng chiếu</label>
    <select name="room_id" class="form-select" required>
        <option value="">-- Chọn phòng --</option>
        @foreach($rooms as $room)
            <option value="{{ $room->id }}"
                {{ old('room_id', $showtime->room_id ?? '') == $room->id ? 'selected' : '' }}>
                {{ $room->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Thời gian chiếu</label>
    <input type="datetime-local" name="start_time" class="form-control"
        value="{{ old('start_time', isset($showtime->start_time) ? date('Y-m-d\TH:i', strtotime($showtime->start_time)) : '') }}"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Giá vé (VNĐ)</label>
    <input type="number" name="price" class="form-control"
        value="{{ old('price', $showtime->price ?? '') }}" min="0" step="1000" required>
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-success">💾 Lưu</button>
    <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>
</div>
