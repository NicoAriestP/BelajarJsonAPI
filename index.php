<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tes-Venturo-Intermediate</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<style>
		th{
			vertical-align: middle;
		}
	</style>
</head>
<body>
<div class="container-fluid p-2">
	<div class="card mt-3">
	<div class="card-header">
		<h5>Venturo-Laporan penjualan tahunan per menu</h5>
	</div>
	<div class="card-body">
	<div class="row">
		<div class="col-3">
			<select class="form-select" id="tahun" aria-label="Default select example">
			  <option >Pilih Tahun</option>
			  <option value="2021">2021</option>
			  <option value="2022">2022</option>
			</select>	

		</div>
		<div class="col-9">
			<button class="btn btn-primary" onclick="viewresult()">Tampilan</button>
			
			<a href="tes_venturo.json" class="btn btn-secondary">Json</a>
		</div>

		<hr class="mt-4">
		<!-- tabel -->
		


</div>
<div id="viewdata">
	
</div>
</div>
</div>
</div>
<script>
		function viewresult(){
		var tahun = $('#tahun').val();
		if (tahun == "Pilih Tahun") {
			alert("Pilih tahun laporan")
		}else{
    	$.ajax({
        type: "GET",
        url: "proses.php",
        dataType: "html",
        data:{
        	tahun:tahun,
        },
        success: function(data){
        	
            $('#viewdata').html(data);
            swal("Sukses!", "Data Ditampilkan!", "success");
            // $('select').imagepicker(); // to reinitialize the plugin.
        },
        error: function(data){
            // error handling
        }
})
};
}
</script>
</body>
</html>