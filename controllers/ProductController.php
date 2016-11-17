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
        $rm = new RequestManager();
        $cat = urldecode($rm->getParams()[0]);
        $categories = Category::getAll();
        $products = Product::getByCategory($cat);
        $this->render(
            'ProductCategory',
            [
                'categories' => $categories,
                'productList' => $products
            ]
        );
    }

    public function actionIndex()
    {
        echo 'Hello';
    }

}