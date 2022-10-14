
<table id="table" class="table table-striped table-responsive">
    <thead>
        <tr>
            <th>No</th>
            <th>Contoh Uji</th>
            <th>Bentuk</th>
            <th>Media</th>
            <th></th>
            <th>Status</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
    $no = 1;
    if(isset($detail_permohonan)) {
        foreach ($detail_permohonan as $row) {
                ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><b><?= $row['isi_permohonan'] ?></b><br><?= $row['isi_permohonan'] ?></td>
                    
                    <!-- <input type="hidden" name="row<?=$row['id']?>" id="row<?=$row['id']?>" value="<?=$row['id']?>"> -->
                </tr>
               <?
        }
    }
    ?>
    </tbody>
</table>
<!-- <input type="hidden" id="sts_sampel" value="<?=$sts['status_sampel']?>"> -->
<!-- <div class="ln_solid"></div>
<div class="item form-group">
    <label class="control-label col-md-3 col-sm-6 col-xs-12">Tanggal Contoh Uji Diproses</label>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <input type="text" class="form-control tanggal" id="tgl_sampel_diterima" name="tgl_sampel_diterima"
            value="<?=$tgl_sampel_diterima?>" disabled autocomplete="off" required>
    </div>
    
</div> -->
