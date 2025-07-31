@extends('layouts.index')
@section('title','Pengiriman')
@section('main')
<div id="app" class="container-fluid mt-3">
        <div class="row">
            <!-- Katalog Produk -->
            <div class="col-md-7">
            <div class="card text-left">
            <div class="card-body">
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Tgl Kirim</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" ref="ftgl_krm_fg" v-model="ftgl_krm_fg" >
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" disabled ref="fno_krm_fg" v-model="fno_krm_fg"  placeholder="No Kirim">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Jenis Kirim</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" v-model="result_jenis" aria-label=".form-select-lg example">
                        <option selected>Pilih Jenis Kirim</option>
                        <option value="krm-cus">Kirim Customer</option>
                        <option value="ret-cus">Retur Customer</option>
                        <option value="Lainnya">Lain-Lain</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Kepada</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="ftujuan" v-model="ftujuan"  placeholder="Kepada">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="falamat" v-model="falamat"  placeholder="Alamat">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fket" v-model="fket"  placeholder="Keterangan">
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
                <div class="flex-container">
                  <div class="row">
                    <div class="col-md-3 mb-3" v-for="(data,i) in barangs" :key="data.id"  >
                        <div class="product-card">
                            <div href="#" >
                                <a href="#">@{{data.fk_brj}} | @{{data.fpartno}}</a>
                            </div>
                            <img :src="viewImage(data.fgambar)" alt="" width="100" height="100">
                            <div class="text-primary" >@{{ data.fn_brj }}</div>
                            <div class="text-primary" > 
                            <input type="number" class="form-control qty-input"  :id="txtQty+i" @keyup.enter="enterQty(data,i)"  placeholder="Isi Qty"  style="width: 90px;"/>
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
                <h5>🛒 Detail Kirim</h5>
                 <div  v-for="data in data_barangs" :key="data.id"  class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div><strong>@{{ data.fk_brj }} | @{{ data.fn_brj }}</strong></div>
                            <strong>@{{data.fq_krm_fg}}</strong>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="ms-3"> <button  @click="hapusData" class="btn btn-primary"  >Hapus</button>
                        </div>
                    </div>
                </div>
                <div>
                   <h2>Total Kirim</h2>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary w-100 mt-3"  @click="prosesPOC">Proses Kirim</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const _TOKEN_ = '<?= csrf_token() ?>'
        new Vue({
            el : "#app",
            data : {
                customers : null,
                ftujuan : null,
                falamat : null,
                barangjadi : null,
                kode_bg : null,
                partname : null,
                fberat_netto : null,
                ftgl_krm_fg : null,
                fno_krm_fg : null,
                fk_brj : null,
                fn_brj : null,
                no_po : null,
                fq_poc : null,
                ppn : null,
                fqt_brj : null,
                result_jenis : null,
                search: null,
                disabled_brj: false,
                data_barangs: null,
                data_barangs: [],
                barangs : null,
                links : null,
                txtQty : 'txtQty',
                total_harga : 0,
                fket : null
            },
            methods: {
                prosesPOC: function(){
                    const $this = this;
                    axios.post("/proses-kirim", {
                        fno_krm_fg : this.fno_krm_fg,
                        fn_jenis_krm : this.result_jenis,
                        ftgl_krm_fg : this.ftgl_krm_fg,
                        ftujuan : this.ftujuan,
                        falamat : this.falamat,
                        fket : this.fket,
                        detail_data : this.data_barangs
                    })
                    .then(function(response) {
                        if (response.data.result){
                                Swal.fire({
                                    icon: "success",
                                    title: "GOod Job",
                                    text: "Data Po Customer berhasil disimpan !",
                                    footer: ''
                                });

                                _refresh()
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
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
            enterQty: function(data,i){
                //untuk validasi data jika tgl dan supplier kosong maka akan di arahkan sesuai request ya
                    if (this.ftgl_krm_fg==null){
                        alert("Isi tgl kirim dulu")
                        return
                    }

                    if (this.result_jenis==null){
                        alert("Pilih Jenis Kirim")
                        return;
                    }

                    if (this.ftujuan==null){
                        alert("Isi kepada / Tujuan Kirim")
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
                        "fk_brj": data.fk_brj,
                        "fn_brj" : data.fn_brj,
                        "fpartno": data.fpartno,
                        "fq_krm_fg": obj,
                        "sub_total" : obj
                    }]
                    // console.table($data);
                    // console.log($data.length)

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
                generateId() {
                    const $this = this;
                    axios.post("/generate-id-kirim", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                if (response.data.fno_krm_fg) {
                                    const angka = String(response.data.fno_krm_fg).slice(-3);
                                    $this.fno_krm_fg = generateNoUrutDateMonth(angka);
                                } else {
                                    $this.fno_krm_fg = tahun + bulan + (response.data);
                                }
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                viewImage: function(data){
                    return 'storage/'+data
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
                hapusData: function() {
                    delete this.data_barangs["fk_brj"]
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
                loadBarangGudangJadi: function(){
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
                this.loadBarangGudangJadi();
                this.generateId();
                localStorage.clear(); 
            },
        })
    </script>
  
@endsection