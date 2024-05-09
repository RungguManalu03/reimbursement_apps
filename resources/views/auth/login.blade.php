<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.svg') }}">
</head>


<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <form action="{{ route('authenticate') }}" id="form-login" method="POST" autocomplete="off" class="sign-in-form">
                        {{ csrf_field() }}
                        <div class="logo">
                            <img src="{{ asset('assets/images/logo.png') }}"  style="width: 300px" />
                            <h4>Reimbursement Apps </h4>
                        </div>
                        <div class="heading">
                            <h2>Selamat Datang!</h2>
                        </div>
                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="number" class="input-field" autocomplete="off" id="nip" name="nip"  placeholder="NIP" required/>
                            </div>
                            <div class="input-wrap">
                                <input type="password" class="input-field" autocomplete="off"
                                   id="password" name="password" placeholder="Password" required />
                            </div>
                            <input type="submit" value="Login" class="sign-btn" />
                        </div>
                    </form>
                </div>
                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="assets/images/iconpage.svg" class="image img-1 show" alt="" />
                    </div>
                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>Reimbursement Apps Kasir Pintar</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $("#form-login").on('submit', function(e) {
            e.preventDefault();
            let form = this;

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: `{{ route('authenticate') }}`,
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil Login',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.location.href = res.redirectUrl;
                    } else {
                        if (res.errors) {
                            let errorMessage = '';

                            for (const field in res.errors) {
                                errorMessage += res.errors[field].join(', ') + '\n';
                            }

                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage,
                                showConfirmButton: true
                            });
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Error!',
                                text: res.message,
                                showConfirmButton: true
                            });
                        }
                    }
                },
                error: function(jqXHR) {
                    if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                        let errorMessage = '';

                        for (const field in jqXHR.responseJSON.errors) {
                            errorMessage += jqXHR.responseJSON.errors[field].join(', ') + '\n' + '<br>';
                        }

                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            html: errorMessage,
                            showConfirmButton: true
                        });
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: jqXHR.responseJSON ? jqXHR.responseJSON.message :
                                'Terjadi kesalahan pada server.',
                            showConfirmButton: true
                        });
                    }
                }
            });
        })
    </script>
</body>

</html>
