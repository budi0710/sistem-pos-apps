@extends('layouts.index')
@section('title', 'Absensi')
@section('main')
    <h1>Halaman Absen</h1>

    <div class="container" id="app">
        <div class="card">
            <div class="card-body">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#absenMasuk" aria-expanded="true" aria-controls="absenMasuk">
                                Absen Masuk
                            </button>
                        </h2>
                        <div id="absenMasuk" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <center>
                                    <video class="img-thumbnail" id="imageAbsenMasuk" name="imageAbsenMasuk" autoplay
                                        playsinline></video>
                                </center>
                                <br>
                                <center>
                                    <button class="btn btn-primary" id="btnAbsenMasuk" @click="uploadAbsenMasuk">Absen
                                        Masuk</button>
                                    <canvas id="canvasMasuk" width="400" height="300" style="display:none;"></canvas>
                                    {{-- <a id="download" class="download" download="snapshot.png">Download Gambar</a> --}}
                                </center>
                                <hr>

                                <p>
                                <h1 id="result"></h1>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#absenPulang" aria-expanded="false" aria-controls="absenPulang">
                                Absen Pulang
                            </button>
                        </h2>
                        <div id="absenPulang" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <center>
                                    <video class="img-thumbnail" id="imageAbsenPulang" name="imageAbsenPulang" autoplay
                                        playsinline></video>
                                </center>
                                <br>
                                <center>
                                    <button class="btn btn-primary" id="btnAbsenPulang" @click="uploadAbsenPulang">Absen
                                        Pulang</button>
                                    <canvas id="canvasPulang" width="400" height="300" style="display:none;"></canvas>
                                    {{-- <a id="download" class="download" download="snapshot.png">Download Gambar</a> --}}
                                </center>
                                <hr>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script>
        const _TOKEN_ = '<?= csrf_token() ?>';
        let imageAbsenMasuk, imageAsbenPulang;
        let canvasMasuk, canvasPulang;
        let videoMasuk, videoPulang;
        let btnmasuk ;
        let btnpulang;

        function getDistanceFromLatLonInMeters(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // Radius bumi dalam meter
            const toRad = deg => deg * (Math.PI / 180);

            const dLat = toRad(lat2 - lat1);
            const dLon = toRad(lon2 - lon1);

            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);

            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            const distance = R * c;
            return distance; // hasil dalam meter
        }

        navigator.geolocation.getCurrentPosition(
            position => {
                const userLat = position.coords.latitude;
                const userLon = position.coords.longitude;

                axios.post("/get-setting", {
                    _token: _TOKEN_
                })
                .then(function(response) {
                    
                         const kantorLat = response.data.latitude;
                        const kantorLon = response.data.longitude;
                        console.log(kantorLat)
                        console.log(kantorLon)
                        const distance = getDistanceFromLatLonInMeters(kantorLat, kantorLon, userLat, userLon);
                    
                        const result = document.getElementById('result');

                       

                        if (distance <= response.data.radius) {
                            alert('✅ Anda dalam radius, absen OK')
                            btnmasuk.disabled= false;
                            btnpulang.disabled= false;
                        } else {
                            alert('❌ Di luar radius, tidak bisa absen')
                            btnmasuk.disabled= true;
                            btnpulang.disabled= true;
                        }
                })
                .catch(function(error) {
                    console.log(error);
                });

            },
            error => {
                alert("Gagal mendapatkan lokasi: " + error.message);
            }
        );

        new Vue({
            el: "#app",
            data: {

            },
            methods: {
                uploadAbsenPulang: function() {
                    canvasPulang.width = videoPulang.videoWidth;
                    canvasPulang.height = videoPulang.videoHeight;
                    const context = canvasPulang.getContext('2d');
                    context.drawImage(videoPulang, 0, 0, canvasPulang.width, canvasPulang.height);

                    // Ubah ke blob (image)
                    canvasPulang.toBlob(blob => {
                        const formData = new FormData();
                        formData.append('imageAbsenPulang', blob, 'absenOut.jpg');

                        var myswal = Swal.fire({
                            title: "Please Wait",
                            text: "Absen pulang anda sedang di proses",
                            icon: "question",
                            showCloseButton: false,
                            showCancelButton: false,
                            showConfirmButton: false
                        });

                        fetch('./upload-absen-pulang', {
                                method: 'POST',
                                body: formData,
                                credentials: "same-origin",
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.text())
                            .then(data => {
                                var obj = JSON.parse(data);
                                if (obj.result == true) {
                                    Swal.fire({
                                        title: "Good",
                                        text: "Absen pulang Berhasil Disimpan",
                                        icon: "success"
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Good",
                                        text: "Absen pulang gagal Disimpan",
                                        icon: "error"
                                    });
                                }
                            })
                            .catch(error => {
                                console.error("Upload error:", error);
                                alert("Terjadi kesalahan saat upload.");
                            });
                    }, 'image/jpeg');
                },
                uploadAbsenMasuk: function() {
                    canvasMasuk.width = videoMasuk.videoWidth;
                    canvasMasuk.height = videoMasuk.videoHeight;
                    const context = canvasMasuk.getContext('2d');
                    context.drawImage(videoMasuk, 0, 0, canvasMasuk.width, canvasMasuk.height);

                    // Ubah ke blob (image)
                    canvasMasuk.toBlob(blob => {
                        const formData = new FormData();
                        formData.append('imageAbsenMasuk', blob, 'absenIn.jpg');

                        var myswal = Swal.fire({
                            title: "Please Wait",
                            text: "Absen masuk anda sedang di proses",
                            icon: "question",
                            showCloseButton: false,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        fetch('./upload-absen-masuk', {
                                method: 'POST',
                                body: formData,
                                credentials: "same-origin",
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.text())
                            .then(data => {
                                var obj = JSON.parse(data);

                                if (obj.result == true) {
                                    Swal.fire({
                                        title: "Good",
                                        text: "Absen masuk Berhasil Disimpan",
                                        icon: "success"
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Good",
                                        text: "Absen masuk gagal Disimpan",
                                        icon: "error"
                                    });
                                }
                            })
                            .catch(error => {
                                console.error("Upload error:", error);
                                alert("Terjadi kesalahan saat upload.");
                            });
                    }, 'image/jpeg');
                }
            },
            mounted() {
                videoMasuk = document.getElementById("imageAbsenMasuk");
                canvasMasuk = document.getElementById('canvasMasuk');

                videoPulang = document.getElementById("imageAbsenPulang");
                canvasPulang = document.getElementById('canvasPulang');
                
                btnmasuk = document.getElementById('btnAbsenMasuk')
                btnpulang = document.getElementById('btnAbsenPulang')

                btnmasuk.disabled = true;
                btnpulang.disabled=true;

                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(stream => {
                        videoMasuk.srcObject = stream;
                    })
                    .catch(err => {
                        alert("Gagal mengakses kamera: " + err);

                        btnmasuk.disabled = true;
                        btnpulang.disabled=true;
                        // window.location.href = "."
                    });

                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(stream => {
                        videoPulang.srcObject = stream;
                    })
                    .catch(err => {
                        alert("Gagal mengakses kamera: " + err);
                        // window.location.href = "."
                        btnmasuk.disabled = true;
                        btnpulang.disabled=true;
                    });

            },
        })
    </script>
@endsection
