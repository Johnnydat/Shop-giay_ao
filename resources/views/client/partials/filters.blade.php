<div class="col-lg-3 filter-sidebar p-4">
    <form method="GET" action="{{ route('shop') }}">
        <!-- Danh mục -->
        <div class="filter-group mb-4">
            <h6 class="mb-3 filter-title">Danh mục</h6>
            @foreach ($categories as $category)
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="cat-{{ $category->id }}" name="categories[]"
                        value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                    <label class="form-check-label" for="cat-{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <!-- Khoảng giá -->
        <div class="filter-group mt-4">
            <div class="filter-header">
                <h6 class="filter-title">Khoảng giá</h6>
            </div>

            <!-- Các nút lọc giá mặc định -->
            <div class="btn-group btn-group-sm mb-3 w-100" role="group">
                <input type="radio" class="btn-check filter-price" name="price_range"
                    id="price-duoi-500k" value="duoi-500k" data-min="0"
                    data-max="500000" {{ $selectedPriceRange == 'duoi-500k' ? 'checked' : '' }}>
                <label class="btn category-badge" for="price-duoi-500k">
                    Dưới 500k
                </label>

                <input type="radio" class="btn-check filter-price" name="price_range"
                    id="price-500k-1m" value="500k-1m" data-min="500000"
                    data-max="1000000" {{ $selectedPriceRange == '500k-1m' ? 'checked' : '' }}>
                <label class="btn category-badge" for="price-500k-1m">
                    500k - 1 triệu
                </label>

                <input type="radio" class="btn-check filter-price" name="price_range"
                    id="price-1m-5m" value="1m-5m" data-min="1000000"
                    data-max="5000000" {{ $selectedPriceRange == '1m-5m' ? 'checked' : '' }}>
                <label class="btn category-badge" for="price-1m-5m">
                    1 triệu - 5 triệu
                </label>

                <input type="radio" class="btn-check filter-price" name="price_range"
                    id="price-tren-5m" value="tren-5m" data-min="5000000"
                    data-max="100000000" {{ $selectedPriceRange == 'tren-5m' ? 'checked' : '' }}>
                <label class="btn category-badge" for="price-tren-5m">
                    Trên 5 triệu
                </label>
            </div>

            <!-- Thanh trượt tùy chỉnh -->
            <div class="mt-3">
                <input type="range" class="form-range price-range" min="0"
                    max="10000000" value="{{ $maxPrice }}" id="priceRange"
                    step="100000">
                <div class="d-flex justify-content-between mt-2">
                    <span class="text-muted small" id="minPriceLabel">0đ</span>
                    <span class="text-muted small" id="maxPriceLabel">{{ number_format($maxPrice) }}</span>
                </div>

                <input type="hidden" name="min_price" id="minPriceInput" value="{{ $minPrice }}">
                <input type="hidden" name="max_price" id="maxPriceInput" value="{{ $maxPrice }}">
            </div>
        </div>

        <button type="submit" class="btn w-100 mt-3" style="background-color: var(--gold); color: black;">Lọc kết quả</button>
        <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 mt-2">Xóa bộ lọc</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const minInput = document.getElementById('minPriceInput');
        const maxInput = document.getElementById('maxPriceInput');
        const rangeSlider = document.getElementById('priceRange');
        const maxPriceLabel = document.getElementById('maxPriceLabel');
        const minPriceLabel = document.getElementById('minPriceLabel');

        // Hàm định dạng tiền
        function formatMoney(amount) {
            if (amount >= 1000000) {
                return (amount / 1000000).toFixed(1) + 'tr';
            } else if (amount >= 1000) {
                return (amount / 1000).toFixed(0) + 'k';
            }
            return amount.toLocaleString() + 'đ';
        }

        // Xử lý radio lọc giá mặc định
        document.querySelectorAll('.filter-price').forEach(radio => {
            radio.addEventListener('change', function() {
                const min = parseInt(this.dataset.min);
                const max = parseInt(this.dataset.max);

                if (isNaN(min) || isNaN(max)) {
                    alert('Giá trị không hợp lệ!');
                    return;
                }

                minInput.value = min;
                maxInput.value = max;

                // Cập nhật giao diện thanh trượt
                rangeSlider.value = max;
                minPriceLabel.textContent = formatMoney(min);
                maxPriceLabel.textContent = formatMoney(max);

                // Submit form
                this.closest('form').submit();
            });
        });

        // Thanh trượt tự chỉnh giá
        if (rangeSlider) {
            rangeSlider.addEventListener('input', function() {
                const value = parseInt(this.value);
                maxInput.value = value;
                maxPriceLabel.textContent = formatMoney(value);

                // Bỏ chọn radio nếu dùng thanh trượt
                document.querySelectorAll('.filter-price').forEach(radio => {
                    radio.checked = false;
                });
            });
        }
    });
</script>
