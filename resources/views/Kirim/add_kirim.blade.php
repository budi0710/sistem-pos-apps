@extends('layouts.index')
@section('title','Add Kirim')
@section('main')
<div class="container-fluid mt-3">
        <div class="row">
            <!-- Katalog Produk -->
            <div class="col-md-7">
            <div class="card text-left">
            <div class="card-body">
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Tgl Kirim</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" ref="kode_cus" v-model="kode_cus"  id="kode_cus" placeholder="kode Customer">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" ref="fno_krm" v-model="fno_krm"  placeholder="No Kirim">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Customer</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option selected>Pilih Customer</option>
                        <option value="1">One</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">No PO Customer</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="kode_cus" v-model="kode_cus"  id="kode_cus" placeholder="No PO Customer">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Supir</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="nama_cus" v-model="nama_cus"  id="nama_cus" placeholder="Nama Supir">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="nama_cus" v-model="nama_cus"  id="nama_cus" placeholder="Description">
                    </div>
                </div>
            </div>
            </div>
            <br>
                <div class="d-flex justify-content-between mb-2">
                    <input type="text" class="form-control w-75" placeholder="Cari Data...">
                    <button class="btn btn-light ms-2"><i class="bi bi-gear"></i></button>
                </div>
                <div class="row row-cols-2 row-cols-md-4 g-3">
                    <!-- Card Produk -->
                    <div class="col">
                        <div class="product-card">
                            <div class="stock-badge">2</div>
                            <div class="product-img"></div>
                            <strong>Pompa 125 ARKA</strong>
                            <div class="text-primary">Rp 25.000</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <div class="stock-badge">25</div>
                            <div class="product-img"></div>
                            <strong>Pompa 125 ARKA ZA</strong>
                            <div class="text-primary">Rp 28.000</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <div class="stock-badge">2</div>
                            <div class="product-img"></div>
                            <strong>Pompa SMZ 260</strong>
                            <div class="text-primary">Rp 25.000</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <div class="stock-badge">25</div>
                            <div class="product-img"></div>
                            <strong>Pompa SMZ 375</strong>
                            <div class="text-primary">Rp 28.000</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <div class="stock-badge">2</div>
                            <div class="product-img"></div>
                            <strong>Pompa 200 ARKA</strong>
                            <div class="text-primary">Rp 25.000</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <div class="stock-badge">25</div>
                            <div class="product-img"></div>
                            <strong>Pompa 200 ARKA ZA</strong>
                            <div class="text-primary">Rp 28.000</div>
                        </div>
                    </div>
                    <!-- Tambah produk lain seperti di atas -->
                </div>
                <br>
                <div class="mt-3 d-flex justify-content-center">
                    <nav>
                        <ul class="pagination pagination-sm">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Keranjang / Panel kanan -->
            <div class="col-md-5 right-panel">
                <h5>🛒 Detail Kirim</h5>
                <div class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div><strong>Pompa 125 ARKA</strong></div>
                            <small>Rp.25.000 • Stok: 2</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-light">-</button>
                            <span class="mx-2">1</span>
                            <button class="btn btn-sm btn-light">+</button>
                            <span class="ms-3">Rp 25.000</span>
                        </div>
                    </div>
                </div>

                <div class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div><strong>Pompa 125 ARKA ZA</strong></div>
                            <small>Rp.28.000 • Stok: 25</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-light">-</button>
                            <span class="mx-2">1</span>
                            <button class="btn btn-sm btn-light">+</button>
                            <span class="ms-3">Rp 28.000</span>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <span>Sub Total</span>
                        <span>Rp 53.000</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Diskon</span>
                        <span>Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Penyusuaian</span>
                        <span>Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Pajak (11%)</span>
                        <span>Rp 5.830</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold text-purple mt-2">
                        <span>Total</span>
                        <span>Rp 58.830</span>
                    </div>
                    <button class="btn btn-primary w-100 mt-3">Proses PO Rp 58.830</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons (opsional untuk icon gear) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>

@endsection