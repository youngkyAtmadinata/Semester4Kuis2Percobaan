<?php $this->load->view('layouts/base_start') ?>

<div class="container">
  <legend>Daftar Mahasiswa</legend>
  <div class="col-xs-12 col-sm-12 col-md-12">
    <table class="table table-striped">
      <thead>
        <th>No</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th width="200">Foto</th>
        <th>
          <a class="btn btn-primary" href="<?php echo site_url('pegawai/create/') ?>">
            Tambah
          </a>
        </th>
      </thead>
       
       <tbody>
        <input type="text" class="form-control" placeholder="Pencarian..." ng-model="filter_data">

    <?php 
		$no = $this->uri->segment('3') + 1;
		foreach($user as $u){ 
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td>
        <a href="<?php echo site_url('pegawai/show/'.$u->id) ?>">
          <?php echo $u->nama ?>
        </a>
      </td>
			<td><?php echo $u->alamat ?></td>
      <td>
          <img src="<?php echo base_url('assets/uploads/').$u->foto; ?>" style="display:block; width:100%; height:100%;">
      </td>

          <td>
            <?php echo form_open('pegawai/destroy/'.$u->id); ?>
            <a class="btn btn-info" href="<?php echo site_url('pegawai/edit/'.$u->id) ?>">
              Ubah
            </a>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
            <?php echo form_close() ?>
          </td>
          </tr>

    <?php } ?>
    </tbody>
	</table>
  
  
	<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="http://localhost:8080/Semester4Kuis2Percobaan/index.php/pegawai/index/0" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" href="http://localhost:8080/Semester4Kuis2Percobaan/index.php/pegawai/index/0">1</a></li>
    <li class="page-item"><a class="page-link" href="http://localhost:8080/Semester4Kuis2Percobaan/index.php/pegawai/index/5">2</a></li>
    <li class="page-item"><a class="page-link" href="http://localhost:8080/Semester4Kuis2Percobaan/index.php/pegawai/index/10">3</a></li>
    <li class="page-item">
      <a class="page-link" href="http://localhost:8080/Semester4Kuis2Percobaan/index.php/pegawai/index/10" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>
  
  
 </div>
</div>

<?php $this->load->view('layouts/base_end') ?>