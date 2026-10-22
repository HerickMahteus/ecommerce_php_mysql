<?php
declare(strict_types=1);

abstract class Controller
{
    protected function view(string $name, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/' . $name . '.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    protected function redirect(string $url): never
    {
        header('Location: ' . $url);
        exit;
    }

    protected function csrfToken(): string
    {
        if (empty($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        return $_SESSION['_csrf'];
    }

    protected function verifyCsrf(): void
    {
        $sent = $_POST['_csrf'] ?? '';
        if (!is_string($sent) || !hash_equals($_SESSION['_csrf'] ?? '', $sent)) {
            http_response_code(403);
            exit('Token CSRF inválido. Volte e tente novamente.');
        }
    }
}
