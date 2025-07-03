@extends('layouts.index')
@section('title','Permintaan Gudang')
@section('main')
<div id="app" class="container-fluid mt-3">
        <div class="row">
            <!-- Katalog Produk -->
            <div class="col-md-7">
            <div class="card text-left">
            <div class="card-body">
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Tgl Permintaan</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" ref="ftgl_btbg" v-model="ftgl_btbg" >
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" disabled ref="fno_btbg" v-model="fno_btbg"  placeholder="No BTBG">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Barang Jadi</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option selected>Pilih Barang Jadi</option>
                        <option v-for="data in barangjadi" :value="data.fk_brj">@{{data.fn_brj}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="description" v-model="description"  placeholder="Description">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Qty Barang Jadi</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fqt_brj" v-model="fqt_brj"  placeholder="Qty Yang Akan di Produksi">
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
                            <strong @click="addData">@{{ data.kode_bg }}</strong>
                            <img :src="viewImage(data.fgambar_brg)" alt="" width="100" height="100">
                            <div class="stock-badge" >@{{ data.partname }}</div>
                            <div class="text-primary" >
                            <label for="colFormLabel" >Berat Netto</label>
                            @{{ data.fberat_netto }}</div>
                            <div class="text-primary">
                                <input type="text" class="form-control" ref="fq_btbg" v-model="fq_btbg"  placeholder="Isi Qty">
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
                <h5>🛒 Detail Permintaan Barang Gudang</h5>
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
                    <button class="btn btn-primary w-100 mt-3">Proses BTBG</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const _TOKEN_ = '<?= csrf_token() ?>'
        new Vue({
            el : "#app",
            data : {
                barangjadi : null,
                kode_bg : null,
                partname : null,
                fberat_netto : null,
                ftgl_btbg : null,
                fno_btbg : null,
                fk_brj : null,
                fn_brj : null,
                no_po : null,
                ppn : null,
                fqt_brj : null,
                fq_btbg : null,
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
                loadBarangJadi: function(){
                    const $this = this;
                    axios.post("/load-data-brj", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.barangjadi = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                viewImage: function(data){
                    return 'storage/'+data
                },
                generateId() {
                    const $this = this;
                    axios.post("/generate-id-hbtbg", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                if (response.data.fno_btbg) {
                                    const angka = String(response.data.fno_btbg).slice(-3);
                                    $this.fno_btbg = generateNoUrutDateMonth(angka);
                                } else {
                                    $this.fno_btbg = tahun + bulan + (response.data);
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
                        "fq_btbg": this.fq_btbg
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
                        grand_total += element['fq_btbg'];
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
                this.loadBarangJadi();
                localStorage.clear(); 
            },
        })
    </script>
@endsection