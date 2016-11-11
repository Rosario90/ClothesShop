<?php

class CategoryController extends Controller
{
    public function actionShowAll()
    {
        $categories = Category::getAll();
        $this->render('CategoryAll', ['categories' => $categories]);
    }
}