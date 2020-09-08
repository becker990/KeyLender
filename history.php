<?php require_once("header.php"); ?>
<!-- History -->

<div class="container-fluid">

		<div class="row">
			<div class="col">
			
				<form>
				  <div class="form-group form-row align-items-end">
					<div class="col">
						<label for="formGroupExampleInput"><strong>Pesquisar por Cartão:</strong></label>					
						<input type="number" autocomplete=off class="form-control" id="formGroupExampleInput">
					</div>
					<div class="col">
						<button type="submit" class="btn btn-primary">Cartão</button>					
					</div>
				  </div>
				</form>
		
			</div>
			<div class="col">
				
				<form>
				  <div class="form-group form-row align-items-end">
					<div class="col">
						<label for="formGroupExampleInput"><strong>Pesquisar por Chave:</strong></label>					
						<input type="number" autocomplete=off class="form-control" id="formGroupExampleInput">
					</div>
					<div class="col">
						<button type="submit" class="btn btn-primary">Chave</button>					
					</div>
				  </div>
				</form>
			
			</div>
			<div class="col">
				
				<form>
				  <div class="form-group form-row align-items-end">
					<div class="col">
						<label for="datepicker"><strong>Pesquisar por Data:</strong></label>					
						<input type="number" autocomplete=off class="form-control" id="datepicker">
					</div>
					<div class="col">
						<button type="submit" class="btn btn-primary">Data</button>					
					</div>
				  </div>
				</form>
				
			</div>			
		</div>	
		
		<div class="row">
			<div class="col">
			
				<table class="table table-sm table-bordered table-dark table-striped table-hover">
				  <thead>
					<tr>
					  <th scope="col">ID Transação</th>
					  <th scope="col">Chave Num</th>
					  <th scope="col">Operação</th>
					  <th scope="col">Cartão</th>				  
					  <th scope="col">Data e Hora</th>
					</tr>
				  </thead>
				  <tbody id="historico_tabela">
					
					
					
				  </tbody>
				</table>
		
			</div>
		</div>		
</div>

<!-- END history -->  
<?php require_once("footer.php"); ?>