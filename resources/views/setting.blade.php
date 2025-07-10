@extends('layouts.index')
@section('title', 'About')
@section('main')


    <div class="card" id="app">
        <div class="card-body">
            <center>
                <img :src="foto_company" class="rounded float-start" height="100" width="100" alt="...">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupFile01">Upload</label>
                    <input @change="changeFoto($event)" type="file" id="logo_company" name="logo_company"
                        class="form-control" id="logo_company">
                </div>
            </center>
            <hr>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Latitude</span>
                <input type="text" class="form-control" placeholder="Latitude" ref="latitude" v-model="latitude"
                    aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Longitude</span>
                <input type="text" class="form-control" placeholder="Longitude" ref="longitude" v-model="longitude"
                    aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Radius</span>
                <input type="text" class="form-control" placeholder="Radius" v-model="radius" ref="radius"
                    aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Name Company</span>
                <input type="text" class="form-control" placeholder="Name Company" v-model="name_company"
                    ref="name_company" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <button type="button" class="btn btn-primary" @click="save">Save</button>
        </div>
    </div>

    <script>
        const _TOKEN_ = '<?= csrf_token() ?>';
        new Vue({
            el: "#app",
            data: {
                latitude: "<?= $latitude ?>",
                longitude: "<?= $longitude ?>",
                radius: "<?= $radius ?>",
                foto_company: "./storage/"+"<?= $logo ?>",
                name_company: "<?= $name_company ?>"
            },
            methods: {
                changeFoto: function(e) {
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
                    this.foto_company = URL.createObjectURL(files[0]);
                    const $this = this;
                    _upload = new Upload({
                        // Array
                        el: ['logo_company'],
                        // String
                        url: '/upload-foto-company',
                        // String
                        data: {
                            id: 1
                        },
                        // String
                        token: _TOKEN_
                    }).start(($response) => {
                        var obj = JSON.parse($response)

                        if (obj.result) {
                            alert("Berhasil Upload Foto")
                            
                        }
                    });
                },
                save: function() {
                    if (this.latitude == null) {
                        this.$refs.latitude.focus();
                        return;
                    }
                    if (this.longitude == null) {
                        this.$refs.longitude.focus();
                        return;
                    }
                    if (this.radius == null) {
                        this.$refs.radius.focus();
                        return;
                    }

                    const $this = this;
                    // membuat request ke server dengan method POST ke route login
                    axios.post("/save-setting", {
                            // mengirimkan data email dan password ke server
                            latitude: this.latitude,
                            longitude: this.longitude,
                            radius: this.radius,
                            name_company : this.name_company,
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            // check response dari server response.data.result jika false maka menampilkan pesan
                            if (response.data.result === false) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Something went wrong!",
                                    footer: ''
                                });
                            } else {
                                Swal.fire({
                                    icon: "success",
                                    title: "Mantap",
                                    text: "Data berhasil disimpan ",
                                    footer: ''
                                });

                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
            },
        })
    </script>

@endsection
