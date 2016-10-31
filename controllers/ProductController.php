<?php

class ProductController extends Controller
{
    public function actionShowCard()
    {
        $id = $_GET['id'];
        $product = Product::getById($id);
        $this->render('ProductCard', ['product' => $product]);
    }

    public function actionShowCategory()
    {
        $cat = $_GET['cat'];
        $products = Product::getByCategory($cat);
        $this->render('ProductCategory', ['productList' => $products]);
    }


}