@extends('layouts.index')
@section('title','Relasi Supplier')
@section('main')
<div id="app" class="app-wrapper">
    <div class="input-group mb-3">
        <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="modal" data-bs-target="#my_modal_add">Tambah Data</button>
        <input type="text" class="form-control" @keyup="searchData" ref="search" v-model="search" placeholder="Cari Data" aria-label="Example text with button addon" aria-describedby="button-addon1">
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="my_modal_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Relasi</h5> 
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label">Nama Supplier</label>
                        <div class="col-sm-9">
                            <select class="form-select form-select-lg mb-3" v-model="result_supplier">
                                <option selected disabled>Pilih Nama Supplier</option>
                                <option v-for="data in suppliers" :key="data.kode_sup" :value="data.kode_sup">@{{data.nama_sup}}</option>
                            </select>
                            {{-- <v-select
                                v-if="suppliers.length"
                                :options="suppliers.map(b => ({ label: b.nama_sup, value: b.kode_sup }))"
                                v-model="result_supplier"
                                placeholder="Pilih atau Cari Supplier"
                                label="label">
                            </v-select> --}}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label">Nama Barang Gudang</label>
                        <div class="col-sm-9">
                            <!-- Vue Select Search -->
                            <v-select
                                v-if="barangs.length"
                                :options="barangs.map(b => ({ label: b.partname, value: b.kode_bg }))"
                                v-model="result_barangs"
                                placeholder="Pilih atau Cari Barang"
                                label="label">
                            </v-select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label">Nama Barang Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" v-model="fn_brg_sup" placeholder="Nama Barang Supplier" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label">No RBS</label>
                        <div class="col-sm-9">
                            <input type="text" v-model="fno_rbs" disabled placeholder="No RBS" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label">Harga Beli</label>
                        <div class="col-sm-9">
                            <input type="number" v-model="fharga_beli" placeholder="Harga Beli" class="form-control" maxlength="10">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label">Satuan Beli</label>
                        <div class="col-sm-9">
                            <input type="text" v-model="fsatuan_beli" placeholder="Satuan Beli" class="form-control" maxlength="10">
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

    <!-- Tabel Data -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Supplier</th>
                        <th>Kode BG</th>
                        <th>No RBS</th>
                        <th>Nama Barang Supplier</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="data in rls_brg_sups" :key="data.id" class="align-middle">
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
    </div>
</div>

<!-- Vue Select -->
<link rel="stylesheet" href="https://unpkg.com/vue-select@3.20.2/dist/vue-select.css">
<script src="https://unpkg.com/vue-select@3.20.2"></script>

<script>
Vue.component('v-select', VueSelect.VueSelect);
const _TOKEN_ = '<?= csrf_token() ?>';
var modal_edit;
const $app = new Vue({
    el: "#app",
    data: {
        rls_brg_sups: [],
        suppliers: [],
        barangs: [],
        result_supplier: null,
        result_barangs: null,
        fn_brg_sup: '',
        fno_rbs: '',
        fharga_beli: '',
        fsatuan_beli: '',
        links: [],
        search: '',
        loading: false,
        id_edit: null
    },
    methods: {
        resetForm() {
            this.result_supplier = null;
            this.result_barangs = null;
            this.fn_brg_sup = "";
            this.fsatuan_beli = "";
            this.fharga_beli = "";
            this.fno_rbs = "";
            },
        searchData() {
            if (!this.search) return this.loadData();
            axios.post("/search-rls-sup", { _token: _TOKEN_, search: this.search })
                 .then(res => { this.rls_brg_sups = res.data; });
        },
        loadData() {
            axios.post("/load-rls-sup", { _token: _TOKEN_ })
                 .then(res => { this.rls_brg_sups = res.data.data; this.links = res.data.links; });
        },
        loadSupplier() {
            axios.post("/load-data-sup", { _token: _TOKEN_ })
                 .then(res => { this.suppliers = res.data; });
        },
        loadBarangs() {
            axios.post("/load-data-brg", { _token: _TOKEN_ })
                 .then(res => { this.barangs = res.data || []; });
        },
        generateId() {
                const $this = this;
                axios.post("/generate-id-rls-sup", {
                _token: _TOKEN_
                    })
                    .then(function(response) {
                        if (response.data) {
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
        save() {
            axios.post("save-rls-sup", {
                _token: _TOKEN_,
                result_supplier: this.result_supplier,
                result_barangs: this.result_barangs?.value,
                fn_brg_sup: this.fn_brg_sup,
                fsatuan_beli: this.fsatuan_beli,
                fharga_beli: this.fharga_beli,
                fno_rbs: this.fno_rbs
            }).then(res => {
                if (res.data.result) {
                alert("Mantull Tambah data sukses");
                    this.loadData();
                    this.generateId();
                    this.resetForm();
                }
            });
        }
    },
    mounted() {
        this.loadData();
        this.loadSupplier();
        this.loadBarangs();
        this.generateId();
    }
});
</script>
@endsection
