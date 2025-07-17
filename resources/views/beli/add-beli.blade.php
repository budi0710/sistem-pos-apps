@extends('layouts.index')
@section('title','Beli Supplier')
@section('main')
<div id="app" class="container-fluid mt-3">
        <div class="row">
            <!-- Katalog Produk -->
            <div class="col-md-7">
            <div class="card text-left">
            <div class="card-body">
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Tgl Beli</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" ref="ftgl_beli" v-model="ftgl_beli" >
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" disabled ref="fno_beli" v-model="fno_beli"  placeholder="No Beli">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Supplier</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" v-model="result_supplier" @change="loadFno_POS(result_supplier)" aria-label=".form-select-lg example">
                        <option selected disabled>Pilih Nama Supplier</option>
                        <option v-for="data in suppliers" :value="data.kode_sup">@{{data.nama_sup}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">No Po Supplier</label>
                    <div class="col-sm-9">
                    <select class="form-select" aria-label="Default select example" @change="DetailPO_Supplier(result_fno_pos)" v-model="result_fno_pos" >
                        <option selected disabled>No Po Supplier</option>
                        <option v-for="data in fno_poss" :value="data.fno_pos">@{{data.fno_pos}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Surat Jalan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="surat_jalan" v-model="surat_jalan"  placeholder="Surat Jalan">
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
                    <div class="col-md-4 mb-4" v-for="(data,i) in detail_po" :key="data.fno_spo"  >
                        <div class="product-card">
                            <div href="#" >
                                <a href="#">@{{data.kode_bg}} | @{{data.fno_spo}}</a>
                            </div>
                            <img :src="viewImage(data.fgambar_brg)" alt="" width="100" height="100">
                            <div class="text-primary" >@{{ data.partname }}</div>
                            <div class="text-primary" >
                                <label for="colFormLabel" >Qty PO</label>
                                @{{data.fq_pos}}
                                <input type="number" class="form-control"  :id="txtQty+i" @keyup.enter="enterQty(data,i)"  
                                placeholder="Isi Qty" style="width: 90px;">
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
                <h5>🛒 Detail Beli Supplier</h5>
                {{-- keranjang kanan --}}
                 <div  v-for="data in data_barangs" :key="data.fno_spo"  class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div><strong>@{{ data.kode_bg }} | @{{ data.fno_spo }} | @{{ data.partname }}</strong></div>
                            <strong> @{{_moneyFormat(data.fharga)}} x Qty : @{{data.fq_beli}}</strong>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="ms-3">@{{_moneyFormat(data.sub_total)}}</span> | <button @click="hapusData(data.kode_bg)"  class="btn btn-primary">Hapus</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div>
                   <h2>Total Harga @{{_moneyFormat(total_harga)}}</h2>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary w-100 mt-3" @click="prosesPO">Proses Beli</button>
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
                surat_jalan : null,
                fno_poss : null,
                fno_beli : null,
                detail_po : null,
                result_fno_pos : null,
                barangjadi : null,
                kode_bg : null,
                partname : null,
                fberat_netto : null,
                ftgl_beli : null,
                fno_poc : null,
                fk_brj : null,
                fn_brj : null,
                fno_pos : null,
                fq_beli : null,
                ppn : null,
                fqt_brj : null,
                no_po_cus : null,
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
                hapusData : function(kode_bg){
                   this.data_barangs = this.data_barangs.filter(item => item.kode_bg !== kode_bg);

                    this.totalBarang();
                    },
                prosesPO: function(){
                    const $this = this;
                    axios.post("/proses-belisupplier", {
                        fno_beli : this.fno_beli,
                        kode_sup : this.result_supplier,
                        ftgl_beli : this.ftgl_beli,
                        surat_jalan : this.surat_jalan,
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
                    //untuk validasi data jika tgl dan supplier kosong maka akan di arahkan sesuai request ya
                    if (this.ftgl_beli==null){
                        alert("Isi tgl dulu")
                        return
                    }

                    if (this.result_supplier==null){
                        alert("Pilih Supplier dulu")
                        return;
                    }

                    if (this.result_fno_pos==null){
                        alert("Pilih No PO Supplier dulu")
                        return;
                    }

                    if (this.surat_jalan==null){
                        alert("Isi Surat Jalan")
                        return;
                    }

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

                    if (obj>data.fq_pos){
                         Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Qty Beli Melebihi Qty PO",
                            footer: ''
                        });
                        return
                    }
                    
                    var $data = [{
                        "kode_bg": data.kode_bg,
                        "partname" : data.partname,
                        "fno_spo": data.fno_spo,
                        "fq_beli": obj,
                        "fharga" : data.fharga,
                        "sub_total" : data.fharga * obj
                    }]
                    // console.table($data);
                    // console.log($data.length)

                    if (this.data_barangs.length == 0){
                        this.data_barangs = ($data);

                        this.total_harga = data.fharga * obj;
                    }else{
                        //alert('data lebih dari 1')

                        // check jika barang nya sama
                        var BreakException = {};
                       this.data_barangs.forEach(element => {
                            if (element['kode_bg']===data.kode_bg){
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

                       this.totalBarang()
                    }
                    },
                totalBarang : function(){
                      var total_harga = 0
                        this.data_barangs.forEach(element => {
                            total_harga += element['sub_total']
                        });
                        this.total_harga = total_harga
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
                    axios.post("/generate-id-hbeli", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                if (response.data.fno_beli) {
                                    const angka = String(response.data.fno_beli).slice(-3);
                                    $this.fno_beli = generateNoUrutDateMonth(angka);
                                } else {
                                    $this.fno_beli = tahun + bulan + (response.data);
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
            DetailPO_Supplier: function(fno_pos) {
                        const $this = this;
                        axios.post("/load-detail-posupplier", {
                            _token: _TOKEN_,
                            fno_pos : fno_pos
                        })
                        .then(function(response) {
                        
                            if (response.data) {
                                $this.detail_po = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                    },
            loadFno_POS: function(result_supplier){
                    const $this = this;
                    axios.post("/load-fno-supplier", {
                            _token: _TOKEN_,
                            kode_supplier : result_supplier
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.fno_poss = response.data;
                                //$this.fno_poss = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
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
               // this.loadBarangGudang();
                this.DetailPO_Supplier();
                this.loadFno_POS();
                this.generateId();
                this.loadSupplier();
                localStorage.clear(); 
            },
        })
    </script>
  
@endsection