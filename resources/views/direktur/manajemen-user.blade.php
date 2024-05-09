@extends('../layouts/master')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" />
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                 <div class="row row-sm ">
                    <div class="col-xl-12 col-md-12 col-lg-12 ">
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary float-end fs-11" data-bs-toggle="modal"
                                    data-bs-target="#addUserModal"><i class="ri-add-line"></i> Tambah User</button>
                                <h5 class="card-title mt-2">List User Reimbursement Apps</h5>
                            </div>
                            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                                <h4 class="card-title mg-b-10">Halaman Manajemen User</h4>
                                <div class="d-flex justify-content-between">
                                     <div class="card-body table-responsive">
                                        <table id="user-list" class="table table-bordered dt-responsive table-striped align-middle"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>NIP</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-modal="true"
        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="formTambahUser">
                        @csrf
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div>
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Masukkan nama lengkap" required="required">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip"
                                        placeholder="Masukkan NIP" required="required" maxlength="18"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                            </div>
                           <div class="col-lg-12">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <select class="form-control" name="jabatan" id="jabatan" required="required">
                                    <option value="" selected disabled>Pilih Jabatan</option>
                                    <option value="DIREKTUR">DIREKTUR</option>
                                    <option value="FINANCE">FINANCE</option>
                                    <option value="STAFF">STAFF</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        autocomplete="new-password" required="required">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailUserModal" tabindex="-1" aria-labelledby="detailUserModalLabel" aria-modal="true"
        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailUserModalLabel">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="formEditUser">
                        @csrf
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div>
                                    <label for="nama_detail" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_detail" name="nama_detail"
                                        placeholder="Masukkan nama_detail lengkap" required="required">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label for="nip_detail" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="nip_detail" name="nip_detail"
                                        placeholder="Masukkan NIP" required="required" maxlength="18"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                            </div>
                           <div class="col-lg-12">
                                <label for="jabatan_detail" class="form-label">Jabatan</label>
                                <select class="form-control" name="jabatan_detail" id="jabatan_detail" required="required">
                                    <option value="" selected disabled>Pilih Jabatan</option>
                                    <option value="DIREKTUR">DIREKTUR</option>
                                    <option value="FINANCE">FINANCE</option>
                                    <option value="STAFF">STAFF</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label for="password_detail" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password_detail" name="password_detail"
                                        autocomplete="new-password" required="required">
                                </div>
                            </div>
                            <input type="text" class="form-control" style="display: none" id="id_data" name="id_data" required="required">
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/libs/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        let user_datatable = $("#user-list").DataTable({
            processing: true,
            serverSide: true,
            ajax: `{{ route('list-data-user') }}`,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'nip',
                    name: 'nip'
                },
                {
                    data: 'nama',
                    name: 'nama',
                },
                {
                    data: 'jabatan',
                    name: 'jabatan'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                }
            ],
        });

        $("#formTambahUser").on('submit', function(e) {
            e.preventDefault();

            let form = this;

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let formData = new FormData(this);

            Swal.fire({
                html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/etwtznjn.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Form Anda sedang diproses!</h4><p class="text-muted mx-4 mb-0">Mohon tunggu...</p></div></div>',
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                type: 'POST',
                url: `{{ route('store-user') }}`,
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.close();

                    user_datatable.ajax.reload();

                    if (!res.error) {
                        form.reset();
                        $("#addUserModal").modal('hide');

                        Swal.fire({
                            html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Berhasil!</h4><p class="text-muted mx-4 mb-0">Selamat! Anda berhasil menambahkan user.</p></div></div>',
                            timer: 3000
                        })

                        user_datatable.ajax.reload();
                    } else {
                        Swal.fire({
                            html: `<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Oops... Ada Kesalahan!</h4><p class="text-muted mx-4 mb-0">${Object.values(res.message)[0]}</p></div></div>`,
                            showCancelButton: !1,
                            showConfirmButton: !1,
                            buttonsStyling: !1,
                            showCloseButton: !0
                        })
                    }
                }
            });
        })

        $("#formEditUser").on('submit', function(e) {
            e.preventDefault();

            let form = this;

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let formData = new FormData(this);

            Swal.fire({
                html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/etwtznjn.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Form Anda sedang diproses!</h4><p class="text-muted mx-4 mb-0">Mohon tunggu...</p></div></div>',
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                type: 'POST',
                url: `{{ route('edit-user') }}`,
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.close();

                    user_datatable.ajax.reload();

                    if (!res.error) {
                        form.reset();
                        $("#detailUserModal").modal('hide');

                        Swal.fire({
                            html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Berhasil!</h4><p class="text-muted mx-4 mb-0">Selamat! Anda berhasil menambahkan user.</p></div></div>',
                            timer: 3000
                        })

                        user_datatable.ajax.reload();
                    } else {
                        Swal.fire({
                            html: `<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Oops... Ada Kesalahan!</h4><p class="text-muted mx-4 mb-0">${Object.values(res.message)[0]}</p></div></div>`,
                            showCancelButton: !1,
                            showConfirmButton: !1,
                            buttonsStyling: !1,
                            showCloseButton: !0
                        })
                    }
                }
            });
        })

         $("#user-list").on('click', '#btn-detail-user', function() {
            $("#detailUserModal").modal('show');

            let id = $(this).data("id");

            $.ajax({
                url: "{{ route('find-data-user') }}",
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                method: "get",
                dataType: "json",
                success: function(data) {
                    $("#id_data").val(data[0]);
                    $("#nip_detail").val(data[1]);
                    $("#nama_detail").val(data[2]);
                    $("#jabatan_detail").val(data[3]);
                }
            });
         })

         $("#user-list").on('click', '#btn-delete-user', function() {
            let id = $(this).data("id")
            var url = "{{ route('delete-user', ':id') }}"
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Pastikan data yang anda hapus sudah benar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'delete',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Berhasil!</h4><p class="text-muted mx-4 mb-0">Selamat! Data berhasil dihapus.</p></div></div>',
                                    timer: 3000
                                }).then(() => {
                                    Swal.close();
                                    user_datatable.ajax.reload();
                                });
                            } else {
                                Swal.fire({
                                    html: `<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Oops... Ada Kesalahan!</h4><p class="text-muted mx-4 mb-0">${response.message}</p></div></div>`,
                                    showCancelButton: !1,
                                    showConfirmButton: !1,
                                    buttonsStyling: !1,
                                    showCloseButton: !0
                                }).then(() => {
                                    Swal.close();
                                });
                            }
                        },
                        error: function(xhr) {
                            var response = JSON.parse(xhr.responseText);
                            var errorMessage = '';
                            for (var key in response.errors) {
                                if (response.errors.hasOwnProperty(key)) {
                                    errorMessage += response.errors[key][0] +
                                        '<br>';
                                }
                            }
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                html: errorMessage,
                                showConfirmButton: true
                            });
                        }
                    })
                }
            })
        })
    </script>
@endsection
