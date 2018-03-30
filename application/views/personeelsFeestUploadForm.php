<script>
   $(document).ready(function() {
	$('#uploadFile').submit(function(e) {
            console.log('submit');
            var data = new FormData(this)
		e.preventDefault();
		$.ajax({
			url:site_url + '/organisator/ajaxUploadFile', 
			method:"POST",  
                        data: data, 
                        contentType: false,  
                        cache: false,  
                        processData:false, 
			success : function(result){
                            $('#uploadMessage').html(result);
                        },
		});
		return false;
	});
}); 
</script>


<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
            <p>Hier kan je een personeelslijst uit Excel importeren</p>

            <?php
             $attributenFormulier = array('id' => 'uploadFile',
                                           'role' => 'form');
            echo form_open('', $attributenFormulier);
            echo form_labelpro('Upload excel (.xls):', 'excel');
            echo form_input(array('name' => 'excel',
                                    'id' => 'excel',
                                    'type' => 'file',
                                    'required' => 'required'));
             ?>
            </div>
            <div class="col-md-12">
            <?php
            echo form_submit('knop', 'Upload', "class='btn btn-primary'");
            echo form_close();
            ?>
            </div>
        </div>
        
    </div>
    <div class="col-md-6">
        <p>Zorg ervoor dat uw excel deze 3 kolommen heeft: Voornaam, Naam, Email</p>
        <p>Download hier een voorbeeld excel: </p> <?php echo anchor('assets/files/VoorbeeldExcel.xls', 'Download',"class='btn btn-primary'") ?>
        <p id="uploadMessage"></p>
    </div>
</div>