<div class="navbar-nav w-100 overflow-auto" style="height: 410px">
    {{-- <div class="nav-item dropdown">
        <a href="#" class="nav-link" data-toggle="dropdown">Dresses <i
                class="fa fa-angle-down float-right mt-1"></i></a>
        <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
            <a href="" class="dropdown-item">Men's Dresses</a>
            <a href="" class="dropdown-item">Women's Dresses</a>
            <a href="" class="dropdown-item">Baby's Dresses</a>
        </div>
    </div> --}}
    <a href="{{ route('client.shop') }}" class="btn text-left nav-item nav-link">
        <i class="fa fa-arrow-right"></i>
        Xem toàn bộ sản phẩm
        <i class="fa fa-arrow-left"></i>
    </a>
    @if (isset($categoryList) && $categoryList->count() > 0)
        @foreach ($categoryList as $category)
            <form action="{{ route('client.shop') }}" method="get">
                <button type="submit" class="btn text-left nav-item nav-link">
                    <input type="hidden" name="category" value="{{ $category->slug }}">
                    {{ Str::title($category->name) }}
                </button>
            </form>
        @endforeach
    @else
        <p class="text-muted p-3">Chưa có danh mục nào.</p>
    @endif
</div>
