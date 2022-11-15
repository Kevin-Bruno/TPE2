<?php

require_once "./app/Model/productsModel.php";
require_once "./app/Views/APIView.php";
    class ProductsApiController{
        private $model;
        private $view;

        public function __construct(){
            $this->model = new ProductsModel();
            $this->view = new APIView();


            $this->data = file_get_contents("php://input");
        }

        private function getData() {
            return json_decode($this->data);
        }

        public function getProducts($params = NULL) {
       /*     $products = $this->model->getAll();
            $this->view->response($products);*/
            if (isset($_GET['sortby']) && isset($_GET['order'])){
                if($_GET['order'] == 'ASC'){
                    if($_GET['sortby'] == 'price')
                    $products = $this->model->orderASC();//?sortby=price&order=ASC
                    }
                elseif ($_GET['order'] == 'DESC'){
                    if($_GET['sortby'] == 'price')
                    $products = $this->model->orderDESC();//?sortby=price&order=DESC
                }              
            }else{
            $products = $this->model->getAll();
            }
            return $this->view->response($products, 200);
            
          }

           /* if(isset($_GET['sort']) && isset($_GET['order'])){
                $sort = $_GET['sort'];
                $order = $_GET['order'];
                $products = $this->model->orderASC($sort,$order);
                if($products){
                    $this->view->response($products);
                }else{
                    $this->view->response("La peticion realizada no existe", 404);
                }
            }*/
        
        //trae un solo producto
        public function getProduct($params = null) {
            // obtengo el id del arreglo de params
            $id = $params[':ID'];
            $products = $this->model->get($id);
    
            // si no existe devuelvo 404
            if ($products)
                $this->view->response($products);
            else 
                $this->view->response("La tarea con el id=$id no existe", 404);
        }
        //inserta un producto
        public function insertProduct($params = null) {
            $product = $this->getData();
    
            if (empty($product->name) || empty($product->details) || empty($product->price)|| empty($product->ID_Category_FK)) {
                $this->view->response("Complete los datos", 400);
            } else {
                $id = $this->model->insert($product->name, $product->details, $product->price,$product->ID_Category_FK);
                $product = $this->model->get($id);
                $this->view->response($product, 201);
            }
        }
        public function deleteProduct($params = null) {
            $id = $params[':ID'];
    
            $product = $this->model->get($id);
            if ($product) {
                $this->model->delete($id);
                $this->view->response($product);
            } else 
                $this->view->response("La tarea con el id=$id no existe", 404);
        }
    
        public function updateProduct($params = null){
            $id = $params[':ID'];
            $product = $this->model->get($id);
            if ($product){
                $product = $this->getData();
                $this->model->update($product->name,$product->details,$product->price,$product->ID_Category_FK,$id);
                $this->view->response("El producto con el id= $id se actualizo correctamente",200);
                $this->view->response($product);
                }else {
                $this->view->response("El producto no existe",404);
            }
        }

    
        

    }