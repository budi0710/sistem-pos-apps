@extends('layouts.index')
@section('title','Kirim Customer')
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
                        <input type="date" class="form-control" ref="ftgl_krm" v-model="ftgl_krm" >
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" disabled ref="fno_krm" v-model="fno_krm"  placeholder="No Kirim">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Customer</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" v-model="result_customer" @change="loadFno_POC(result_customer)" aria-label=".form-select-lg example">
                        <option selected>Pilih Nama Customer</option>
                        <option v-for="data in customers" :value="data.kode_cus">@{{data.nama_cus}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">No PO Customer</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" v-model="result_fno_poc" @change="DetailPO_Customer(result_fno_poc)" aria-label=".form-select-lg example">
                        <option selected>Pilih PO Customer</option>
                        <option v-for="data in fno_pocs" :value="data.fno_poc">@{{data.fno_poc}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Supir</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" ref="fn_supir" v-model="fn_supir"  placeholder="Nama Supir">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" ref="fno_plat_mobil" v-model="fno_plat_mobil"  placeholder="No Plat Mobil">
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
                <div class="flex-container">
                  <div class="row">
                    <div class="col-md-3 mb-3" v-for="(data,i) in detail_po" :key="data.fnos_poc"  >
                        <div class="product-card">
                            <div href="#" >
                                <a href="#">@{{data.fk_brj}} | @{{data.fnos_poc}} </a>
                            </div>
                            <img :src="viewImage(data.fgambar)" alt="" width="100" height="100">
                            <div class="text-primary" >@{{ data.fn_brj }}</div>
                            <div class="text-primary" > 
                                <label for="colFormLabel" >Qty POC</label>
                                @{{ data.fq_poc }}
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
                <h5>🛒 Detail Kirim Customer</h5>
                 <div  v-for="data in data_barangs" :key="data.id"  class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div><strong>@{{ data.fk_brj }} | @{{ data.fn_brj }} | @{{ data.fnos_poc }}</strong></div>
                            <strong> Qty Kirim : @{{data.fq_krm}}</strong>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="ms-3">@{{ _moneyFormat(data.sub_total) }}</span>  |  <button class="btn btn-danger btn-sm" @click="hapusData(data.fnos_poc)" >Hapus</button>
                        </div>
                    </div>
                </div>
                <div>
                   <h2>Total Harga @{{_moneyFormat(total_harga)}}</h2>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary w-100 mt-3"  @click="prosesKRM">Proses PO Customer</button>
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
                detail_po : null,
                fno_pocs : null,
                barangjadi : null,
                kode_bg : null,
                fno_plat_mobil : null,
                fn_supir : null,
                partname : null,
                fberat_netto : null,
                ftgl_krm : null,
                fno_krm : null,
                fk_brj : null,
                fn_brj : null,
                no_po : null,
                fq_poc : null,
                ppn : null,
                fqt_brj : null,
                fno_poc_cus : null,
                result_customer : null,
                result_fno_poc : null,
                search: null,
                disabled_brj: false,
                data_barangs: null,
                data_barangs: [],
                barangs : null,
                links : null,
                txtQty : 'txtQty',
                total_harga : 0,
                description : null
            },
            methods: {
                prosesKRM: function(){
                    const $this = this;
                    axios.post("/proses-krmcustomer", {
                        fno_krm : this.fno_krm,
                        ftgl_krm : this.ftgl_krm,
                        kode_cus : this.result_customer,
                        fno_poc : this.result_fno_poc,
                        fno_plat_mobil : this.fno_plat_mobil,
                        fnama_supir : this.fn_supir,
                        description : this.description,
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
                    if (this.ftgl_krm==null){
                        alert("Isi tgl dulu")
                        return
                    }

                    if (this.result_customer==null){
                        alert("Pilih Nama Customer ya dulu")
                        return;
                    }

                    if (this.result_fno_poc==null){
                        alert("Isi No Po Customer ya")
                        return;
                    }

                    
                    if (this.fn_supir==null){
                        alert("Isi Nama Supir ya")
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

                    if (obj>data.fq_poc){
                         Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Qty Kirim Melebihi Qty POC",
                            footer: ''
                        });
                        return
                    }
                    
                    var $data = [{
                        "fk_brj": data.fk_brj,
                        "fn_brj" : data.fn_brj,
                        "fnos_poc": data.fnos_poc,
                        "fq_krm": obj,
                        "fharga" : data.fharga,
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

                        //var total_harga = 0
                        //this.data_barangs.forEach(element => {
                           // total_harga += element['sub_total']
                        //});
                        this.totalBarang()
                    }
                    },

                totalBarang : function(){
                      var total_harga = 0
                        this.data_barangs.forEach(element => {
                            total_harga += parseFloat(element['fq_krm'])
                        });
                        this.total_harga = total_harga
                },    
                loadBarangCustomer: function(){
                    const $this = this;
                    axios.post("/load-data-cus", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.customers = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                    },
                generateId() {
                    const $this = this;
                    axios.post("/generate-id-hkrm", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                if (response.data.fno_krm) {
                                    const angka = String(response.data.fno_krm).slice(-3);
                                    $this.fno_krm = generateNoUrutDateMonth(angka);
                                } else {
                                    $this.fno_krm = tahun + bulan + (response.data);
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
                        "fk_brj": this.fk_brj,
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
                hapusData : function(fnos_poc){
                   this.data_barangs = this.data_barangs.filter(item => item.fnos_poc !== fnos_poc);
                    this.totalBarang();
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
                loadFno_POC: function(result_customer){
                    const $this = this;
                    axios.post("/load-fno-customer", {
                            _token: _TOKEN_,
                            kode_cus : result_customer
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.fno_pocs = response.data;
                                //$this.fno_poss = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                    },
                DetailPO_Customer: function(fno_poc) {
                        const $this = this;
                        axios.post("/load-detail-pocustomer", {
                            _token: _TOKEN_,
                            fno_poc : fno_poc
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
                this.DetailPO_Customer();
                this.generateId();
                this.loadFno_POC();
                this.loadBarangCustomer();
                localStorage.clear(); 
            },
        })
    </script>
  
@endsection