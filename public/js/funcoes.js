// Realiza o cadastro dos Alunos
function cadastrarAluno() {
    var rota = "http://localhost:8000/api.php";
    $.post(rota, 
    {
        'action': 'cadastrarAluno',
        'nome': $('#nome').val(),
        'email': $('#email').val(),
        'id_curso': $('#id_curso').val()

    }, function(data, status) {
        var retorno = JSON.parse(data);
        if (retorno.status == true) {
            $.confirm({
                title: 'Confirmação!',
                content: 'Aluno Salvo com Sucesso!',
                buttons: {
                    ok: function(){
                        location.reload();
                    }
                }
            });
        }
    });
}

// Realiza a edição dos Alunos
function editarAluno() {
    var rota = "http://localhost:8000/api.php";
    $.post(rota, 
    {
        'action': 'editarAluno',
        'idAluno': $("#idAluno").val(),
        'nome': $('#nome').val(),
        'email': $('#email').val(),
        'id_curso': $('#id_curso').val()

    }, function(data, status) {
        var retorno = JSON.parse(data);
        if (retorno.status == true) {
            $.confirm({
                title: 'Confirmação!',
                content: 'Aluno Salvo com Sucesso!',
                buttons: {
                    ok: function(){
                        location.reload();
                    }
                }
            });
        }
    });
}

// Deleta um Aluno
function deletar(idAluno, elemento) {
    var rota = "http://localhost:8000/api.php?deletarAluno=yes&idAluno="+idAluno;
    $.confirm({
        title: 'Confirmação!',
        content: 'Deseja Deletar Esse Aluno?',
        buttons: {
            confirmar: function() {
                elemento.parent().parent().fadeIn().delay(100).fadeOut(function () {
                    $.get(rota, function(data, status) {
                        var obj = JSON.parse(data);
                        if (obj.status == true) {
                            elemento.remove();
                        }
                    })
                })
            }, cancelar: function() {}
        }
    });
}

// Seleciona Aluno para edição
function selecionarAluno(idAluno) {
    $("#modalFormularioAluno").modal().show();
    var rota = "http://localhost:8000/api.php?selecionarAluno&idAluno="+idAluno;
    $.get(rota, function(data, status) {
        var aluno = JSON.parse(data);
        $("#nome").val(aluno.aluno.nome);
        $("#email").val(aluno.aluno.email);
        
        if ($("#idAluno").length) {
            $("#idAluno").remove();
        }

        var criaCampoIdAluno = `<input type="hidden" id="idAluno" value="${aluno.aluno.id}"></input>`;
        $("#modalFormularioAluno .campos").append(criaCampoIdAluno);

        $('#id_curso option').each(function() {
            if ($(this).val() == aluno.aluno.id_curso) {
                $(this).prop("selected", true);
            }
        });
    })
}

function modalNovoAluno() {
    $("#modalFormularioAluno").modal().show();
    $("#idAluno").remove();
}