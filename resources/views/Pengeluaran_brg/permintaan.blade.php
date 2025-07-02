@extends('layouts.index')
@section('title','STBJ')
@section('main')
<div id="app" class="app-wrapper">
            <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="modal" @click="openPage">Tambah Data</button>
            <input type="text" class="form-control" @keyup="searchData" ref="search" v-model="search" placeholder="Cari Data" aria-label="Example text with button addon" aria-describedby="button-addon1">
            </div>
    <!-- Modal -->

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
                    <table class="table table-hover">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>Kode Brg</th>
                                <th>Partname</th>
                                <th>Partno</th>
                                <th>Satua</th>
                                <th>Jenis</th>
                                <th>Qty BTBG</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="data in detail_btbg">
                                <th>@{{data.kode_bg}}</th>
                                <td>@{{data.partname}}</td>
                                <td>@{{data.partno}}</td>
                                <td>@{{data.fn_satuan}}</td>
                                <td>@{{data.fn_jenis}}</td>
                                <td>@{{data.fq_btbg}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                            <th style="width: 100px">No BTBG</th>
                            <th style="width: 100px">Tgl BTBG</th>
                            <th style="width: 100px">Nama BRJ</th>
                            <th style="width: 100px">Decription</th>
                            <th style="width: 200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in h_btbgs" class="align-middle">
                            <td>@{{ data.id }}</td>
                            <td>@{{ data.fno_btbg }}</td>
                            <td>@{{ data.ftgl_btbg  }}</td>
                            <td>@{{ data.fn_brj }}</td>
                            <td>@{{ data.description }}</td>
                            <td>
                                <button @click="printPage(data.fno_btbg)" class="btn btn-primary btn-sm">Print</button>
                                <button @click="DetailModal(data.fno_btbg)" class="btn btn-warning">Lihat Detail</button>
                                <button @click="editData(data.id,data)" class="btn btn-primary btn-sm">Edit</button>
                                <button @click="deleteData(data.id,data)" class="btn btn-danger btn-sm">x</button>
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
                detail_btbg : null,
                h_btbgs : null,
                alert: false,
                links :null,
                search : null,
                jenis : null,
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
                                $this.jeniss = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                    },
            openPage: function() {
                    window.location.href = './add-permintaan';
                },
            printPage : function(fno_pos){
                    window.location.href = './print-permintaan/'+fno_poc;
                },
            DetailModal: function(fno_btbg) {
                    my_modal_edit.showModal();
                    const $this = this;
                    axios.post("/load-detail-permintaan", {
                        _token: _TOKEN_,
                        fno_btbg : fno_btbg
                    })
                    .then(function(response) {
                    
                        if (response.data) {
                            $this.detail_btbg = response.data;
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                },  
            loadData : function(){
              const $this = this;
                    axios.post("/load-hbtbg", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                $this.h_btbgs = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
            searchData: function() {
                    if (this.search == null) {
                        this.$refs.search.focus()
                        return
                    }
                    this.loading = true;
                    const $this = this;
                    axios.post("/search-jenis-brj", {
                            _token: _TOKEN_,
                            search: this.search
                        })
                        .then(function(response) {
                            if (response.data) {
                                $this.loading = false;
                                $this.jeniss = response.data;
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
                                axios.post("/delete-jenis-brj", {
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
          modal_edit = new bootstrap.Modal(document.getElementById('my_modal_edit'));
        }
      });
    </script>                
@endsection
  <!-- Bootstrap Icons (opsional untuk icon gear) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
