<div class="card mb-4">
    <div class="card-header">
        <h5>Tulis Review Anda</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('items.reviews.store', $item->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div class="star-rating">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="star" value="{{ $i }}" {{ old('star') == $i ? 'checked' : '' }}>
                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                    @endfor
                </div>
                @error('star')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Komentar</label>
                <textarea name="comment" class="form-control" rows="3" required>{{ old('comment') }}</textarea>
                @error('comment')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Kirim Review</button>
        </form>
    </div>
</div>
