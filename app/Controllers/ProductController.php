<?php
declare(strict_types=1);
final class ProductController extends Controller
{
    private Product $products;
    public function __construct() { $this->products=new Product(Database::connection()); }
    public function index(): void { $this->view('products/index',['products'=>$this->products->all()]); }
    public function create(): void { $this->view('products/form',['product'=>null,'csrf'=>$this->csrfToken()]); }
    public function store(): void {
        $this->verifyCsrf();
        $name=trim($_POST['name']??''); $description=trim($_POST['description']??'');
        $price=filter_var($_POST['price']??null,FILTER_VALIDATE_FLOAT); $stock=filter_var($_POST['stock']??null,FILTER_VALIDATE_INT);
        if($name==='' || $price===false || $price<0 || $stock===false || $stock<0) { http_response_code(422); exit('Dados inválidos.'); }
        $this->products->create($name,$description,(float)$price,(int)$stock); $this->redirect('?r=products');
    }
    public function edit(): void {
        $p=$this->products->find((int)($_GET['id']??0)); if(!$p){http_response_code(404);exit('Produto não encontrado.');}
        $this->view('products/form',['product'=>$p,'csrf'=>$this->csrfToken()]);
    }
    public function update(): void {
        $this->verifyCsrf(); $id=(int)($_POST['id']??0); $name=trim($_POST['name']??'');
        $price=filter_var($_POST['price']??null,FILTER_VALIDATE_FLOAT); $stock=filter_var($_POST['stock']??null,FILTER_VALIDATE_INT);
        if($id<1 || $name==='' || $price===false || $price<0 || $stock===false || $stock<0) { http_response_code(422);exit('Dados inválidos.');}
        $this->products->update($id,$name,trim($_POST['description']??''),(float)$price,(int)$stock); $this->redirect('?r=products');
    }
    public function delete(): void { $this->verifyCsrf(); $this->products->delete((int)($_POST['id']??0)); $this->redirect('?r=products'); }
}
