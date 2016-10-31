<?php
class Order extends Model
{
    protected $id;
    protected $customer;
    protected $contents = [];
    protected $date;

    public function getId()
    {
        return $this->id;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function getDate()
    {
        return $this->date;
    }


    public function addLine(Product $item, $qty = 1)
    {
        $this->contents[] = new ItemLine($item, $qty);
    }

    public static function getById($id)
    {
        $inst = self::getConnection()->fetchObject(
            "SELECT o.id AS id, c.name AS customer, o.date AS date
              FROM orders AS o
              LEFT JOIN customers AS c
              ON c.id = o.customer_id
              WHERE o.id = :id",
            array('id' => $id),
            self::class
        );
        $arr = self::getConnection()->fetchAll(
            "SELECT good_id, quantity
              FROM order_contents
              WHERE order_id = :id",
            array('id' => $id)
        );
        foreach ($arr as $line){
            $inst->contents[] = new ItemLine(Product::getById($line['good_id']), $line['quantity']);
        }
        return $inst;
    }
}