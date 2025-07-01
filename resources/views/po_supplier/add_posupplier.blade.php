@extends('layouts.index')
@section('title','Add POS')
@section('main')
<div id="app" class="container-fluid mt-3">
        <div class="row">
            <!-- Katalog Produk -->
            <div class="col-md-7">
            <div class="card text-left">
            <div class="card-body">
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Tgl PO</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" ref="kode_cus" v-model="kode_cus"  placeholder="kode Customer">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" ref="fno_pos" v-model="fno_pos"  placeholder="No POS">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Supplier</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option selected>Pilih Supplier</option>
                        <option v-for="data in suppliers" :value="data.kode_sup">@{{data.nama_sup}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">PPN</label>
                    <div class="col-sm-9">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" v-model="ppn">
                        <label class="form-check-label" for="flexCheckDefault">
                            PPN
                        </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="description" v-model="description"  placeholder="Description">
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
                            <div class="stock-badge">1</div>
                            <img src="./no-image.png" class="img-fluid" alt="...">
                            <strong>Pompa 125 ARKA</strong>
                            <div class="text-primary">Rp 25.000</div>
                        </div>
                    </div>
                  
                   <!-- Card Produk --> 
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
                <h5>🛒 Detail PO Supplier</h5>
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

    <script>
        const _TOKEN_ = '<?= csrf_token() ?>'

        new Vue({
            el : "#app",
            data : {
                suppliers : null,
                kode_sup : null,
                no_po : null,
                ppn : null,
                description : null
            },
            methods: {
                loadSupplier: function(){
                    const $this = this;
                    axios.post("/load-data-sup", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {

                            if (response.data) {
                                $this.suppliers = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
            },
            mounted() {
                this.loadSupplier()
            },
        })
    </script>
  
@endsection