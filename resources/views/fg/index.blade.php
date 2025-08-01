@extends('layouts.index')
@section('title','Barang Jadi')
@section('main')
<div id="app" class="app-wrapper">
            <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="modal" data-bs-target="#my_modal_add">Tambah Data</button>
            <input type="text" class="form-control" @keyup="searchData" ref="search" v-model="search" placeholder="Cari Data" aria-label="Example text with button addon" aria-describedby="button-addon1">
            </div>

    <!-- Modal -->
        <div class="modal fade" id="my_modal_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Barang Jadi</h5> 
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Kode BRJ</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fk_brj" v-model="fk_brj"  id="fk_brj" placeholder="Kode BRJ">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama BRJ</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fn_brj" v-model="fn_brj" id="fn_brj" placeholder="Nama Barang Jadi">
                    </div>
                </div>
                <div class="row mb-3">
                <label for="colFormLabel" class="col-sm-3 col-form-label">Jenis BRJ</label>
                    <div class="col-sm-9">
                        <select id="result_jenis" v-model="result_jenis" class="form-select">
                            <option selected>Choose...</option>
                            <option v-for="data in data_jenis_brj" :value="data.fk_jns_brj">@{{ data.fn_jns_brj }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">PartNo</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fpartno" v-model="fpartno" id="fpartno" placeholder="Part No">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Bruto</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fbrt_bruto" v-model="fbrt_bruto" id="fbrt_bruto" placeholder="Berat Bruto">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Netto</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fbrt_neto" v-model="fbrt_neto" id="fbrt_neto" placeholder="Berat Netto">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Dimensi</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fdimensi" v-model="fdimensi" id="fdimensi" placeholder="Dimensi Panjang x Lebar x Tinggi">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Gambar</label>
                    <div class="col-sm-9">
                        <div class="avatar">
                            <div class="w-24 rounded-full">
                                <img :src="foto_barang" width="100" height="100"/>
                                {{-- untuk gambar masukan lebar dan tinggi ya supaya gambar tidak terllu besar --}}
                            </div>
                            </div>
                                <input  @keyup.enter="saveData" type="file" id="file_barang" name="file_barang" @change="changeImage($event)"
                                class="file-input file-input-ghost" />
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
            <h5 class="modal-title" id="exampleModalLabel">Edit Data Barang Jadi</h5> 
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Kode BRJ</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fk_brj_edit" v-model="fk_brj_edit"  id="fk_brj_edit" placeholder="Kode BRJ">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama BRJ</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fn_brj_edit" v-model="fn_brj_edit" id="fn_brj_edit" placeholder="Nama Barang Jadi">
                    </div>
                </div>
                <div class="row mb-3">
                <label for="colFormLabel" class="col-sm-3 col-form-label">Jenis BRJ</label>
                    <div class="col-sm-9">
                        <select v-model="result_jenis_edit" class="form-select">
                            <option selected>Pilih Jenis BRJ</option>
                            <option v-for="data in data_jenis_brj" :value="data.fk_jns_brj">@{{ data.fn_jns_brj }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">PartNo</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fpartno_edit" v-model="fpartno_edit" id="fpartno_edit" placeholder="Part No">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Bruto</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fbrt_bruto_edit" v-model="fbrt_bruto_edit" id="fbrt_bruto_edit" placeholder="Berat Bruto">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Netto</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fbrt_neto_edit" v-model="fbrt_neto_edit" id="fbrt_neto_edit" placeholder="Berat Netto">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Dimensi</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fdimensi_edit" v-model="fdimensi_edit" id="fdimensi_edit" placeholder="Dimensi Panjang x Lebar x Tinggi">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Gambar</label>
                    <div class="col-sm-9">
                        <div class="avatar">
                            <div class="w-24 rounded-full">
                                <img :src="foto_barang_edit" width="100" height="100" />
                            </div>
                            </div>
                                <input  @keyup.enter="saveData" type="file" id="file_barang_edit" name="file_barang_edit" @change="changeImageEdit($event)"
                                class="file-input file-input-ghost" />
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
            <table class="table table-hover table-striped align-middle shadow-sm">
                    <thead class="table-primary text-left">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 100px">Kode BRJ</th>
                            <th>Nama BRJ</th>
                            <th>Jenis BRJ</th>
                            <th style="width: 100px">Bruto</th>
                            <th style="width: 100px">Netto</th>
                            <th class="text-center">Foto</th>
                            <th style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr v-for="data in brjs" class="align-middle"> --}}
                        <tr v-for="(data, index) in brjs" :key="data.id" class="align-middle">
                            {{-- <td>@{{ data.id }}</td> --}}
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ data.fk_brj }}</td>
                            <td>@{{ data.fn_brj }}</td>
                            <td>@{{ data.fk_jns_brj }}</td>
                            <td>@{{ data.fbrt_bruto }}</td>
                            <td>@{{ data.fbrt_neto }}</td>
                            <td class="text-center">
                                <img :src="viewFoto(data.fgambar)" alt="" width="100" height="100" srcset="" class="img-thumbnail" style="max-width:80px;">
                            </td>
                            <td class="text-center">
                                <button @click="detaildata(data)" class="btn btn-info btn-sm me-1">Details</button>
                                <button @click="editModalNow(data)" class="btn btn-warning btn-sm me-1">Edit</button>
                                <button @click="deleteData(data.id,data.fn_brj)" class="btn btn-danger btn-sm">Hapus</button>
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
                brjs : null,
                fk_brj : null,
                fn_brj : null,
                result_jenis : null,
                fpartno : null,
                fbrt_neto : null,
                fbrt_bruto : null,
                fk_jenis_edit : null,
                fdimensi : null,
                fgambar : null,
                foto_barang: './no-image.png',
                file_barang: null,
                fk_brj_edit : null,
                fn_brj_edit : null,
                result_jenis_edit : null,
                fpartno_edit : null,
                fbrt_neto_edit : null,
                fbrt_bruto_edit : null,
                fk_jenis_edit : null,
                fdimensi_edit : null,
                foto_barang_edit: './no-image.png',
                file_barang_edit: null,
                alert: false,
                data_jenis_brj : null,
                links :null,
                search : null,
                jenis : null,
                loading :false,
                id_edit : null
        },
        methods:{
            viewFoto: function(data){
                return './storage/'+data
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
                                $this.brjs = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
          loadData : function(){
              const $this = this;
                    axios.post("/load-brj", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                $this.brjs = response.data.data;
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
                    $app.fk_brj_edit = data.fk_brj;
                    $app.fn_brj_edit = data.fn_brj;
                    $app.fpartno_edit = data.fpartno;
                    $app.result_jenis_edit = data.fk_jns_brj;
                    $app.fbrt_neto_edit = data.fbrt_neto;
                    $app.fbrt_bruto_edit = data.fbrt_bruto;
                    $app.fdimensi_edit = data.fdimensi;
                   // alert(data.fk_jns_brj)
                },
            updateData: function(){
                     const $this = this;
                    _upload = new Upload({
                        // Array
                        //el merupakan element 
                        //file_barang dari input file pada modal
                        el: ['file_barang_edit'],
                        // String
                        //url alamat route ya
                        url: '/update-brj',
                        // String
                        data: {
                            id_edit : this.id_edit,
                            fk_brj_edit : this.fk_brj_edit,
                            fn_brj_edit : this.fn_brj_edit,
                            result_jenis_edit : this.result_jenis_edit,
                            fpartno_edit : this.fpartno_edit,
                            fbrt_bruto_edit : this.fbrt_bruto_edit,
                            fbrt_neto_edit : this.fbrt_neto_edit,
                            fdimensi_edit : this.fdimensi_edit
                        },
                        // String
                        token: _TOKEN_
                    }).start(($response) => {
                        $this.loading = false;
                        var obj = JSON.parse($response)
                        if (obj.result) {
                            alert("Data berhasil ditambahkan")
                            $this.loadData()
                        }
                    });
              },
            searchData: function() {
                    if (this.search == null) {
                        this.$refs.search.focus()
                        return
                    }
                    this.loading = true;
                    const $this = this;
                    axios.post("/search-brj", {
                            _token: _TOKEN_,
                            search: this.search
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.loading = false;
                                $this.brjs = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
            changeImageEdit: function(e) {
                    var files = e.target.files || e.dataTransfer.files;
                    if (!files.length) {
                        return
                    }

                    if (files[0].type != 'image/png' && files[0].type != 'image/jpeg') {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "File must be image",
                            footer: ''
                        });
                        return;
                    }
                    this.foto_barang_edit = URL.createObjectURL(files[0])
                },
            changeImage: function(e) {
                    var files = e.target.files || e.dataTransfer.files;
                    if (!files.length) {
                        return
                    }

                    if (files[0].type != 'image/png' && files[0].type != 'image/jpeg') {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "File must be image",
                            footer: ''
                        });
                        return;
                    }
                    this.foto_barang = URL.createObjectURL(files[0])
                },   
            loadDataJenisBRJ: function() {
                    const $this = this;
                    axios.post("/load-data-jenis-brj", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.data_jenis_brj = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
            save: function() {
                    const $this = this;
                    _upload = new Upload({
                        // Array
                        //el merupakan element 
                        //file_barang dari input file pada modal
                        el: ['file_barang'],
                        // String
                        //url alamat route ya
                        url: '/save-brj',
                        // String
                        data: {
                            fk_brj : this.fk_brj,
                            fn_brj : this.fn_brj,
                            result_jenis : this.result_jenis,
                            fpartno : this.fpartno,
                            fbrt_bruto : this.fbrt_bruto,
                            fbrt_neto : this.fbrt_neto,
                            fdimensi : this.fdimensi
                        },
                        // String
                        token: _TOKEN_
                    }).start(($response) => {
                        $this.loading = false;
                        var obj = JSON.parse($response)
                        if (obj.result) {
                            $this.fk_brj = null,
                            $this.fn_brj = null,
                            $this.result_jenis = null,
                            $this.fpartno = null,
                            $this.fbrt_neto = null,
                            $this.fbrt_bruto = null,
                            $this.fdimensi = null,
                            $this.fgambar = null,
                            $this.foto_barang = './no-image.png',
                            $this.file_barang = null,
                            alert("Data berhasil ditambahkan")
                            $this.loadData()
                        }
                    });
 
                },
                deleteData: function(id, fn_brj) {
                    if (id) {
                        const $this = this;
                        Swal.fire({
                            title: "Are you sure?",
                            text: "Apakah anda ingin menghapus data ini {" + fn_brj + "}",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.loading = true;
                                axios.post("/delete-brj", {
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
          this.loadDataJenisBRJ();
          //init object modal edit
          modal_edit = new bootstrap.Modal(document.getElementById('my_modal_edit'));
        }
      });
    </script>
@endsection
