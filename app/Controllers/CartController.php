<?php
declare(strict_types=1);
final class CartController extends Controller
{
    private Product $products;
    public function __construct() { $this->products=new Product(Database::connection()); }
    public function index(): void {
        $cart=$_SESSION['cart']??[]; $items=[]; $total=0.0;
        foreach($cart as $id=>$qty) { $p=$this->products->find((int)$id); if($p){$p['quantity']=(int)$qty;$p['subtotal']=(float)$p['price']*(int)$qty;$total+=$p['subtotal'];$items[]=$p;} }
        $this->view('cart/index',['items'=>$items,'total'=>$total,'csrf'=>$this->csrfToken()]);
    }
    public function add(): void {
        $this->verifyCsrf(); $id=(int)($_POST['product_id']??0); $qty=max(1,(int)($_POST['quantity']??1));
        $p=$this->products->find($id); if(!$p) {http_response_code(404);exit('Produto não encontrado.');}
        $new=(int)(($_SESSION['cart'][$id]??0)+$qty); if($new>(int)$p['stock']) {http_response_code(422);exit('Quantidade maior que o estoque disponível.');}
        $_SESSION['cart'][$id]=$new; $this->redirect('?r=cart');
    }
    public function update(): void {
        $this->verifyCsrf(); $id=(int)($_POST['product_id']??0); $qty=(int)($_POST['quantity']??0); $p=$this->products->find($id);
        if(!$p || $qty<1 || $qty>(int)$p['stock']) {http_response_code(422);exit('Quantidade inválida.');}
        $_SESSION['cart'][$id]=$qty; $this->redirect('?r=cart');
    }
    public function remove(): void { $this->verifyCsrf(); unset($_SESSION['cart'][(int)($_POST['product_id']??0)]); $this->redirect('?r=cart'); }
    public function clear(): void { $this->verifyCsrf(); $_SESSION['cart']=[]; $this->redirect('?r=cart'); }
}
