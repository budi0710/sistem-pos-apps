@extends('layouts.index')
@section('title','BRG')
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Barang Gudang</h5> 
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Kode BG</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="kode_bg" v-model="kode_bg"  id="kode_bg" placeholder="Kode BG">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Part Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="partname" v-model="partname" id="partname" placeholder="Part Name">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Part No</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="partno" v-model="partno" id="partno" placeholder="Part No">
                    </div>
                </div>
                <div class="row mb-3">
                <label for="colFormLabel" class="col-sm-3 col-form-label">Jenis BG</label>
                    <div class="col-sm-9">
                        <select id="result_jenis" v-model="result_jenis" class="form-select">
                            <option selected>Choose...</option>
                            <option v-for="data in data_jenis_brg" :value="data.fk_jenis">@{{ data.fn_jenis }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                <label for="colFormLabel" class="col-sm-3 col-form-label">Satuan BG</label>
                    <div class="col-sm-9">
                        <select id="result_satuan" v-model="result_satuan" class="form-select">
                            <option selected>Choose...</option>
                            <option v-for="data in data_satuan_brg" :value="data.fk_sat">@{{ data.fn_satuan }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Descripsi</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" ref="description" v-model="description" id="description_edit"  rows="3"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Netto</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="fberat_netto" v-model="fberat_netto" id="fberat_netto" placeholder="Berat Netto">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Stock</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="saldo_awal" v-model="saldo_awal" id="saldo_awal" placeholder="Stok">
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
                            <option v-for="data in data_jenis_brg" :value="data.fk_jenis">@{{ data.fn_jenis }}</option>
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
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Saldo Awal</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ref="saldo_awal_edit" v-model="saldo_awal_edit" id="saldo_awal_edit" placeholder="Stok">
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
                        <th style="width: 100px;">Kode BG</th>
                        <th>Part Name</th>
                        <th>Part No</th>
                        <th class="text-right"  style="width: 150px;">Berat Netto</th>
                        <th class="text-right"  style="width: 150px;">Saldo Awal</th>
                        <th class="text-center"  style="width: 120px;">Foto</th>
                        <th style="width: 250px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, index) in barangs" :key="data.id">
                        <td class="text-center">@{{ index + 1 }}</td>
                        <td>@{{ data.kode_bg }}</td>
                        <td>@{{ data.partname }}</td>
                        <td>@{{ data.partno }}</td>
                        <td class="text-end">@{{ data.fberat_netto }}</td>
                        <td class="text-end">@{{ data.saldo_awal }}</td>
                        <td class="text-center">
                            <img :src="viewFoto(data.fgambar_brg)" class="img-thumbnail" style="max-width:80px;">
                        </td>
                        <td class="text-center">
                            <button @click="detaildata(data)" class="btn btn-info btn-sm me-1">Details</button>
                            <button @click="editModalNow(data)" class="btn btn-warning btn-sm me-1">Edit</button>
                            <button @click="deleteData(data.id,data.partname)" class="btn btn-danger btn-sm">Hapus</button>
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
                kode_bg : null,
                partname : null,
                partno : null,
                fpartno : null,
                descripsi : null,
                fk_sat : null,
                fk_jenis : null,
                harga : null,
                fberat_netto : null,
                fgambar : null,
                saldo_awal : null,
                result_jenis : null,
                result_satuan : null,
                description : null,
                foto_barang : './no-image.png',
                file_barang : null,
                kode_bg_edit : null,
                partname_edit : null,
                partno_edit : null,
                fpartno_edit : null,
                descripsi_edit : null,
                fk_sat_edit : null,
                fk_jenis_edit : null,
                harga_edit : null,
                fberat_netto_edit : null,
                description_edit : null,
                fgambar_edit : null,
                saldo_awal_edit : null,
                result_jenis_edit : null,
                foto_barang_edit: './no-image.png',
                file_barang_edit: null,
                alert: false,
                data_jenis_brg : null,
                data_satuan_brg : null,
                result_satuan_edit : null,
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
            updateData: function () {
                    const $this = this;

                    // Buat FormData untuk kirim file dan field lainnya
                    let formData = new FormData();

                    // Ambil file (jika ada) dari input file
                    const fileInput = document.getElementById('file_barang_edit');
                    if (fileInput && fileInput.files.length > 0) {
                        formData.append('file_barang_edit', fileInput.files[0]);
                    }

                    // Tambahkan semua data lainnya
                    formData.append('id_edit', this.id_edit);
                    formData.append('kode_bg_edit', this.kode_bg_edit);
                    formData.append('partname_edit', this.partname_edit);
                    formData.append('partno_edit', this.partno_edit);
                    formData.append('result_jenis_edit', this.result_jenis_edit);
                    formData.append('result_satuan_edit', this.result_satuan_edit);
                    formData.append('fberat_netto_edit', this.fberat_netto_edit);
                    formData.append('description_edit', this.description_edit);
                    formData.append('saldo_awal_edit', this.saldo_awal_edit);

                    // CSRF Token
                    formData.append('_token', _TOKEN_);

                    // Kirim ke server
                    axios.post('/update-brg', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(res => {
                        const obj = res.data;
                        if (obj.result) {
                            alert("Data berhasil diupdate");
                            $this.loadData();
                        } else {
                            alert("Gagal update: " + (obj.message || 'Unknown error'));
                        }
                    }).catch(err => {
                        console.error("Error saat update:", err);
                        alert("Terjadi kesalahan saat update data.");
                    });
                },
            searchData: function() {
                    if (this.search == null) {
                        this.$refs.search.focus()
                        return
                    }
                    this.loading = true;
                    const $this = this;
                    axios.post("/search-brg", {
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
            loadDataJenisBRG: function() {
                    const $this = this;
                    axios.post("/load-data-jenis", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.data_jenis_brg = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
            loadDataSatuanBRG: function() {
                    const $this = this;
                    axios.post("/load-data-satuan", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.data_satuan_brg = response.data;
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
                       // console.log(x.responseText); // Debug response
                        if (obj.result) {
                            $this.kode_bg = null;
                            $this.partname = null;
                            $this.partno = null;
                            $this.fpartno = null;
                            $this.descripsi = null;
                            $this.fk_sat = null;
                            $this.fk_jenis = null;
                            $this.harga = null;
                            $this.fberat_netto = null;
                            $this.fgambar = null;
                            $this.saldo_awal = null;
                            $this.result_jenis = null;
                            $this.result_satuan = null;
                            $this.description = null;
                            $this.foto_barang = './no-image.png';
                            $this.file_barang = null;
                            alert("Selamat Data berhasil ditambahkan")
                            $this.loadData()
                        }

                    });
 
                },
                deleteData: function(id, partname) {
                    if (id) {
                        const $this = this;
                        Swal.fire({
                            title: "Are you sure?",
                            text: "Apakah anda ingin menghapus data ini {" + partname + "}",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.loading = true;
                                axios.post("/delete-brg", {
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
          this.loadDataJenisBRG();
          this .loadDataSatuanBRG();
          modal_edit = new bootstrap.Modal(document.getElementById('my_modal_edit'));
        }
      });
    </script>
@endsection
