<?php

class ProductController extends Controller
{
    public function actionShowCard(){
        $id = $_GET['id'];
        $products['obj'] = Product::getById($id);
        $this->render('ProductCard', $products);
    }



}