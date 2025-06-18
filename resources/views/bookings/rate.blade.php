<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rate Your Booking') }}
            </h2>
            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-primary btn-lg shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Booking
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #f6c23e, #dda20a);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-star me-2"></i>Rate Your Experience
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Booking Summary -->
                        <div class="booking-summary mb-4 p-4 rounded-3" style="background: linear-gradient(135deg, rgba(78, 115, 223, 0.1), rgba(34, 74, 190, 0.1));">
                            <h6 class="fw-bold mb-3 text-primary">Booking Summary</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="text-muted small">Booking ID</div>
                                    <div class="fw-bold">#{{ $booking->id }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small">Service</div>
                                    <div class="fw-bold">{{ $booking->service->name }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small">Date & Time</div>
                                    <div class="fw-bold">{{ $booking->scheduled_at->format('d M Y H:i') }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small">Status</div>
                                    <div class="fw-bold">
                                        <span class="badge rounded-pill text-white px-3 py-2" 
                                              style="background: linear-gradient(135deg, #1cc88a, #13855c);">
                                            <i class="fas fa-check-double me-1"></i> Completed
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('bookings.submitRate', $booking) }}">
                            @csrf
                            
                            <!-- Hidden technician field if there's only one technician -->
                            @if(count($technicians) === 1)
                                <input type="hidden" name="technician_id" value="{{ $technicians[0]->id }}">
                                <div class="alert border-0 p-3 mb-4" style="background: rgba(28, 200, 138, 0.1); color: #13855c; border-left: 4px solid #1cc88a;">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="fas fa-info-circle fa-2x"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Rating for {{ $technicians[0]->user->name }}</h6>
                                            <p class="mb-0">You are rating the service provided by this technician.</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mb-4">
                                    <label for="technician_id" class="form-label fw-bold text-primary">
                                        <i class="fas fa-user-cog me-2"></i>Select Technician to Rate
                                    </label>
                                    <select class="form-select form-select-lg border-0 shadow-sm" id="technician_id" name="technician_id" required>
                                        @foreach($technicians as $technician)
                                            <option value="{{ $technician->id }}" {{ old('technician_id', $rating->technician_id ?? '') == $technician->id ? 'selected' : '' }}>
                                                {{ $technician->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-primary">
                                    <i class="fas fa-star me-2"></i>Your Rating
                                </label>
                                <div class="rating-container p-4 bg-light rounded-3 text-center">
                                    <div class="star-rating mb-3">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating', $rating->rating ?? '') == $i ? 'checked' : '' }} required />
                                            <label for="star{{ $i }}" title="{{ $i }} stars">
                                                <i class="fas fa-star fa-2x"></i>
                                            </label>
                                        @endfor
                                    </div>
                                    <div class="rating-text fw-bold mt-2">Select your rating</div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="review" class="form-label fw-bold text-primary">
                                    <i class="fas fa-comment-alt me-2"></i>Your Review (Optional)
                                </label>
                                <textarea class="form-control border-0 shadow-sm" id="review" name="review" rows="4" placeholder="Share your experience with our service...">{{ old('review', $rating->review ?? '') }}</textarea>
                            </div>
                            
                            <div class="alert border-0 p-3" style="background: rgba(246, 194, 62, 0.1); color: #dda20a; border-left: 4px solid #f6c23e;">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-info-circle fa-2x"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Your Feedback Matters</h6>
                                        <p class="mb-0">Your honest feedback helps us improve our services and helps other customers make informed decisions.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary btn-lg px-5">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-warning btn-lg px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Rating
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Star Rating */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
        }
        
        .star-rating input {
            display: none;
        }
        
        .star-rating label {
            cursor: pointer;
            color: #ddd;
            font-size: 1.5rem;
            padding: 0 0.2rem;
            transition: all 0.3s ease;
        }
        
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #f6c23e;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ratingInputs = document.querySelectorAll('input[name="rating"]');
        const ratingText = document.querySelector('.rating-text');
        const ratingLabels = ['Select your rating', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
        
        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                ratingText.textContent = ratingLabels[this.value];
            });
            
            // Set initial text if a rating is already selected
            if (input.checked) {
                ratingText.textContent = ratingLabels[input.value];
            }
        });
    });
    </script>
    @endpush
</x-app-layout>