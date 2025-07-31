@extends('layouts.index')
@section('title','Pengiriman')
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Details Data Kirim Customer</h5> 
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
                                <th>Harga</th>
                                <th>Qty Kirim</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="data in detail_kirim">
                                <th>@{{data.fk_brj}}</th>
                                <td>@{{data.fn_brj}}</td>
                                <td>@{{data.fpartno}}</td>
                                <td>@{{_moneyFormat(data.fharga)}}</td>
                                <td>@{{data.fq_krm}}</td>
                                <td>@{{_moneyFormat(data.Fjumlah)}}</td>
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
                            <th style="width: 100px">No Kirim</th>
                            <th style="width: 100px">Tgl Kirim</th>
                            <th style="width: 100px">Customer</th>
                            <th style="width: 100px">Supir</th>
                            <th style="width: 100px">Decription</th>
                            <th style="width: 200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in kirim" class="align-middle">
                            <td>@{{ data.id }}</td>
                            <td>@{{ data.fno_krm }}</td>
                            <td>@{{ data.ftgl_krm }}</td>
                            <td>@{{ data.nama_cus }}</td>
                            <td>@{{ data.fnama_supir }}</td>
                            <td>@{{ data.description }}</td>
                            <td>
                                <button @click="printPage(data.fno_krm)" class="btn btn-primary btn-sm">Print</button>
                                <button @click="DetailModal(data.fno_krm)" class="btn btn-primary btn-sm">Details</button>
                                <button @click="editData(data.id,data)" class="btn btn-primary btn-sm">Edit</button>
                                <button @click="deleteData(data.id,data.fno_krm)" class="btn btn-danger btn-sm">x</button>
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
                kirim : null,
                detail_kirim : null,
                fk_jenis : null,
                fk_jenis_edit : null,
                alert: false,
                jenis_edit : null,
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
                                $this.kirim = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                    },
            openPage: function() {
                    window.location.href = './add_kirim';
                },
            printPage : function(fno_pos){
                    window.location.href = './print-pocustomer/'+fno_poc;
                },
            loadData : function(){
              const $this = this;
                    axios.post("/load-hkrm-customer", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                $this.kirim = response.data.data;
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
                    $app.fk_jenis_edit = data.fk_jns_brj;
                    $app.jenis_edit = data.fn_jns_brj;
                    //alert(data.id)
                },
                    updateData: function(){
                    if (this.id_edit) {
                        const $this = this;
                         axios.post("/update-jenis-brj", {
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
            DetailModal: function(fno_krm) {
                    modal_edit.show();
                    const $this = this;
                    axios.post("/load-detail-kirim", {
                        _token: _TOKEN_,
                        fno_krm : fno_krm
                    })
                    .then(function(response) {
                    
                        if (response.data) {
                            $this.detail_kirim = response.data;
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
                                $this.kirim = response.data;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                deleteData: function(id, fno_krm) {
                    if (id) {
                        const $this = this;
                        Swal.fire({
                            title: "Are you sure?",
                            text: "Apakah anda ingin menghapus data ini {" + fno_krm + "}",
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
            //his.DetailModal();
            this.loadData();
            modal_edit = new bootstrap.Modal(document.getElementById('my_modal_edit'));
        }
      });
    </script>                
@endsection
