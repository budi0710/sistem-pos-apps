@extends('layouts.index')
@section('title','Supplier')
@section('main')
<div id="app" class="app-wrapper">
            <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="modal" data-bs-target="#my_modal_add">Tambah Data</button>
            <input type="text" class="form-control" @keyup="searchData" ref="search" v-model="search" placeholder="Cari Data" aria-label="Example text with button addon" aria-describedby="button-addon1">
            </div>

    <!-- Modal -->
        <div class="modal fade" id="my_modal_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Supplier</h5> 
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Kode Supplier</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" disabled ref="kode_sup" v-model="kode_sup"  id="kode_sup" placeholder="kode Supplier">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Supplier</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="nama_sup" v-model="nama_sup"  id="nama_sup" placeholder="Nama Supplier">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">No Telp</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="notelp_sup" v-model="notelp_sup"  id="notelp_sup" placeholder="No Telp">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" ref="alamat_sup" v-model="alamat_sup" id="alamat_sup" rows="3"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="email_sup" v-model="email_sup"  id="email_sup" placeholder="Email">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">PPN</label>
                    <div class="col-sm-9">
                       <input class="form-check-input" type="checkbox" value="1" id="PPN_sup" ref="PPN_sup" v-model="PPN_sup">
                        <label class="form-check-label" for="flexCheckDefault">
                            PPN
                        </label>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">N.P.W.P</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="NPWP_sup" v-model="NPWP_sup"  id="NPWP_sup" placeholder="N.P.W.P">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Contact Person</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="CP_sup" v-model="CP_sup"  id="CP_sup" placeholder="Contact Person">
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
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data jenis</h5> 
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Kode jenis:</label>
                        <input type="text" ref="kode_sup_edit" v-model="kode_sup_edit" disabled placeholder="kode Supplier" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nama Jenis:</label>
                        <input type="text" ref="nama_sup_edit" v-model="nama_sup_edit" placeholder="Nama Supplier" class="form-control" >
                    </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">N.P.W.P</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="npwp_edit" v-model="npwp_edit"  id="npwp_edit" placeholder="N.P.W.P">
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
                            <th style="width: 100px">Kode Supplier</th>
                            <th>Nama Supplier</th>
                            <th style="width: 300px">No Telp</th>
                            <th style="width: 300px">Email</th>
                            <th style="width: 200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in supps" class="align-middle">
                            <td>@{{ data.id }}</td>
                            <td>@{{ data.kode_sup }}</td>
                            <td>@{{ data.nama_sup }}</td>
                            <td>@{{ data.notelp_sup }}</td>
                            <td>@{{ data.email_sup }}</td>
                            <td>
                                <button @click="detaildata(data)" class="btn btn-primary btn-sm">Detail</button>
                                <button @click="editModalNow(data)" class="btn btn-primary btn-sm">Edit</button>
                                <button @click="deleteData(data.id,data.nama_sup)" class="btn btn-danger btn-sm">x</button>
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
                supps : null,
                kode_sup : null,
                nama_sup : null,
                notelp_sup : null,
                alamat_sup : null,
                email_sup : null,
                PPN_sup : null,
                NPWP_sup : null,
                PPH23_sup : null,
                CP_sup : null,
                kode_sup_edit : null,
                nama_sup_edit : null,
                notelp_sup_edit : null,
                alamat_sups_edit : null,
                email_sup_edit : null,
                PPN_sup_edit : null,
                NPWP_sup_edit : null,
                npwp_edit : null,
                PPH23_sup_edit : null,
                CP_sup_edit : null,
                alert: false,
                links :null,
                search : null,
                supplier : null,
                loading :false,
                id_edit : null
        },
        methods:{
            generateId() {
                const $this = this;
                axios.post("/generate-id-supplier", {
                _token: _TOKEN_
                    })
                    .then(function(response) {
                        if (response.data) {
                             $this.$refs.nama_sup.focus();
                            const kode_sup = (response.data.kode_sup);
                            if (kode_sup==null){
                                return $this.kode_sup = generateNewId_Supplier();
                            }else{
                                $this.kode_sup = generateNewId_Supplier(kode_sup);
                                if ($this.kode_sup==="erorr"){
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
                                $this.supps = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
          loadData : function(){
              const $this = this;
                    axios.post("/load-sup", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                $this.supps = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
          },
            editModalNow: function(data) {
                    modal_edit.show();
                    $app.id_edit = data.id;
                    $app.fk_jenis_edit = data.fk_jenis;
                    $app.jenis_edit = data.fn_jenis;
                    //alert(data.id)
                },
                    updateData: function(){
                    if (this.id_edit) {
                        const $this = this;
                         axios.post("/update-sup", {
                            _token: _TOKEN_,
                            jenis_edit: this.jenis_edit,
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
                    axios.post("/search-sup", {
                            _token: _TOKEN_,
                            search: this.search
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.loading = false;
                                $this.supps = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
            save: function() {
                    if (this.nama_sup == null) {
                        this.alert = false;
                        return
                    }
                    const $this = this;
                     axios.post("/save-sup", {
                                        _token: _TOKEN_,
                                        kode_sup: this.kode_sup,
                                        nama_sup: this.nama_sup,
                                        notelp_sup: this.notelp_sup,
                                        alamat_sup: this.alamat_sup,
                                        email_sup: this.email_sup,
                                        PPN_sup: this.PPN_sup,
                                        NPWP_sup: this.NPWP_sup,
                                        CP_sup: this.CP_sup
                                    })
                                    .then(function(response) {
                                        if (response.data.result) {
                                            $this.loadData();
                                            $this.alert = false;
                                            $this.kode_sup = null;
                                            $this.nama_sup = null;
                                            $this.notelp_sup = null;
                                            $this.alamat_sup = null;
                                            $this.email_sup = null;
                                            $this.PPN_sup = null;
                                            $this.NPWP_sup = null;
                                            $this.CP_sup = null;
                                            alert("Tambah data supplier sukses");
                                        }
                                    })
                                    .catch(function(error) {
                                        console.log(error);
                                    }); 
                    this.generateId();
                },
                deleteData: function(id, Jenis) {
                    if (id) {
                        const $this = this;
                        Swal.fire({
                            title: "Are you sure?",
                            text: "Apakah anda ingin menghapus data ini {" + Jenis + "}",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.loading = true;
                                axios.post("/delete-sup", {
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
          this.loadData()
          this.generateId();
          //init object modal edit
          modal_edit = new bootstrap.Modal(document.getElementById('my_modal_edit'));
        }
      });

        const NPWP_INPUT = document.getElementById("NPWP_sup")
            NPWP_INPUT.oninput = (e) => {
                e.target.value = autoFormatNPWP(e.target.value);
            };
        const NPWP_EDIT = document.getElementById("npwp_edit")
            NPWP_EDIT.oninput = (e) => {
                e.target.value = autoFormatNPWP(e.target.value);
            };
    </script>
                    
@endsection
