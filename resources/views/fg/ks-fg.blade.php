@extends('layouts.index')
@section('title','Kartu Stok FG')
@section('main')
<div id="app" class="app-wrapper">
    <div class="input-group mb-3">
        <button class="btn btn-outline-secondary" type="button" @click="prosesData">Proses Data</button>
        <select v-model="result_barangs" class="form-select">
            <option selected>Pilih Barang Jadi</option>
            <option v-for="data in barangs" :value="data.fk_brj">@{{ data.fn_brj }}</option>
        </select> |
        <select v-model="years" class="form-select">
            <option selected>Pilih Tahun</option>
            <option :value="y.year" v-for="y in year">@{{y.year}}</option>
        </select>
        <select v-model="bulans" class="form-select">
            <option selected>Pilih Bulan</option>
             <option :value="b.id" v-for="b in bulan">@{{b.name}}</option> 
        </select>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama BG</th>
                    <th>Tgl Transaksi</th>
                    <th>No Bukti</th>
                    <th>Keterangan</th>
                    <th>Qty In</th>
                    <th>Qty Out</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="data in barangs_ks" class="align-middle">
                    <td>@{{ data.fn_brj }}</td>
                    <td>@{{ data.ftgl_transaksi }}</td>
                    <td>@{{ data.fno_bukti }}</td>
                    <td>@{{ data.fket }}</td>
                    <td>@{{ data.fq_in }}</td>
                    <td>@{{ data.fq_out }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Total</td>
                    <td>@{{ totalQtyIn.toFixed(2) }}</td>
                    <td>@{{ totalQtyOut.toFixed(2) }}</td>
                </tr>
                <tr>
                    <td colspan="5">Saldo</td>
                    <td>@{{ saldo.toFixed(2) }}</td>
                </tr>
            </tfoot>    
        </table>
    </div>
</div>

<script>
    // const dropdownBulan = document.getElementById('bulan');
    // dropdownBulan.addEventListener('change', function() {
    //     const bulanDipilih = this.value;
    //     const namaBulan = this.options[this.selectedIndex].text;
    //     alert(`Anda memilih bulan: ${namaBulan} (Value: ${bulanDipilih})`);
    // });
</script>
<script>
    // function populateYears() {
    //   const dropdown = document.getElementById("tahunDropdown");
    //   const currentYear = new Date().getFullYear();
    //   const startYear = 2019; // Tahun awal, bisa disesuaikan

    //   for (let year = currentYear; year >= startYear; year--) {
    //     const option = document.createElement("option");
    //     option.value = year;
    //     option.text = year;
    //     dropdown.appendChild(option);
    //   }
    // }
    // populateYears(); // Panggil fungsi untuk mengisi dropdown saat halaman dimuat
  </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
<script>
const _TOKEN_ = '<?= csrf_token() ?>';
const $app =   new Vue({
        el : "#app",
        data: {
                barangs : null,
                barangs_ks : [],
                databarangs : null,
                result_barangs : null,
                kode_bg : null,
                partname : null,
                links :null,
                search : null,
                loading :false,
                id_edit : null,
                years : null,
                year : [],
                bulans : null,
                bulan : [
                    {
                        id : 1,
                        name : 'Januari'
                    },
                    {
                        id : 2,
                        name : 'Februari'
                    }
                    ,
                    {
                        id : 3,
                        name : 'Maret'
                    }
                    ,
                    {
                        id : 4,
                        name : 'April'
                    }
                    ,
                    {
                        id : 5,
                        name : 'Mei'
                    }
                    ,
                    {
                        id : 6,
                        name : 'Juni'
                    }
                    ,
                    {
                        id : 7,
                        name : 'Juli'
                    }
                    ,
                    {
                        id : 8,
                        name : 'Agustus'
                    }
                    ,
                    {
                        id : 9,
                        name : 'September'
                    }
                    ,
                    {
                        id : 10,
                        name : 'Oktober'
                    }
                    ,
                    {
                        id : 11,
                        name : 'November'
                    }
                    ,
                    {
                        id : 12,
                        name : 'Desember'
                    }

                ]
        },
        methods:{
            loadYears : function(){
                const $this = this;
                 axios.post("/load-years", {
                    _token: _TOKEN_
                })
                .then(function(response) {
                    if (response.data) {
                        let years = response.data;

                        let y = 20;
                        let new_year = [{
                            "year":years
                        }];
                        for (let index = 0; index < y; index++) {
                            years -= 1;
                            new_year.push({
                                "year":years
                            });
                        }
                        console.log(new_year)
                        $this.year = new_year;
                    }
                })
            },
            prosesData: function(){
                const $this = this;
                axios.post("/proses-data-ks-fg", {
                    _token: _TOKEN_,
                    year : this.years,
                    month : this.bulans,
                    barang : this.result_barangs
                })
                .then(function(response) {
                    if (response.data) {
                        $this.barangs_ks = response.data;
                      
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
            },
            loadData : function(){
                    const $this = this;
                    axios.post("/load-data-brj", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                $this.barangs = response.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
            loadDataKsFg : function(){
              const $this = this;
                    axios.post("/load-data-ksfg", {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            $this.loading = false;
                            if (response.data) {
                                $this.barangs_ks = response.data;
                                $this.links = response.data.links;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
          }
            
        },
        mounted(){
          this.loadData();
          this.loadDataKsFg();
          this.loadYears()
        },

    computed: {
        totalQtyIn() {
            return this.barangs_ks.reduce((total, item) => total + (parseFloat(item.fq_in) || 0), 0);
        },
        totalQtyOut() {
            return this.barangs_ks.reduce((total, item) => total + (parseFloat(item.fq_out) || 0), 0);
        },
        saldo() {
            return this.totalQtyIn - this.totalQtyOut;
        }
            }
      });
    </script>
@endsection
