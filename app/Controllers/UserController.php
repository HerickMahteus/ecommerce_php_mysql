<?php
declare(strict_types=1);
final class UserController extends Controller
{
    private User $users;
    public function __construct() { $this->users=new User(Database::connection()); }
    public function index(): void { $this->view('users/index',['users'=>$this->users->all(),'csrf'=>$this->csrfToken()]); }
    public function create(): void { $this->view('users/form',['user'=>null,'csrf'=>$this->csrfToken()]); }
    public function store(): void {
        $this->verifyCsrf(); $name=trim($_POST['name']??''); $email=filter_var($_POST['email']??'',FILTER_VALIDATE_EMAIL); $pass=$_POST['password']??'';
        if($name==='' || !$email || strlen($pass)<8){http_response_code(422);exit('Informe nome, e-mail válido e senha com pelo menos 8 caracteres.');}
        $this->users->create($name,$email,$pass); $this->redirect('?r=users');
    }
    public function edit(): void {
        $u=$this->users->find((int)($_GET['id']??0)); if(!$u){http_response_code(404);exit('Usuário não encontrado.');}
        $this->view('users/form',['user'=>$u,'csrf'=>$this->csrfToken()]);
    }
    public function update(): void {
        $this->verifyCsrf(); $id=(int)($_POST['id']??0); $name=trim($_POST['name']??''); $email=filter_var($_POST['email']??'',FILTER_VALIDATE_EMAIL);
        $pass=$_POST['password']??null; if($id<1 || $name==='' || !$email || ($pass!==null && $pass!=='' && strlen($pass)<8)){http_response_code(422);exit('Dados inválidos.');}
        $this->users->update($id,$name,$email,$pass); $this->redirect('?r=users');
    }
    public function delete(): void { $this->verifyCsrf(); $this->users->delete((int)($_POST['id']??0)); $this->redirect('?r=users'); }
}
