<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-lightning-charge-fill me-2"></i> Quick Action
        </h3>
    </div>

    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-3 col-sm-6 col-12">
                <a href="{{ route('items.create') }}" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-plus-circle me-2"></i>
                    Tambah Barang
                </a>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <a href="{{ route('item-ins.create') }}" class="btn btn-success w-100 py-2">
                    <i class="bi bi-box-arrow-in-down me-2"></i>
                    Barang Masuk
                </a>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <a href="{{ route('item-outs.create') }}" class="btn btn-danger w-100 py-2">
                    <i class="bi bi-box-arrow-up me-2"></i>
                    Barang Keluar
                </a>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <a href="{{ route('categories.create') }}" class="btn btn-secondary w-100 py-2">
                    <i class="bi bi-folder-plus me-2"></i>
                    Tambah Kategori
                </a>
            </div>
        </div>
    </div>
</div>
