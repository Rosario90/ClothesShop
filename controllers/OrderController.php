<?php
class OrderController extends Controller
{
    public function actionShowContents()
    {
        $id = $_GET['id'];
        $order = Order::getById($id);
        $this->render('OrderDetails', ['order' => $order]);
    }

    public function actionIndex()
    {
        echo 'Hello';
    }
}