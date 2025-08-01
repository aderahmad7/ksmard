<?= $this->extend('template/body.php') ?>

<?= $this->section('content') ?>

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="card">
            <div class="row">
                <div class="card-body">
                    <div class="col-xl-12">
                        <div class="pt-3">
                            <div class="settings-form">
                                <form action="<?= current_url(); ?>" method="post" id="form-simpan" class="form-horizontal col-lg-12 col-md-12 col-xs-12">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                <input type="text" name="role" id="role" class="form-control" value="<?= $account['roleRole']; ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Username</label>
                                                <input type="text" name="accUsername" id="username" class="form-control" value="<?= $account['roleAccUsername']; ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="accNama" id="nama" class="form-control" value="<?= $account['accNama']; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="accEmail" id="email" class="form-control" value="<?= $account['accEmail'] ?? ''; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nomor Whatsapp</label>
                                                <input type="text" name="accNoWhatsapp" id="noWhatsapp" class="form-control" value="<?= $account['accNoWhatsapp'] ?? ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary simpan" type="submit">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).delegate('.simpan', 'click', function(e) {
        e.preventDefault();
        var data = $("#form-simpan").serializeArray();
        $(".form-control").removeClass("invalid")
        $.ajax({
            url: "<?php echo site_url("profile/simpan"); ?>",
            data: data,
            type: "POST",
            dataType: "JSON",
            beforeSend: function() {
                $(".fa-spinner").show();
                $(".error").remove();
                $("#btn-simpan").attr("disabled", true);
                $("#btn-batal").attr("disabled", true);
            },
            success: function(data) {
                console.log(data)
                $(".fa-spinner").hide();
                $("#btn-simpan").removeAttr("disabled");
                $("#btn-batal").removeAttr("disabled");

                if (data.simpan) {
                    $("#modal-form").modal("hide");
                    msg("success", data.pesan);
                } else {
                    if (!data.validasi) {
                        console.log('masuk validasi')
                        $("#pesan-error").show();
                        $.each(data.pesan, function(index, value) {
                            $('#' + index).after('<div class="error" style="color:red">' + value + '</div>');
                            $('#' + index).addClass('invalid');
                            console.log('My array has at position ' + index + ', this value: ' + value);
                        });
                    } else {
                        $("#modal-form").modal("hide");
                        msg("error", data.pesan);
                    }
                }
            },
        });
    });
</script>
<?= $this->endSection() ?>