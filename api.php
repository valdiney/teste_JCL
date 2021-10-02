<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once("database/Database.php");

if (isset($_POST['action']) && $_POST['action'] == 'cadastrarAluno') {
    try {
        $query = $pdo->prepare("INSERT INTO alunos(nome, email, id_curso) VALUES(?,?,?)");
        $resultado = $query->execute([
            $_POST['nome'],
            $_POST['email'],
            $_POST['id_curso']
        ]);

        echo json_encode(['status' => $resultado]);

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'errorMessage' => $e->getMessage()]);
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'editarAluno') {
    try {
        $query = $pdo->prepare("UPDATE alunos SET nome = ?, email = ?, id_curso = ? WHERE id = ?");
        $resultado = $query->execute([
            $_POST['nome'],
            $_POST['email'],
            $_POST['id_curso'],
            $_POST['idAluno']
        ]);

        echo json_encode(['status' => $resultado]);

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'errorMessage' => $e->getMessage()]);
    }
}

if (isset($_GET['deletarAluno']) && isset($_GET['idAluno'])) {
    try {
        $query = $pdo->prepare("DELETE FROM alunos WHERE id = ?");
        $resultado = $query->execute([$_GET['idAluno']]);

        echo json_encode(['status' => $resultado]);

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'errorMessage' => $e->getMessage()]);
    }
}

if (isset($_GET['emailJaExiste'])) {

    try {
        $query = $pdo->prepare("SELECT COUNT(*) AS quantidade FROM alunos WHERE email = ?");
        $query->execute([$_GET['email']]);
        $resultado = $query->fetch(PDO::FETCH_OBJ);
        
        /*
        Se for uma edição, verifica se o email pertence ao usuario que está sendo editado
        Caso seja, edita passa normalmente
        */
        if (isset($_GET['idAluno'])) {
            $_query = $pdo->prepare("SELECT id, email FROM alunos WHERE email = ?");
            $_query->execute([$_GET['email']]);
            $_resultado = $_query->fetch(PDO::FETCH_OBJ);
            
            if ($_resultado->id == $_GET['idAluno']) {
                echo json_encode(['status' => false]);
            } else {
                echo json_encode([
                    'status' => true, 
                    'mensagemValidacao' => 'Já existe um Aluno com este E-mail!'
                ]);
            }
        } else {
            if ($resultado->quantidade > 0) {
                echo json_encode([
                    'status' => true,
                    'mensagemValidacao' => 'Este E-mail já está cadastrado no Sistema!'
                ]);
            } else {
                echo json_encode(['status' => false]);
            }
        }
        
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'errorMessage' => $e->getMessage()]);
    }
}

if (isset($_GET['selecionarAluno'])) {
    try {
        $query = $pdo->prepare("SELECT * FROM alunos WHERE id = ?");
        $query->execute([(int) $_GET['idAluno']]);
        echo json_encode(['aluno' => $query->fetch(PDO::FETCH_OBJ)]);

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'errorMessage' => $e->getMessage()]);
    }
}
?>