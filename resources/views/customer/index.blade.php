@extends('layouts.index')
@section('title','Customer')
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Customer</h5> 
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-4 col-form-label">Kode Customer</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" ref="kode_cus" v-model="kode_cus"  id="kode_cus" placeholder="kode Customer">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-4 col-form-label">Nama Customer</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" ref="nama_cus" v-model="nama_cus"  id="nama_cus" placeholder="Nama Customer">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-4 col-form-label">No Telp</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" ref="notelp_cus" v-model="notelp_cus"  id="notelp_cus" placeholder="No Telp">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-4 col-form-label">Alamat</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" ref="email_cus" v-model="email_cus"  id="email_cus" placeholder="Email">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-4 col-form-label">PPN</label>
                    <div class="col-sm-8">
                       <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            PPN
                        </label>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-4 col-form-label">N.P.W.P</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" ref="NPWP_cus" v-model="NPWP_cus"  id="NPWP_cus" placeholder="N.P.W.P">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-4 col-form-label">Contact Person</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" ref="CP_cus" v-model="CP_cus"  id="CP_cus" placeholder="Contact Person">
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
                        <input type="text" ref="kode_cus_edit" v-model="kode_cus_edit" disabled placeholder="kode Jenis" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nama Jenis:</label>
                        <input type="text" ref="nama_cus_edit" v-model="nama_cus_edit" placeholder="Jenis Edit" class="form-control" >
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
                            <th style="width: 100px">Kode Customer</th>
                            <th>Nama Customer</th>
                            <th style="width: 300px">No Telp</th>
                            <th style="width: 300px">Email</th>
                            <th style="width: 200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in cuss" class="align-middle">
                            <td>@{{ data.id }}</td>
                            <td>@{{ data.kode_cus }}</td>
                            <td>@{{ data.nama_cus }}</td>
                            <td>@{{ data.notelp_cus }}</td>
                            <td>@{{ data.email_cus }}</td>
                            <td>
                                <button @click="detaildata(data)" class="btn btn-primary btn-sm">Detail</button>
                                <button @click="editModalNow(data)" class="btn btn-primary btn-sm">Edit</button>
                                <button @click="deleteData(data.id,data.nama_cus)" class="btn btn-danger btn-sm">x</button>
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
                cuss : null,
                kode_cus : null,
                nama_cus : null,
                notelp_cus : null,
                alamat_cus : null,
                email_cus : null,
                PPN_cus : null,
                NPWP_cus : null,
                PPH23_cus : null,
                CP_cus : null,
                kode_cus_edit : null,
                nama_cus_edit : null,
                notelp_cus_edit : null,
                alamat_cus_edit : null,
                email_cus_edit : null,
                PPN_cus_edit : null,
                NPWP_cus_edit : null,
                PPH23_cus_edit : null,
                CP_cus_edit : null,
                alert: false,
                links :null,
                search : null,
                customer : null,
                loading :false,
                id_edit : null
        },
        methods:{
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
                                $this.cuss = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
          loadData : function(){
              const $this = this;
                    axios.post("/load-cus", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                $this.cuss = response.data.data;
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
                         axios.post("/update-cus", {
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
                    axios.post("/search-cus", {
                            _token: _TOKEN_,
                            search: this.search
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.loading = false;
                                $this.cuss = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
            save: function() {
                    if (this.jenis == null) {
                        this.alert = false;
                        return
                    }
                    const $this = this;
                     axios.post("/save-cus", {
                                        _token: _TOKEN_,
                                        jenis: this.jenis,
                                        fk_jenis: this.fk_jenis
                                    })
                                    .then(function(response) {
                                        if (response.data.result) {
                                            $this.loadData();
                                            $this.alert = false;
                                            $this.jenis = null;
                                            $this.fk_jenis = null;
                                            alert("Tambah data sukses");
                                        }
                                    })
                                    .catch(function(error) {
                                        console.log(error);
                                    }); 
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
                                axios.post("/delete-cus", {
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
          //init object modal edit
          modal_edit = new bootstrap.Modal(document.getElementById('my_modal_edit'));
        }
      });
    </script>
                    
@endsection
