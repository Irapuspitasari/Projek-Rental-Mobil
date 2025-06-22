<div class="card mt-4">
    <div class="card-header">
        <h5>Ulasan Produk</h5>
        <div class="d-flex align-items-center">
            <div class="rating-average me-3">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $i <= $item->averageRating() ? '' : '-empty' }} text-warning"></i>
                @endfor
                <span>{{ number_format($item->averageRating(), 1) }}/5</span>
            </div>
            <span>{{ $item->reviews->count() }} ulasan</span>
        </div>
    </div>
    <div class="card-body">
        @forelse($item->reviews as $review)
            <div class="review-item mb-4 pb-3 border-bottom {{ $review->user_id == Auth::id() ? 'bg-light' : '' }}"
                 id="{{ $review->user_id == Auth::id() ? 'user-review' : '' }}">
                <div class="d-flex justify-content-between">
                    <div class="user-info">
                        <strong>{{ $review->user->name }}</strong>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $review->star ? '' : '-empty' }} text-warning"></i>
                            @endfor
                            <span class="text-muted ms-2">{{ $review->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    @can('update', $review)
                        <div class="review-actions">
                            <button class="btn btn-sm btn-outline-warning edit-review"
                                    data-id="{{ $review->id }}"
                                    data-star="{{ $review->star }}"
                                    data-comment="{{ $review->comment }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus review ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
                <div class="review-content mt-2">
                    <p>{{ $review->comment }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <i class="fas fa-comment-slash fa-2x text-muted mb-3"></i>
                <p class="text-muted">Belum ada ulasan untuk produk ini</p>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit review button clicks
    document.querySelectorAll('.edit-review').forEach(button => {
        button.addEventListener('click', function() {
            const reviewId = this.dataset.id;
            const star = this.dataset.star;
            const comment = this.dataset.comment;

            // Set form action
            document.getElementById('edit-review-form').action = `/reviews/${reviewId}`;

            // Set star rating
            document.querySelector(`#edit-review-form input[value="${star}"]`).checked = true;

            // Set comment
            document.getElementById('edit-review-comment').value = comment;

            // Show modal
            new bootstrap.Modal(document.getElementById('editReviewModal')).show();
        });
    });
});
</script>
@endpush
