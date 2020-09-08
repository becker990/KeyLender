<?php require_once("header.php"); ?>
<!-- HOME -->
	<div class="container-fluid">
		
		<div class="row">
			<div class="col">
				<h2>Configuraçãoes:</h3>
				<hr>
			</div>
		</div>
	
		<div class="row">
			<div class="col-md-6">

				<form>
				  <div class="form-group">
					<label for="senhasys">Senha do sistema:</label>
					<input type="text" class="form-control" id="senhasys" placeholder="">
				  </div>			 
				  
				  <div class="form-group">
					<label for="txt-prioridade">Ordem de prioridade dos armarios:</label>
					<textarea class="form-control" id="txt-prioridade" rows="3"></textarea>
				  </div>
				  
				  <button type="submit" class="btn btn-primary" id="btn-configs-salvar">Salvar</button>
				</form>
		
			</div>
			<div class="col-md-6">				
					
			</div>
		</div>
	</div>
  
<!-- END HOME -->  
<?php require_once("footer.php"); ?>