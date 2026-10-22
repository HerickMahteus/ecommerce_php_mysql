<?php


final class AuthController extends Controller
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function loginForm(): void
    {
        $this->view('auth/login', [
            'csrf' => $this->csrfToken()
        ]);
    }

    public function login(): void
    {
        $this->verifyCsrf();

        $email = filter_var(
            trim($_POST['email'] ?? ''),
            FILTER_VALIDATE_EMAIL
        );

        $senha = $_POST['password'] ?? '';

        $stmt = $this->db->prepare(
            'SELECT id, name, email, password_hash
             FROM users WHERE email = ? LIMIT 1'
        );

        $stmt->execute([$email ?: '']);
        $user = $stmt->fetch();

        if (
            !$user ||
            !password_verify($senha, $user['password_hash'])
        ) {
            $_SESSION['flash'] = 'E-mail ou senha inválidos.';
            $this->redirect('?r=login');
        }

        session_regenerate_id(true);

        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        $_SESSION['flash'] = 'Login realizado com sucesso.';

        $this->redirect('?r=products');
    }

    public function logout(): void
    {
        $this->verifyCsrf();

        $_SESSION = [];
        session_destroy();

        header('Location: ?r=login');
        exit;
    }
}
