<?php
declare(strict_types=1);
final class OrderController extends Controller
{
    private Order $orders;
    public function __construct() { $this->orders=new Order(Database::connection()); }
    public function index(): void { $this->view('orders/index',['orders'=>$this->orders->all(),'csrf'=>$this->csrfToken()]); }
    public function checkout(): void {
        $userId=(int)($_SESSION['user_id']??0);
        if($userId<1){http_response_code(401);exit('Para finalizar, configure a autenticação e entre com um usuário.');}
        try { $id=$this->orders->create($userId,$_SESSION['cart']??[]); $_SESSION['cart']=[]; $_SESSION['flash']='Pedido #'.$id.' realizado com sucesso.'; }
        catch(Throwable $e){$_SESSION['flash']=$e->getMessage();}
        $this->redirect('?r=orders');
    }
    public function delete(): void { $this->verifyCsrf(); $this->orders->delete((int)($_POST['id']??0)); $this->redirect('?r=orders'); }
}
