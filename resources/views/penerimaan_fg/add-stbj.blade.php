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
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Tgl STBJ</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" ref="ftgl_stbj" v-model="ftgl_stbj" >
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" disabled ref="fno_stbj" v-model="fno_stbj"  placeholder="No STBJ">
                    </div>
                </div>
                <div class="row mb-1">
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
                      <!-- Card Produk --> 
                  <div class="row" >
                    <div class="col-md-4 mb-4" v-for="(data,i) in barangs" :key="data.id"  >
                        <div class="product-card">
                            <div href="#" >
                                <a href="#">@{{data.fk_brj}} </a>
                            </div>
                            <img :src="viewImage(data.fgambar)" alt="" width="100" height="100">
                            <div class="text-primary" >@{{ data.fn_brj }}</div>
                            <div class="text-primary" > @{{data.fpartno}}
                            <label for="colFormLabel" >Berat Netto</label>
                                @{{ data.fbrt_neto }}
                                <input type="text" class="form-control"  :id="txtQty+i" @keyup.enter="enterQty(data,i)"  placeholder="Isi Qty">
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
                <h5>🛒 Detail Penerimaan Barang Jadi</h5>
                {{-- keranjang kanan --}}
                 <div  v-for="data in data_barangs" :key="data.id"  class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div><strong>@{{ data.fk_brj }} | @{{ data.fn_brj }} | @{{ data.fpartno }}</strong></div>
                            <strong>@{{data.fq_stbj}}</strong>
                        </div>
                        <div class="d-flex align-items-center">
                             <button  class="btn btn-primary">Hapus</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div>
                   <h2>Total Penerimaan Barang Jadi </h2>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary w-100 mt-3" @click="prosesSTBJ">Proses PO</button>
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
                ftgl_stbj : null,
                fno_poc : null,
                fk_brj : null,
                fn_brj : null,
                fno_stbj : null,
                search: null,
                disabled_brj: false,
                data_barangs: [],
                barangs : null,
                links : null,
                description : null,
                inputValues:null,
                txtQty : 'txtQty',
                total_harga : 0,
                result_supplier: null
            },
            methods: {
                prosesSTBJ: function(){
                    const $this = this;
                    axios.post("/proses-simpan", {
                        fno_stbj    : this.fno_stbj,
                        ftgl_stbj   : this.ftgl_stbj,
                        description : this.description,
                        detail_data : this.data_barangs
                    })
                    .then(function(response) {
                        if (response.data.result){
                                Swal.fire({
                                    icon: "success",
                                    title: "GOod",
                                    text: "Data berhasil disimpan !",
                                    footer: ''
                                });

                                _refresh()
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                },
                enterQty: function(data,i){
                    const obj = document.getElementById('txtQty'+i).value;
                    if (obj===0 || obj==0 || obj==null){
                         Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Qty harus lebih dari 0",
                            footer: ''
                        });
                        return
                    }
                    
                    var $data = [{
                        "fk_brj": data.fk_brj,
                        "fn_brj" : data.fn_brj,
                        "fpartno": data.partno,
                        "fq_stbj": obj
                    }]

                    if (this.data_barangs.length == 0){
                        this.data_barangs = ($data);
                        this.total_harga = obj;
                    }else{
                        //alert('data lebih dari 1')

                        // check jika barang nya sama
                        var BreakException = {};
                        this.data_barangs.forEach(element => {
                            if (element['fk_brj']===data.fk_brj){
                                 Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Data sudah ada",
                                    footer: ''
                                });
                                throw BreakException;
                            }   
                        });
                        this.data_barangs.push(...$data);
                        var total_harga = 0
                        this.data_barangs.forEach(element => {
                            total_harga += element['sub_total']
                        });
                        this.total_harga = total_harga
                    }
                },
                viewImage: function(data){
                    return 'storage/'+data
                },
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
                    axios.post("/generate-id-hstbj", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                if (response.data.fno_stbj) {
                                    const angka = String(response.data.fno_stbj).slice(-3);
                                    $this.fno_stbj = generateNoUrutDateMonth(angka);
                                } else {
                                    $this.fno_stbj = tahun + bulan + (response.data);
                                }
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
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
                    axios.post("/search-brj", {
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
                    axios.post("/load-brj", {
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
                localStorage.clear(); 
            },
        })
    </script>
  
@endsection