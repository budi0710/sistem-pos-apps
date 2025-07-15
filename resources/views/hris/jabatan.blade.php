@extends('layouts.index')
@section('title','Jabatan')
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
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Jabatan</h5> 
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Kode Jabatan:</label>
                    <input type="text" ref="fk_jabatan" disabled v-model="fk_jabatan" placeholder="kode Jabatan" class="form-control" id="recipient-name">
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Nama Jabatan:</label>
                    <input type="text" ref="fn_jabatan" v-model="fn_jabatan" placeholder="Nama Jabatan" class="form-control" id="recipient-name">
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Jabatan</h5> 
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Kode Jabatan:</label>
                        <input type="text" ref="fk_jabatan_edit" v-model="fk_jabatan_edit" disabled placeholder="kode Jabatan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nama Jabatan:</label>
                        <input type="text" ref="fn_jabatan_edit" v-model="fn_jabatan_edit" placeholder="Jabatan Edit" class="form-control" >
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
                            <th>Kode Jabatan</th>
                            <th>Jabatan</th>
                            <th style="width: 200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in jabatans" class="align-middle">
                            <td>@{{ data.id }}</td>
                            <td>@{{ data.fk_jabatan }}</td>
                            <td>@{{ data.fn_jabatan }}</td>
                            <td>
                                <button @click="editModalNow(data)" class="btn btn-primary btn-sm">Edit</button>
                                <button @click="deleteData(data.id,data.fn_jabatan)" class="btn btn-danger btn-sm">x</button>
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
                jabatans : null,
                fk_jabatan : null,
                fk_jabatan_edit : null,
                alert: false,
                fn_jabatan_edit : null,
                links :null,
                search : null,
                fn_jabatan : null,
                loading :false,
                id_edit : null
        },
        methods:{
            generateId() {
                const $this = this;
                axios.post("/generate-id-jabatan", {
                _token: _TOKEN_
                    })
                    .then(function(response) {
                        if (response.data) {
                             $this.$refs.fn_jabatan.focus();
                            const fk_jabatan = (response.data.fk_jabatan);
                            if (fk_jabatan==null){
                                return $this.fk_jabatan = generateNewId_Jabatan();
                            }else{
                                $this.fk_jabatan = generateNewId_Jabatan(fk_jabatan);
                                if ($this.fk_jabatan==="erorr"){
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
                                $this.jabatans = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
            loadData : function(){
              const $this = this;
                    axios.post("/load-jabatan", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                $this.jabatans = response.data.data;
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
                    $app.fk_jabatan_edit = data.fk_jabatan;
                    $app.fn_jabatan_edit = data.fn_jabatan;
                    //alert(data.id)
                },
            updateData: function(){
                    if (this.id_edit) {
                        const $this = this;
                         axios.post("/update-jabatan", {
                            _token: _TOKEN_,
                            fn_jabatan_edit: this.fn_jabatan_edit,
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
                    axios.post("/search-jabatan", {
                            _token: _TOKEN_,
                            search: this.search
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.loading = false;
                                $this.jabatans = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
            save: function() {
                    if (this.fn_jabatan == null) {
                        this.alert = false;
                        return
                    }
                    const $this = this;
                     axios.post("/save-jabatan", {
                                        _token: _TOKEN_,
                                        fn_jabatan: this.fn_jabatan,
                                        fk_jabatan: this.fk_jabatan
                                    })
                                    .then(function(response) {
                                        if (response.data.result) {
                                            $this.loadData();
                                            $this.alert = false;
                                            $this.fn_jabatan = null;
                                            $this.fk_jabatan = null;
                                            alert("Tambah data sukses");
                                        }
                                    })
                                    .catch(function(error) {
                                        console.log(error);
                                    }); 
                    this.generateId();  
                },
                deleteData: function(id, fn_jabatan) {
                    if (id) {
                        const $this = this;
                        Swal.fire({
                            title: "Are you sure?",
                            text: "Apakah anda ingin menghapus data ini {" + fn_jabatan + "}",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.loading = true;
                                axios.post("/delete-jabatan", {
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
          this.generateId();
          //init object modal edit
          modal_edit = new bootstrap.Modal(document.getElementById('my_modal_edit'));
        }
      });
    </script>
@endsection
