<?php
class Product extends Model
{
    protected $id;
    protected $name;
    protected $category;
    protected $price;
    protected $description;

    public function __construct($name, $category, $price, $description)
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
        return self::getConnection()->fetchAll(
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
        $arr = self::getConnection()->fetch(
            "SELECT id FROM goods WHERE name = :name",
            array('name' => $name)
        );
        return $arr['id'];
    }

    //Метод защищен, потому что я не хочу, чтобы кто-то создал объект с таким же названием как
    //в базе, но с другой ценой и описанием, и присвоил этому объекту id из моей базы
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
            self::getConnection()->execute(
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
        return self::getConnection()->fetchObject(
            "SELECT g.id AS id, g.name AS name, c.name AS category,
            g.price AS price, g.description AS description
                FROM goods AS g
                LEFT JOIN categories AS c
                ON c.id = g.category_id
                WHERE g.id = :id",
            array('id' => $id),
            self::class,
            array(null, null, null, null) // - это чтобы конструктор не мешал
        );
    }
}