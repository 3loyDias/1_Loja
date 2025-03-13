<?php
use core\classes\Store;
use core\models\Clientes;
use core\classes\Database;

// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = 'Acesso inválido ao recurso';
    Store::redirect('admin_clientes.php');
    exit;
}

// Verifica se o ID do cliente foi fornecido na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['erro'] = 'ID do cliente não fornecido';
    Store::redirect('admin_clientes.php');
    exit;
}

$id_cliente = $_GET['id'];
$nome_completo = trim($_POST['text_nome_completo'] ?? '');
$email = trim($_POST['text_email'] ?? '');
$morada = trim($_POST['text_morada'] ?? '');
$cidade = trim($_POST['text_cidade'] ?? '');
$telefone = trim($_POST['text_telefone'] ?? '');
$ativo = isset($_POST['check_ativo']) ? 1 : 0;

// Validação dos campos
if (empty($nome_completo) || empty($email) || empty($morada) || empty($cidade) || empty($telefone)) {
    $_SESSION['erro'] = 'Todos os campos são obrigatórios';
    Store::redirect('admin_clientes.php');
    exit;
}

// Validação do formato do email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['erro'] = 'O email fornecido é inválido';
    Store::redirect('admin_clientes.php');
    exit;
}

// Instanciar o modelo de clientes
$clientes = new Clientes();

// Verificar se o email já está em uso por outro cliente (exceto o atual)
if ($clientes->emailExiste($email, $id_cliente)) {
    $_SESSION['erro'] = 'O email fornecido já está em uso por outro cliente';
    Store::redirect('admin_clientes.php');
    exit;
}

try {
    // Atualizar os dados do cliente no banco de dados
    $bd = new Database();
    $parametros = [
        ':id_cliente'     => $id_cliente,
        ':nome_completo'  => $nome_completo,
        ':email'          => $email,
        ':morada'         => $morada,
        ':cidade'         => $cidade,
        ':telefone'       => $telefone,
        ':ativo'          => $ativo
    ];

    $sql = "UPDATE clientes 
            SET nome_completo = :nome_completo,
                email = :email,
                morada = :morada,
                cidade = :cidade,
                telefone = :telefone,
                ativo = :ativo,
                updated_at = NOW()
            WHERE id_cliente = :id_cliente";

    if ($bd->update($sql, $parametros)) {
        $_SESSION['sucesso'] = 'Cliente atualizado com sucesso!';
    } else {
        $_SESSION['erro'] = 'Não foi possível atualizar o cliente';
    }
} catch (Exception $e) {
    $_SESSION['erro'] = 'Erro ao atualizar o cliente: ' . $e->getMessage();
}

// Redireciona de volta para a página de clientes
Store::redirect('admin_clientes', true);
exit;
?>
