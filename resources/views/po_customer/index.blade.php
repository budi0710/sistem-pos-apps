@extends('layouts.index')
@section('title','PO Customer')
@section('main')
<div id="app" class="app-wrapper">
            <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="modal" @click="openPage">Tambah Data</button>
            <input type="text" class="form-control" @keyup="searchData" ref="search" v-model="search" placeholder="Cari Data" aria-label="Example text with button addon" aria-describedby="button-addon1">
            </div>

    <!-- Modal -->
    <div class="modal fade" id="my_modal_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Details Data PO Supplier</h5> 
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
                                <th>Qty POC</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="data in detail_pocustomer">
                                <th>@{{data.fk_brj}}</th>
                                <td>@{{data.fn_brj}}</td>
                                <td>@{{data.fpartno}}</td>
                                <td>@{{_moneyFormat(data.fharga)}}</td>
                                <td>@{{data.fq_poc}}</td>
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
    <!-- Open the modal edit using ID.showModal() method -->
        <!-- Modal -->
    <!-- Open the modal using ID.showModal() method -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 100px">No PO</th>
                            <th style="width: 200px">No PO Customer</th>
                            <th style="width: 100px">Tgl PO</th>
                            <th style="width: 100px">Customer</th>
                            <th style="width: 100px">PPN</th>
                            <th style="width: 100px">Decription</th>
                            <th style="width: 200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in h_pocs" class="align-middle">
                            <td>@{{ data.id }}</td>
                            <td>@{{ data.fno_poc }}</td>
                            <td>@{{ data.fno_poc_cus }}</td>
                            <td>@{{ data.ftgl_poc }}</td>
                            <td>@{{ data.nama_cus }}</td>
                            <td>@{{ data.PPN_cus }}</td>
                            <td>@{{ data.description }}</td>
                            <td>
                                <button @click="printPage(data.fno_poc)" class="btn btn-primary btn-sm">Print</button>
                                <button @click="DetailModal(data.fno_poc)" class="btn btn-primary btn-sm">Details</button>
                                <button @click="editData(data.id,data)" class="btn btn-primary btn-sm">Edit</button>
                                <button @click="deleteData(data.id,data.fno_poc)" class="btn btn-danger btn-sm">x</button>
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
                h_pocs : null,
                fk_jenis : null,
                fk_jenis_edit : null,
                detail_pocustomer : null,
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
                                $this.jeniss = response.data.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                    },
            openPage: function() {
                    window.location.href = './add-pocustomer';
                },
            printPage : function(fno_pos){
                    window.location.href = './print-pocustomer/'+fno_poc;
                },
            loadData : function(){
              const $this = this;
                    axios.post("/load-hpo-customer", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                $this.h_pocs = response.data.data;
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
            DetailModal: function(fno_poc) {
                    modal_edit.show();
                    const $this = this;
                    axios.post("/load-detail-pocustomer", {
                        _token: _TOKEN_,
                        fno_poc : fno_poc
                    })
                    .then(function(response) {
                    
                        if (response.data) {
                            $this.detail_pocustomer = response.data;
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
            save: function() {
                    if (this.jenis == null) {
                        this.alert = false;
                        return
                    }
                    const $this = this;
                     axios.post("/save-jenis-brj", {
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
                deleteData: function(id, fno_poc) {
                    if (id) {
                        const $this = this;
                        Swal.fire({
                            title: "Are you sure?",
                            text: "Apakah anda ingin menghapus data ini {" + fno_poc + "}",
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
