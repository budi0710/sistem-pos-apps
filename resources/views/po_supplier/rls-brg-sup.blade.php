@extends('layouts.index')
@section('title','Relasi Supplier')
@section('main')
<div id="app" class="app-wrapper">
            <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="modal" data-bs-target="#my_modal_add">Tambah Data</button>
            <input type="text" class="form-control" @keyup="searchData" ref="search" v-model="search" placeholder="Cari Data" aria-label="Example text with button addon" aria-describedby="button-addon1">
            </div>
        <!-- Open the modal using ID.showModal() method -->
        <!-- Button trigger modal -->
    <!-- Modal -->
        <div class="modal fade" id="my_modal_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Relasi</h5> 
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Supplier</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" v-model="result_supplier" aria-label=".form-select-lg example">
                        <option selected>Pilih Nama Supplier</option>
                        <option v-for="data in suppliers" :value="data.kode_sup">@{{data.nama_sup}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Barang Gudang</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" v-model="result_barangs" aria-label=".form-select-lg example">
                        <option selected>Pilih Nama Supplier</option>
                        <option v-for="data in barangs" :value="data.kode_bg">@{{data.partname}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Barang Supplier</label>
                    <div class="col-sm-9">
                         <input type="text" ref="fn_brg_sup" v-model="fn_brg_sup" placeholder="Nama Barang Supplier" class="form-control" id="fn_brg_sup">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">No RBS</label>
                    <div class="col-sm-9">
                          <input type="text" ref="fno_rbs" v-model="fno_rbs" disabled placeholder="No RBS" class="form-control" id="recipient-name">    
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Harga Beli</label>
                    <div class="col-sm-9">
                         <input type="text" ref="fharga_beli" v-model="fharga_beli" placeholder="Harga Beli" class="form-control" id="fharga_beli">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Satuan Beli</label>
                    <div class="col-sm-9">
                         <input type="text" ref="fsatuan_beli" v-model="fsatuan_beli" placeholder="Satuan Beli" class="form-control" id="fsatuan_beli">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" @click="save" class="btn btn-primary">Simpan</button>
            </div>
            </div>
        </div>
        </div>
    <!-- Open the modal edit using ID.showModal() method -->
        <!-- Modal -->
        <div class="modal fade" id="my_modal_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Satuan</h5> 
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Supplier</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" v-model="result_supplier_edit" aria-label=".form-select-lg example">
                        <option selected>Pilih Nama Supplier</option>
                        <option v-for="data in suppliers" :value="data.kode_sup">@{{data.nama_sup}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Barang Gudang</label>
                    <div class="col-sm-9">
                    <select class="form-select form-select-lg mb-3" v-model="result_barangs_edit" aria-label=".form-select-lg example">
                        <option selected>Pilih Nama Supplier</option>
                        <option v-for="data in barangs" :value="data.kode_bg">@{{data.partname}}</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Barang Supplier</label>
                    <div class="col-sm-9">
                         <input type="text" ref="fn_brg_sup_edit" v-model="fn_brg_sup_edit" placeholder="Nama Barang Supplier" class="form-control" id="fn_brg_sup_edit">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">No RBS</label>
                    <div class="col-sm-9">
                          <input type="text" ref="fno_rbs_edit" v-model="fno_rbs_edit" disabled placeholder="No RBS" class="form-control" id="recipient-name">    
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Harga Beli</label>
                    <div class="col-sm-9">
                         <input type="text" ref="fharga_beli_edit" v-model="fharga_beli_edit" placeholder="Harga Beli" class="form-control" id="fharga_beli_edit">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Satuan Beli</label>
                    <div class="col-sm-9">
                         <input type="text" ref="fsatuan_beli_edit" v-model="fsatuan_beli_edit" placeholder="Satuan Beli" class="form-control" id="fsatuan_beli_edit">
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="updateData" class="btn btn-primary">Simpan</button>
                </div>
                </div>
            </div>
        </div>
    <!-- Open the modal using ID.showModal() method -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Supplier</th>
                            <th>kode BG</th>
                            <th>No RBS</th>
                            <th>Nama Barang Supplier</th>
                            <th>Harga</th>
                            <th style="width: 200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in rls_brg_sups" class="align-middle">
                            <td>@{{ data.id }}</td>
                            <td>@{{ data.nama_sup }}</td>
                            <td>@{{ data.kode_bg }}</td>
                            <td>@{{ data.fno_rbs }}</td>
                            <td>@{{ data.fn_brg_sup }}</td>
                            <td>@{{ data.fharga_beli }}</td>
                            <td>
                                <button @click="editModalNow(data)" class="btn btn-primary btn-sm">Edit</button>
                                <button @click="deleteData(data.id,data.fn_brg_sup)" class="btn btn-danger btn-sm">x</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
        <div>
            <center>
                <button type="button" class="btn btn-primary" @click="loadPaginate(link.url)" v-for="link in links" v-html="link.label"></button>
            </center>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

<script>
    // buat object kosong 
    var modal_edit;
const _TOKEN_ = '<?= csrf_token() ?>';
const $app =   new Vue({
        el : "#app",
        data: {
                rls_brg_sups : null,
                suppliers : null,
                barangs : null,
                result_supplier : null,
                result_barangs : null,
                fharga_beli : null,
                fsatuan_beli : null,
                fk_sat_edit : null,
                fn_brg_sup_edit : null,
                fharga_beli_edit : null,
                fsatuan_beli_edit : null,
                result_barangs_edit : null,
                result_supplier_edit : null,
                fno_rbs_edit : null,
                alert: false,
                satuan_edit : null,
                links :null,
                search : null,
                fno_rbs : null,
                fn_brg_sup : null,
                loading :false,
                id_edit : null
        },
        methods:{
            generateId() {
                const $this = this;
                axios.post("/generate-id-rls-sup", {
                _token: _TOKEN_
                    })
                    .then(function(response) {
                        if (response.data) {
                             $this.$refs.fn_brg_sup.focus();
                            const fno_rbs = (response.data.fno_rbs);
                            if (fno_rbs==null){
                                return $this.fno_rbs = generateNewId_RBS();
                            }else{
                                $this.fno_rbs = generateNewId_RBS(fno_rbs);
                                if ($this.fno_rbs==="erorr"){
                                    alert("Disabld Button")
                                    $this.disabled_button_save = true
                                }
                            }
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
                                $this.rls_brg_sups = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
          loadData : function(){
              const $this = this;
                    axios.post("/load-rls-sup", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                $this.rls_brg_sups = response.data.data;
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
            loadBarangs: function(){
                    const $this = this;
                    axios.post("/load-data-brg", {
                            _token: _TOKEN_
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
            editModalNow: function(data) {
                    modal_edit.show();
                    $app.id_edit = data.id;
                    $app.result_supplier_edit = data.kode_sup;
                    $app.result_barangs_edit = data.kode_bg;
                    $app.fno_rbs_edit = data.fno_rbs;
                    $app.fn_brg_sup_edit = data.fn_brg_sup;
                    $app.fsatuan_beli_edit = data.fsatuan_beli;
                    $app.fharga_beli_edit = data.fharga_beli;
                    //alert(data.id)
                },
            updateData: function(){
                    if (this.id_edit) {
                        const $this = this;
                         axios.post("/update-rls-sup", {
                            _token: _TOKEN_,
                            fn_brg_sup_edit: this.fn_brg_sup_edit,
                            fsatuan_beli_edit: this.fsatuan_beli_edit,
                            fharga_beli_edit: this.fharga_beli_edit,
                            id : this.id_edit
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.loading = false;
                                $this.loadData();
                                alert("Update data sukses")
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                    }
              },
            searchData: function() {
                    if (this.search == null) {
                        this.$refs.search.focus()
                        return
                    }
                    this.loading = true;
                    const $this = this;
                    axios.post("/search-rls-sup", {
                            _token: _TOKEN_,
                            search: this.search
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.loading = false;
                                $this.rls_brg_sups = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
            save: function() {
                    if (this.fn_brg_sup == null) {
                        this.alert = false;
                        return
                    }
                    const $this = this;
                     axios.post("save-rls-sup", {
                                        _token: _TOKEN_,
                                        result_supplier: this.result_supplier,
                                        result_barangs: this.result_barangs,
                                        fn_brg_sup: this.fn_brg_sup,
                                        fsatuan_beli: this.fsatuan_beli,
                                        fharga_beli: this.fharga_beli,
                                        fno_rbs: this.fno_rbs
                                    })
                                    .then(function(response) {
                                        if (response.data.result) {
                                            $this.loadData();
                                            $this.alert = false;
                                            $this.result_supplier = null;
                                            $this.result_barangs = null;
                                            $this.fn_brg_sup = null;
                                            $this.fsatuan_beli = null;
                                            $this.fharga_beli = null;
                                            alert("Tambah data sukses");
                                        }
                                    })
                                    .catch(function(error) {
                                        console.log(error);
                                    }); 
                    this.generateId();
                },
                deleteData: function(id, fn_brg_sup) {
                    if (id) {
                        const $this = this;
                        Swal.fire({
                            title: "Are you sure?",
                            text: "Apakah anda ingin menghapus data ini {" + fn_brg_sup + "}",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.loading = true;
                                axios.post("/delete-rls-sup", {
                                        _token: _TOKEN_,
                                        id: id
                                    })
                                    .then(function(response) {
                                        if (response.data.result) {
                                            $this.loadData();
                                            $this.loading = false;
                                            Swal.fire({
                                                icon: "success",
                                                title: "Mantap",
                                                text: "Delete Success",
                                                footer: ''
                                            });
                                        }
                                    })
                                    .catch(function(error) {
                                        console.log(error);
                                    });

                            }
                        });

                    }
                },
        },
        mounted(){
            this.loadData();
            this.loadSupplier();
            this.loadBarangs();
            this.generateId();
          modal_edit = new bootstrap.Modal(document.getElementById('my_modal_edit'));
        }
      });
    </script>
@endsection
