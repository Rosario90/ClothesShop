<?php
class Product
{
    protected $id;
    protected $name;
    protected $category;
    protected $price;
    protected $description;

    public function __construct($name = null, $category = null, $price = null, $description = null)
    {
        $this->name        = $name;
        $this->category    = $category;
        $this->price       = $price;
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    //Метод тащит из базы всю информацию о всех предметах
    public static function getAll()
    {
        return Db::getInstance()->fetchAll(
            "SELECT g.id AS id, g.name AS name, c.name AS category, g.price AS price,
            g.description AS description
                FROM goods AS g
                LEFT JOIN categories AS c
                ON c.id = g.category_id"
        );
    }

    //Этот метод ищет по названию товара его айдишник. Если нет такого, она вернет null
    public static function findId($name)
    {
        $arr = Db::getInstance()->fetch(
            "SELECT id FROM goods WHERE name = :name",
            array('name' => $name)
        );
        return $arr['id'];
    }

    protected function setId()
    {
        if(!is_null($id = self::findId($this->name)))
            $this->id = $id;
    }

    //Метод помещает в базу данных предмет в случае, если такого предмета еще нет в базе
    //В качестве бонуса он автоматически присваивает этому предмету новый айдишник из базы
    public function insertIntoDb()
    {
        if(is_null(self::findId($this->name))){
            Db::getInstance()->execute(
                "INSERT INTO goods (name, category_id, price, description)
                 VALUES (:name, (SELECT id FROM categories WHERE name = :category), :price, :description)",
                array(
                    'name'        => $this->name,
                    'category'    => $this->category,
                    'price'       => $this->price,
                    'description' => $this->description
                )
            );
            $this->id = self::findId($this->name);
        } else {
            echo "Товар с таким именем уже есть в базе";
        }
    }

    //Метод создает по айдишнику объект класса Product и заполняет его свойства данными из БД
    public static function getById($id)
    {
        return Db::getInstance()->fetchObject(
            "SELECT g.id AS id, g.name AS name, c.name AS category,
            g.price AS price, g.description AS description
                FROM goods AS g
                LEFT JOIN categories AS c
                ON c.id = g.category_id
                WHERE g.id = :id",
            array('id' => $id),
            self::class
        );
    }

    //Метод возвращает массив объектов класса Product с одинаковой категорией
    public static function getByCategory($category)
    {
        return Db::getInstance()->fetchObjects(
            "SELECT g.id AS id, g.name AS name, c.name AS category,
             g.price AS price, g.description AS description
              FROM goods AS g
              LEFT JOIN categories AS c
              ON c.id = g.category_id
              WHERE category_id = (SELECT id FROM categories WHERE name = :category)",
            array('category' => $category),
            self::class
        );
    }

    //Метод возвращает массив объектов класса Product определенного заказа
    public static function getByOrder($order_id)
    {
        return Db::getInstance()->fetchObjects(
            "SELECT g.name AS name, c.name AS category, g.price AS price,
             g.description AS description, oc.quantity AS quantity
              FROM order_contents AS oc
              LEFT JOIN goods AS g
              ON g.id = oc.good_id
              LEFT JOIN categories AS c
              ON c.id = g.category_id
              WHERE order_id = :order_id",
            array('order_id' => $order_id),
            self::class
        );
    }
}