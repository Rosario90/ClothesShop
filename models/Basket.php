<?php

class Basket extends Model
{
    protected $order_id;
    protected $items = [];

    public function addItem($id)
    {
        $item = Product::getById($id);
        $this->items[] = $item;
    }



    /*public function takeItemFromWarehouse($id, $warehouse_id){
        $pdo = self::getConnection()->getConnection();
        $obj = Product::getById($id);
        var_dump($obj);
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare(
                'UPDATE stocks SET quantity = quantity - 1
                 WHERE good_id = :id AND warehouse_id = :warehouse_id AND quantity > 0'
            );
            $stmt->execute(array('id' => $id, 'warehouse_id' => $warehouse_id));
            $this->items[] = new Product($id, $obj->name, $obj->category_id, $obj->price, $obj->description);
            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
        }
    }*/

}