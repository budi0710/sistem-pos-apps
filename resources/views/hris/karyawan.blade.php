@extends('layouts.index')
@section('title','Karyawan')
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Karyawan</h5> 
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">No KTP</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fno_ktp" v-model="fno_ktp"  id="fno_ktp" placeholder="No KTP">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">NIK</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fnik" v-model="fnik" id="fnik" placeholder="NIK">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fnama_kry" v-model="fnama_kry" id="fnama_kry" placeholder="Nama Lengkap">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Kelamin</label>
                    <div class="col-sm-9">
                            <label><input type="radio" name="gender" value="male"> Laki-laki</label>
                            <label><input type="radio" name="gender" value="female"> Perempuan</label>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                        <select id="result_satuan_edit" v-model="result_satuan_edit" class="form-select">
                            <option selected>Status Pernikahan</option>
                            <option v-for="data in data_status" :value="data.id">@{{ data.statusnikah }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">No Telp</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fberat_netto" v-model="fberat_netto" id="fberat_netto" placeholder="No Telp">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" ref="falamat" v-model="falamat" id="falamat"  rows="3" placeholder="Alamat Lengkap"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                <label for="colFormLabel" class="col-sm-3 col-form-label">Unit Kerja</label>
                    <div class="col-sm-9">
                        <select id="result_unit" v-model="result_unit" class="form-select">
                            <option selected>Pilih Unit Kerja</option>
                            <option v-for="data in data_unitkerja" :value="data.fk_unitkerja">@{{ data.fn_unitkerja }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                <label for="colFormLabel" class="col-sm-3 col-form-label">Jabatan</label>
                    <div class="col-sm-9">
                        <select id="result_jabatan" v-model="result_jabatan" class="form-select">
                            <option selected>Pilih Jabatan</option>
                            <option v-for="data in data_jabatan" :value="data.fk_jabatan">@{{ data.fn_jabatan }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
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
            <h5 class="modal-title" id="exampleModalLabel">Edit Data Karyawan</h5> 
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Kode BG</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="kode_bg_edit" v-model="kode_bg_edit"  id="kode_bg_edit" placeholder="Kode BG">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Part Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="partname_edit" v-model="partname_edit" id="partname_edit" placeholder="Part Name">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Part No</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="partno_edit" v-model="partno_edit" id="partno_edit" placeholder="Part No">
                    </div>
                </div>
                <div class="row mb-3">
                <label for="colFormLabel" class="col-sm-3 col-form-label">Jenis BG</label>
                    <div class="col-sm-9">
                        <select id="result_jenis_edit" v-model="result_jenis_edit" class="form-select">
                            <option selected>Choose...</option>
                            <option v-for="data in data_status" :value="data.fk_jenis">@{{ data.fn_jenis }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Satuan BG</label>
                    <div class="col-sm-9">
                        <select id="result_satuan_edit" v-model="result_satuan_edit" class="form-select">
                            <option selected>Choose...</option>
                            <option v-for="data in data_satuan_brg" :value="data.fk_sat">@{{ data.fn_satuan }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Descripsi</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" ref="description_edit" v-model="description_edit" id="description_edit" rows="3"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Netto</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fberat_netto_edit" v-model="fberat_netto_edit" id="fberat_netto_edit" placeholder="Berat Netto">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                        <select id="result_satuan_edit" v-model="result_satuan_edit" class="form-select">
                            <option selected>Choose...</option>
                            <option v-for="data in data_satuan_brg" :value="data.fk_sat">@{{ data.fn_satuan }}</option>
                        </select>
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
            <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 100px">NIK</th>
                            <th>Nama Karyawan</th>
                            <th>Unit Kerja</th>
                            <th style="width: 100px">Jabatan</th>
                            <th style="width: 100">Foto</th>
                            <th style="width: 200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in barangs" class="align-middle">
                            <td>@{{ data.id }}</td>
                            <td>@{{ data.fnip }}</td>
                            <td>@{{ data.fnama_kry }}</td>
                            <td>@{{ data.fn_unitkerja }}</td>
                            <td>@{{ data.fn_jabatan }}</td>
                            <td>@{{ data.Fphoto }}</td>
                            <td>
                                <img :src="viewFoto(data.fgambar)" alt="" width="100" height="100" srcset="">
                            </td>
                            <td>
                                <button @click="detaildata(data)" class="btn btn-primary btn-sm">Details</button>
                                <button @click="editModalNow(data)" class="btn btn-primary btn-sm">Edit</button>
                                <button @click="deleteData(data.id,data.partname)" class="btn btn-danger btn-sm">x</button>
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
                barangs : null,
                fno_ktp : null,
                fnik : null,
                fnama_kry : null,
                fpartno : null,
                falamat : null,
                fgambar : null,
                result_jabatan : null,
                result_unit : null,
                foto_barang : './no-image.png',
                fgambar_edit : null,
                foto_barang_edit: './no-image.png',
                file_barang_edit: null,
                alert: false,
                data_unitkerja : null,
                data_jabatan : null,
                data_status : null,
                links :null,
                search : null,
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
                                $this.barangs = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
          loadData : function(){
              const $this = this;
                    axios.post("/load-karyawan", {
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
          },
            editModalNow: function(data) {
                    modal_edit.show();
                    $app.id_edit = data.id;
                    $app.kode_bg_edit = data.kode_bg;
                    $app.partname_edit = data.partname;
                    $app.partno_edit = data.partno;
                    $app.result_satuan_edit = data.fk_sat;
                    $app.result_jenis_edit = data.fk_jenis;
                    $app.fberat_netto_edit = data.fberat_netto;
                    $app.description_edit = data.description;
                    $app.saldo_awal_edit = data.saldo_awal;
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
                        url: '/update-brg',
                        // String
                        data: {
                            id_edit : this.id_edit,
                            kode_bg_edit : this.kode_bg_edit,
                            partname_edit : this.partname_edit,
                            partno_edit : this.partno_edit,
                            result_jenis_edit : this.result_jenis_edit,
                            result_satuan_edit : this.result_satuan_edit,
                            fberat_netto_edit : this.fberat_netto_edit,
                            description_edit : this.description_edit,
                            saldo_awal_edit : this.saldo_awal_edit
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
                    axios.post("/search-karyawan", {
                            _token: _TOKEN_,
                            search: this.search
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.loading = false;
                                $this.barangs = response.data;
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
            loadDataUnitKerja: function() {
                    const $this = this;
                    axios.post("/load-data-unitkerja", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.data_unitkerja = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                loadDataJabatan: function() {
                    const $this = this;
                    axios.post("/load-data-jabatan", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.data_jabatan = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                loadDataStatus: function() {
                    const $this = this;
                    axios.post("/load-data-statusnikah", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.data_status = response.data;
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
                        url: '/save-brg',
                        // String
                        data: {
                            kode_bg : this.kode_bg,
                            partname : this.partname,
                            partno : this.partno,
                            result_jenis : this.result_jenis,
                            result_satuan: this.result_satuan,
                            fberat_netto : this.fberat_netto,
                            description : this.description,
                            saldo_awal : this.saldo_awal
                        },
                        // String
                        token: _TOKEN_
                    }).start(($response) => {
                        $this.loading = false;
                        var obj = JSON.parse($response)
                        if (obj.result) {
                            alert("Selamat Data berhasil ditambahkan")
                            $this.loadData()
                        }
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
                                axios.post("/delete-karyawan", {
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
          this.loadDataUnitKerja();
          this .loadDataJabatan();
          this .loadDataStatus();
          modal_edit = new bootstrap.Modal(document.getElementById('my_modal_edit'));
        }
      });
    </script>
@endsection
