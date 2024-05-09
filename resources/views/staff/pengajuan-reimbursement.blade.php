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
                                    data-bs-target="#addUserReimbursement"><i class="ri-add-line"></i>Ajukan Reimbursement</button>
                                <h5 class="card-title mt-2">List User Reimbursement Apps</h5>
                            </div>
                            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                                <h4 class="card-title mg-b-10">Halaman Manajemen Reimbursement</h4>
                                <div class="d-flex justify-content-between">
                                     <div class="card-body table-responsive">
                                        <table id="reimbursements-list" class="table table-bordered dt-responsive table-striped align-middle"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>NIP</th>
                                                    <th>Nama</th>
                                                    <th>Nominal</th>
                                                    <th>Tanggal</th>
                                                    <th>Status</th>
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

    <div class="modal fade" id="addUserReimbursement" tabindex="-1" aria-labelledby="addUserReimbursementLabel" aria-modal="true"
        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserReimbursementLabel">Form Pengajuan Reimbursement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="formTambahReimbursement">
                        @csrf
                        <div class="row g-3">
                            <div class="col-lg-12">
                               <div>
                                    <label for="nominal" class="form-label">Nominal</label>
                                    <input type="text" class="form-control" id="nominal" name="nominal"
                                        placeholder="Masukkan Nominal" required="required"
                                        onkeyup="formatRupiah(this)">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required="required">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan Deskripsi"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="files" class="form-label">Upload File Pendukung (bisa lebih dari 1 file)</label>
                                    <input type="file" class="form-control" id="files" name="files[]" multiple>
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

    <div class="modal fade" id="detailUserReimbursement" tabindex="-1" aria-labelledby="detailUserReimbursementLabel" aria-modal="true"
        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailUserReimbursementLabel">Form Pengajuan Reimbursement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="formDetailReimbursement">
                        @csrf
                        <div class="row g-3">
                            <div class="col-lg-12">
                               <div>
                                    <label for="nip_detail" class="form-label">NIP</label>
                                    <input type="text" readonly class="form-control" id="nip_detail" name="nip_detail" >
                                </div>
                            </div>
                            <div class="col-lg-12">
                               <div>
                                    <label for="nama_detail" class="form-label">Nama</label>
                                    <input type="text" readonly class="form-control" id="nama_detail" name="nama_detail" >
                                </div>
                            </div>
                            <div class="col-lg-12">
                               <div>
                                    <label for="nominal-detail" class="form-label">Nominal</label>
                                    <input type="text" readonly class="form-control" id="nominal_detail" name="nominal_detail" >
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label for="tanggal_detail" class="form-label">Tanggal</label>
                                    <input type="date" readonly class="form-control" id="tanggal_detail" name="tanggal_detail">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="deskripsi_detail" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" readonly id="deskripsi_detail" name="deskripsi_detail" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="files_detail" class="form-label">File</label>
                                    <ul id="files_detail"></ul>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
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

        function formatRupiah(input) {
            var number = input.value.replace(/[^0-9]/g, "");
            var separator = ".";
            var decimal = ",";
            var parts = number.split(".");
            var part1 = parts[0].length > 3 ? parts[0].substring(0, parts[0].length - 3) + separator + parts[0].substring(parts[0].length - 3) : parts[0];
            var part2 = parts[1] ? (parts[1].length > 2 ? decimal + parts[1].substring(0, 2) : (parts[1].length > 1 ? decimal + parts[1].substring(0, 1) : "")) : "";
            input.value = "Rp " + part1 + part2;
        }

        let reimbursement_datatable = $("#reimbursements-list").DataTable({
            processing: true,
            serverSide: true,
            ajax: `{{ route('list-data-reimbursement') }}`,
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
                    name: 'nama'
                },
                {
                    data: 'nominal',
                    name: 'nominal'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        if (row.status === "MENGAJUKAN") {
                            return '<button class="btn btn-warning">Mengajukan</button>';
                        } else if (row.status === "TOLAK-DIREKTUR") {
                            return '<button class="btn btn-danger">Tolak (Direktur)</button>';
                        } else if (row.status === "VERIFIKASI-DIREKTUR") {
                            return '<button class="btn btn-success">Verifikasi (Direktur)</button>';
                        } else if (row.status === "TOLAK-FINANCE") {
                            return '<button class="btn btn-danger">Tolak (Finance)</button>';
                        } else if (row.status === "APPROVE") {
                            return '<button class="btn btn-success">Approve</button>';
                        }
                    },
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var date = new Date(data);
                            var formattedDate = date.toLocaleDateString('en-US', {
                                year: '2-digit',
                                month: '2-digit',
                                day: '2-digit'
                            });
                            return formattedDate;
                        }
                        return data;
                    }
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                }
            ],
        });

        $("#formTambahReimbursement").on('submit', function(e) {
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
                url: `{{ route('store-reimbursement') }}`,
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.close();

                    reimbursement_datatable.ajax.reload();

                    if (!res.error) {
                        form.reset();
                        $("#addUserReimbursement").modal('hide');

                        Swal.fire({
                            html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Berhasil!</h4><p class="text-muted mx-4 mb-0">Selamat! Anda berhasil menambahkan user.</p></div></div>',
                            timer: 3000
                        })

                        reimbursement_datatable.ajax.reload();
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


        $("#reimbursements-list").on('click', '#btn-detail-reimbursement', function() {
             $("#detailUserReimbursement").modal('show');

             let id = $(this).data("id");

             $.ajax({
                url: "{{ route('find-data-reimbursement') }}",
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                method: "get",
                dataType: "json",
                success: function(data) {
                    $("#nama_detail").val(data[1]);
                    $("#nip_detail").val(data[2]);
                    $("#nominal_detail").val(data[3]);
                    $("#tanggal_detail").val(data[5]);
                    $("#deskripsi_detail").val(data[4]);

                    let filesList = $("#files_detail");
                    filesList.empty();
                    data[6].forEach(function(file) {
                        let li = $("<li>");
                        let downloadLink = $("<a>")
                            .attr("href", "{{ url('reimbursement_files') }}/" + file)
                            .attr("target", "_blank")
                            .text(file);
                        li.append(downloadLink);
                        filesList.append(li);
                    });
                }
            });
        })

         $("#reimbursements-list").on('click', '#btn-delete-reimbursement', function() {
            let id = $(this).data("id")
            var url = "{{ route('delete-reimbursement', ':id') }}"
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
                                    reimbursement_datatable.ajax.reload();
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
