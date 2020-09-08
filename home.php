<?php require_once("header.php"); ?>
<!-- HOME -->
	<script>
		
		$(function() {

			fill_home();

		});
	
	</script>
	<div class="container-fluid">
		
		<div class="row">	
				
			<div class="col-sm-6">
				<form class="">					
						<div class="form-row align-items-end">
						
							<div class="form-group col-5">
								<label for="codbarra"><strong>Código da Chave:</strong></label>
								<input type="number"  autocomplete=off class="form-control" id="codbarra" >						
							</div>	
						
							<div class="form-group col-2">								
								<button type="submit" class="btn btn-primary" id="btn-devolver">Devolver</button>											
							</div>				
					  	</div>				
						
				</form>
				
			</div>
	
			<div class="col-sm-6">
				<form class="">					
						<div class="form-row align-items-end">
						
							<div class="form-group col-4">
								<label for="exampleInputEmail1"><strong>Cartão UFRGS:</strong></label>
								<input type="number"  autocomplete=off class="form-control" id="cartao" required>						
							</div>
							
						
							<div class="form-group col-4">
								<label for="exampleInputPassword1"><strong>Senha Biblioteca:</strong></label>
								<input type="password" autocomplete=off class="form-control" id="senha" required>
							</div>			  
							
							<div class="form-group col-3">								
								<button type="submit" class="btn btn-primary btn-block" id="btn-login">Retirar</button>											
							</div>				
					  	</div>				
						
				</form>
			
			</div>
		</div>
			
		<div class="row" id="mycont">
			
		</div>
	</div>
	
  
<!-- END HOME -->  
<?php require_once("footer.php"); ?>

