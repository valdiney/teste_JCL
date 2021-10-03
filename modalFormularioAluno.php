<!-- Modal -->
<div class="modal fade" id="modalFormularioAluno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Salvar Aluno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row campos">
            <div class="col-md-6 form-group">
                <label for="nome">Nome *</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite o Nome"
                onkeypress="return apenasLetras(event);"/>
            </div>

            <div class="col-md-6 form-group">
                <label for="email">E-mail *</label>
                <input type="text" class="form-control" id="email" placeholder="Digite o E-mail">
            </div>  

            <div class="col-md-12 form-group">
                <label for="id_curso">Cursos *</label>
                <select class="form-control" id="id_curso">
                    <option value="selecione">Selecione</option>
                    <?php foreach (cursos($pdo) as $curso):?>
                        <option value="<?php echo $curso->id;?>"><?php echo $curso->nome;?></option>
                    <?php endforeach;?>
                </select>
            </div> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" onclick="salvar()"><i class="fas fa-save"></i> Salvar</button>
      </div>
    </div>
  </div>
</div>