@if (session('msg'))
    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-end align-items-end"
        style="min-height: 100px; position: fixed; bottom: 20px; right: 20px; z-index: 1;">
        <div class="toast" role="alert" data-delay="3000">
            <div class="toast-header">
                <strong class="mr-auto">Thông báo</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                {{ session('msg') }}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.toast').toast('show');
        });
    </script>
@endif
