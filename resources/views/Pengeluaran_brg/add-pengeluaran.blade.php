@extends('layouts.index')
@section('title','Pengeluaran Brg')
@section('main')
<div id="app" class="container-fluid mt-3">
 <div class="row">
            <!-- Katalog Produk -->
            <div class="col-md-7">
            <div class="card text-left">
            <div class="card-body">
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Tgl Permintaan</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" ref="ftgl_btbg" v-model="ftgl_btbg" >
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" disabled ref="fno_btbg" v-model="fno_btbg" @change="DetailBTBG(fno_btbg)" >
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Barang Jadi</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" v-model="result_brj" >
                        <option selected>Pilih Nama Barang Jadi</option>
                        <option v-for="data in brjs" :value="data.fk_brj">@{{data.fn_brj}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Qty Barang Jadi</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" ref="fq_brj" v-model="fq_brj" onkeypress="return hanyaAngka(event)" placeholder="Qty Barang Jadi">
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
                    <div class="col-md-4 mb-4" v-for="(data,i) in detail_btbg" :key="data.id"  >
                        <div class="product-card">
                            <div href="#" >
                                <a href="#">@{{data.kode_bg}} </a>
                            </div>
                            <img :src="viewImage(data.fgambar_brg)" alt="" width="100" height="100">
                            <div class="text-primary" >@{{ data.partname }}</div>
                            <div class="text-primary" >Qty @{{data.fq_btbg}}
                                <input type="number" class="form-control"  :id="txtQty+i" @keyup.enter="enterQty(data,i)" placeholder="Isi Qty" style="width: 90px;">
                            </div>
                            <div class="text-primary">
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
                                <button type="button" class="btn btn-primary"  v-for="link in links" v-html="link.label"></button>
                            </center>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Keranjang / Panel kanan -->
            <div class="col-md-5 right-panel">
                <h5>🛒 Detail Data Pengeluaran Barang</h5>
                {{-- keranjang kanan --}}
                 <div  v-for="data in data_barangs" :key="data.id"  class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div><strong>@{{ data.kode_bg }} | @{{ data.partname }}</strong></div>
                            <strong>Qty : @{{data.fq_btbg_akt}}</strong>
                        </div>
                        <div class="d-flex align-items-center">
                            <button  class="btn btn-primary" @click="hapusData(data.kode_bg)">Hapus</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div>
                   <h2>Total Pengeluaran Barang Gudang </h2>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary w-100 mt-3"  @click="prosesBTBG_AKT">Proses Pengeluaran</button>
                </div>
            </div>
        </div>
    </div>

<script>
        var $storage = [];
        const _TOKEN_ = '<?= csrf_token() ?>';
        new Vue({
            el: "#app",
            data: {
                barangs: null,
                prosesBTBG : null,
                txtQty : 'txtQty',
                brjs : null,
                alert: false,
                links: null,
                search: null,
                jenis: null,
                loading: false,
                id_edit: null,
                fno_btbg: "<?= $data_header->fno_btbg ?>",
                ftgl_btbg:  "<?= $data_header->ftgl_btbg ?>",
                result_brj: "<?= $data_header->fk_brj ?>",
                fq_brj: "<?= $data_header->fq_brj ?>",
                description: "<?= $data_header->description ?>",
                detail_btbg : null,
                data_dbtbg: null,
                data_barangs: [],
                grand_total: 0
            },
            methods: {
                prosesBTBG_AKT: function(){
                    const $this = this;
                    axios.post("/proses-hbtbg-akt", {
                        fno_btbg : this.fno_btbg,
                        fk_brj : this.result_brj,
                        fq_brj : this.fq_brj,
                        ftgl_btbg : this.ftgl_btbg,
                        description : this.description,
                        detail_data : this.data_barangs
                    })
                    .then(function(response) {
                        if (response.data.result){
                                Swal.fire({
                                    icon: "success",
                                    title: "GOOD",
                                    text: "Data berhasil disimpan!",
                                    footer: ''
                                }).then(() => {
                                    window.location.href = "/pengeluaran";
                                });
                                //_refresh()
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                },
                hapusData : function(kode_bg){
                   this.data_barangs = this.data_barangs.filter(item => item.kode_bg !== kode_bg)
                },
                viewImage: function(data){
                    return './storage/'+data
                    },
                searchData: function() {
                    if (this.search == null) {
                        this.$refs.search.focus()
                        return
                    }
                    const $this = this;
                    axios.post("/search-barang-supplier", {
                            _token: _TOKEN_,
                            search: this.search,
                            kode_supplier : this.result_suppllier
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
                enterQty: function(data,i){
                    //untuk validasi data jika tgl dan supplier kosong maka akan di arahkan sesuai request ya
                    if (this.ftgl_btbg==null){
                        alert("Isi tgl dulu")
                        return;
                    }
                    if (this.result_brj==null){
                        alert("Pilih Barang Jadinya dulu")
                        return;
                    }
                    if (this.fq_brj==null){
                        alert("Isi Qty Yang Akan di produsinya dulu")
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
                    
                    var $data = [{
                        "kode_bg": data.kode_bg,
                        "partname" : data.partname,
                        "fq_btbg_akt": obj
                    }]
                    // console.table($data);
                    // console.log($data.length)

                    if (this.data_barangs.length == 0){
                        this.data_barangs = ($data);

                        this.total_harga =  obj;
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

                        var total_harga = 0
                        this.data_barangs.forEach(element => {
                            total_harga += element['sub_total']
                        });
                        this.total_harga = total_harga
                    }
                },
                update: function() {
                    if (this.tgl_pos == null) {
                        this.$refs.tgl_pos.focus()
                        return;
                    }

                    if (this.result_suppllier == null) {
                        this.$refs.result_suppllier.focus()
                        return;
                    }

                    if (this.ket == null) {
                        this.$refs.ket.focus()
                        return;
                    }
                    console.table($storage)
                    if ($storage == null) {
                        alert("Pilih barang terlebih dahulu")
                        return;
                    }

                    const $this = this;

                    axios.post("/update-h-supplier", {
                            _token: _TOKEN_,
                            data: ($storage),
                            tgl_pos: this.tgl_pos,
                            result_suppllier: this.result_suppllier,
                            ket: this.ket,
                            no_pos: this.no_pos,
                            ppn: this.PPN_suppllier,
                            pph: this.pph23
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                alert("Berhasil Save Data");
                                _refresh()
                                localStorage.clear()
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
                                $this.brjs = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                DetailBTBG: function(fno_btbg) {
                       // alert(fno_btbg)
                       // gunakan this untuk mengambil data fno_btbg karena instance
                        const $this = this;
                        axios.post("/load-detail-permintaan", {
                            _token: _TOKEN_,
                            fno_btbg : this.fno_btbg
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.detail_btbg = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                    }
            },
            mounted() {
                this.DetailBTBG();
                this.loadBarangJadi();
            }
        });
    </script>       
@endsection
