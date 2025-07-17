@extends('layouts.index')
@section('title','Kartu Stok BG')
@section('main')
<div id="app" class="app-wrapper">
    <div class="input-group mb-3">
        <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="modal" data-bs-target="#my_modal_add">Proses Data</button>
        <select id="result_barangs" v-model="result_barangs" class="form-select">
            <option selected>Pilih Nama BG</option>
            <option v-for="data in barangs" :value="data.kode_bg">@{{ data.partname }}</option>
        </select> |
        <select id="tahunDropdown" class="form-select">
            <option selected>Pilih Thn</option>
        </select>
        <select id="bulan" class="form-select">
            <option selected>Pilih Bulan</option>
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>
            <option value="8">Agustus</option>
            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
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
                    <td>@{{ data.fn_BG }}</td>
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
    const dropdownBulan = document.getElementById('bulan');

    dropdownBulan.addEventListener('change', function() {
        const bulanDipilih = this.value;
        const namaBulan = this.options[this.selectedIndex].text;
        alert(`Anda memilih bulan: ${namaBulan} (Value: ${bulanDipilih})`);
    });
</script>
<script>
    function populateYears() {
      const dropdown = document.getElementById("tahunDropdown");
      const currentYear = new Date().getFullYear();
      const startYear = 2019; // Tahun awal, bisa disesuaikan

      for (let year = currentYear; year >= startYear; year--) {
        const option = document.createElement("option");
        option.value = year;
        option.text = year;
        dropdown.appendChild(option);
      }
    }

    populateYears(); // Panggil fungsi untuk mengisi dropdown saat halaman dimuat
  </script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
<script>
const _TOKEN_ = '<?= csrf_token() ?>';
const $app =   new Vue({
        el : "#app",
        data: {
                barangs : null,
                databarangs : null,
                barangs_ks : [],
                result_barangs : null,
                kode_bg : null,
                partname : null,
                links :null,
                search : null,
                loading :false,
                id_edit : null
        },
        methods:{
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
          loadDataKsBg : function(){
              const $this = this;
                    axios.post("/load-data-ksbg", {
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
          this.loadDataKsBg();
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
