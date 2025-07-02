@extends('layouts.index')
@section('title','PO Supplier')
@section('main')
<div id="app" class="container-fluid mt-3">
        <div class="row">
            <!-- Katalog Produk -->
            <div class="col-md-7">
            <div class="card text-left">
            <div class="card-body">
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Tgl PO</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" ref="ftgl_btbg" v-model="ftgl_btbg" >
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" disabled ref="fno_pos" v-model="fno_pos"  placeholder="No POS">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Supplier</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option selected>Pilih Nama Supplier</option>
                        <option v-for="data in suppliers" :value="data.kode_sup">@{{data.nama_sup}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-2">
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
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="description" v-model="description"  placeholder="Description">
                    </div>
                </div>
            </div>
            </div>
            <br>
                <div class="d-flex justify-content-between mb-2">
                    <input type="text" class="form-control w-75" @keyup="searchData"  v-model="search" ref="search" placeholder="Cari Data...">
                    <button class="btn btn-light ms-2"><i class="bi bi-gear"></i></button>
                </div>
                <br>
                <div class="product-container">
                  <div class="row">
                    <div v-for="data in barangs" :key="data.id" class="col-md-4 mb-4">
                        <div class="product-card">
                            <div href="#" @click="addData" v-model="kode_bg">@{{data.kode_bg}} </div>
                            <div class="text-primary" >@{{ data.partname }}</div>
                            <div class="text-primary" >
                            <label for="colFormLabel" >Harga</label>
                                @{{ data.harga }}
                                <input type="text" class="form-control" ref="fq_poc" v-model="fq_poc"  placeholder="Isi Qty">
                            </div>
                            <div class="text-primary">
                                {{-- <input type="text" class="form-control" ref="fq_poc" v-model="fq_poc"  placeholder="Isi Qty"> --}}
                                {{-- <button @click="addData" class="btn btn-primary">Add</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                   <!-- Card Produk --> 
                </div>
                <br>
                <div class="mt-3 d-flex justify-content-center">
                    <nav>
                        <div>
                            <center>
                                <button type="button" class="btn btn-primary" @click="loadPaginate(link.url)" v-for="link in links" v-html="link.label"></button>
                            </center>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Keranjang / Panel kanan -->
            <div class="col-md-5 right-panel">
                <h5>🛒 Detail PO Supplier</h5>
                <div class="border-bottom pb-2 mb-2">
                    <div v-for="data in data_barangs" :key="data.id" class="col-md-4 mb-4">
                        <div class="product-card">
                            <strong>@{{ data.kode_bg }}</strong>
                            <div class="stock-badge">@{{ data.partname }}</div>
                            <strong>@{{ data.partname }}</strong>
                            <div class="text-primary">@{{ data.fberat_netto }}</div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary w-100 mt-3">Proses PO</button>
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
                barangjadi : null,
                kode_bg : null,
                partname : null,
                fberat_netto : null,
                ftgl_btbg : null,
                fno_poc : null,
                fk_brj : null,
                fn_brj : null,
                no_po : null,
                fq_poc : null,
                ppn : null,
                fqt_brj : null,
                no_po_cus : null,
                search: null,
                disabled_brj: false,
                data_barangs: null,
                barangs : null,
                links : null,
                description : null
            },
            methods: {
                loadPaginate: function(url) {
                    if (url == null) {
                        return
                    }
                    const $this = this;
                    this.loading = true;
                    axios.post(url, {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.loading = false;
                                $this.barangs = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
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
                },
                generateId() {
                    const $this = this;
                    axios.post("/generate-id-hpos", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                if (response.data.fno_pos) {
                                    const angka = String(response.data.fno_pos).slice(-3);
                                    $this.fno_pos = generateNoUrutDateMonth(angka);
                                } else {
                                    $this.fno_pos = tahun + bulan + (response.data);
                                }
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                addData: function() {
                    var $storage;
                    if (_getStorage('data')) {
                        $storage = JSON.parse(_getStorage('data'))
                    }
                    var $data = [{
                        "kode_bg": this.kode_bg,
                        "partname" : this.partname,
                        "partno": this.partno,
                        "fq_poc": this.fq_poc
                    }]

                    if ($storage == null) {
                        $tmp = JSON.stringify($data);
                        _saveStorage('data', $tmp);
                       
                    } else {
                        var BreakException = {};
                        $storage.forEach(element => {
                            if (element['kode_bg']===this.kode_bg){
                                alert("Data sudah ada !")
                                throw BreakException;
                            }   
                        });
                        $storage.push(...$data);
                        _saveStorage('data', JSON.stringify($storage));
                    }
                    this.data_barangs = JSON.parse(_getStorage('data'));
                    const $barang_total = this.data_barangs;

                    var grand_total = 0;
                    $barang_total.forEach(element => {
                        grand_total += element['fq_poc'];
                    });

                    this.grand_total = grand_total
                    this.disabled_brj=true;
                },
                deleteData: function(kd){
                    var $storage = _getStorage('data');
                    $storage = JSON.parse($storage);
                    
                    var newData;
                    $storage.forEach(element => {
                        if (element['kode_rbc']===kd){
                            newData = $storage.filter(item => item.kode_rbc !== kd);
                        }
                    });

                    _saveStorage('data',JSON.stringify(newData))
                    this.data_barangs = JSON.parse(_getStorage('data'));

                    var grand_total = 0;
                    newData.forEach(element => {
                        grand_total += element['sub_total'];
                    });
                    this.grand_total = grand_total
                },
                clearData: function() {
                    localStorage.clear()
                    _refresh()
                },
                searchData: function() {
                    if (this.search == null) {
                        this.$refs.search.focus()
                        return
                    }
                   
                    const $this = this;
                    axios.post("/search-brg", {
                            _token: _TOKEN_,
                            search: this.search
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.barangs = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                handleQtyInput(selectedIndex) {
                    this.items.forEach((item, index) => {
                    if (index !== selectedIndex) {
                        item.qty = '';
                    }
                    });
                },
                loadBarangGudang: function(){
                    const $this = this;
                    axios.post("/load-brg", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                $this.barangs = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
            },
            mounted() {
                this.loadBarangGudang();
                this.generateId();
                this.loadSupplier();
                localStorage.clear(); 
            },
        })
    </script>
  
@endsection