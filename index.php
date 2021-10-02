<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once("database/Database.php");
require_once("layout/header.php");

function alunos($pdo) {
    $query = $pdo->prepare(
        "SELECT 
        alunos.nome, 
        alunos.email,
        alunos.id,
        cursos.nome AS curso 
        FROM alunos INNER JOIN cursos ON alunos.id_curso = cursos.id"
    );

    $query->execute();
    return $query->fetchAll(PDO::FETCH_OBJ);
}

function cursos($pdo) {     
    $query = $pdo->prepare("SELECT * FROM cursos");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_OBJ);
}

function aluno($pdo) {

}
?>
<div class="container">
    <br>
    <br>
   <div class="card my-card">
    <h3>Alunos Cadastrados</h3>

    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Nome</th>
            <th scope="col">Email</th>
            <th scope="col">Curso</th>
            <th scope="col">
                <button class="btn btn-sm btn-primary" onclick="modalNovoAluno()">
                    <i class="fas fa-save"></i> Novo Aluno
                </button>
            </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (alunos($pdo) as $aluno):?>
                <tr>
                    <td><?php echo $aluno->nome;?></td>
                    <td><?php echo $aluno->email;?></td>
                    <td><?php echo $aluno->curso;?></td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="selecionarAluno('<?php echo $aluno->id;?>')"><i class="fas fa-edit"></i> Alterar</button>
                        <button class="btn btn-sm btn-danger" onclick="deletar('<?php echo $aluno->id?>', $(this))"><i class="fas fa-minus-circle"></i> Deletar</button>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
   </div>
</div>

<?php 
require_once("layout/footer.php");
?>

<script>
    function salvar() {
        if ($("#nome").val() == '') {
            $.alert({
                title: 'Validação',
                content: 'Preencha o campo Nome',
            });
            
            return false;

        } else if ($("#email").val() == '') {
            $.alert({
                title: 'Validação',
                content: 'Preencha o campo E-mail',
            });

            return false;

        } else if ($("#id_curso").val() == 'selecione') {
            $.alert({
                title: 'Validação',
                content: 'Preencha o campo Curso',
            });

            return false;

        } else if ( ! isEmail($("#email").val())) {
            $.alert({
                title: 'Validação',
                content: 'Digite um E-mail valido!',
            });

            return false;

        } else {
            if ($("#idAluno").length) {
                var rota = "http://localhost:8000/api.php?emailJaExiste&email="+$("#email").val()+"&idAluno="+$("#idAluno").val();
            } else {
                var rota = "http://localhost:8000/api.php?emailJaExiste&email="+$("#email").val();
            }
            
            $.get(rota, function(data, status) {
                var obj = JSON.parse(data);
                if (obj.status === true) {
                    $.alert({
                        title: 'Validação',
                        content: obj.mensagemValidacao,
                    });
                    return false;
                } else {
                    if ($("#idAluno").length) {
                        editarAluno();
                    } else {
                        cadastrarAluno();
                    }
                }
            })
      
        }
    }
</script>
<?php require_once("modalFormularioAluno.php");?>
<br>
<br>