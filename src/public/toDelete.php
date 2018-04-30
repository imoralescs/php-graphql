<?php

// Register our Composer autoloader.
require_once(__DIR__.'/../vendor/autoload.php');

// Create a new Carbon instance to represent right now.
use Carbon\Carbon;
$now = Carbon::now();

$container = new League\Container\Container;

// Add a service or value to the container
$container->add('now', $now);

// Retrieve the service from the container
$service = $container->get('now');

//var_dump($service);

// Create function
/*
function someName($parameter) {
    $result = 'Init function';
    $result .= ' and also ' . $parameter;
    return $result;
}

var_dump(someName("this parameter"));
*/

// One or more
/*
function someOtherName($requiredParam, $optionalParam = null) {
    $result = 0;
    $result += $requiredParam;
    $result += $optionalParam ?? 0;
    return $result;
}
*/

// Hinting at data types
/*
function someTypeHint(Array $a, DateTime $t, Callable $c) {
    $massage = '';
    $message .= 'Array Count: ' . count($a) . PHP_EOL;
    $message .= 'Date: ' . $t->format('Y-m-d') . PHP_EOL;
    $message .= 'Callable Return: ' . $c() . PHP_EOL;
    return $message;
}
*/

// Creating class
// Object - are representation of real life elements. Each object has set of attributes that it from the rest of the objects of the same class.
// Class - is the definition of what an object looks like and what it can do, like a pattern for objects.

// A class is defined by the keyword class followed by valid class name.
/*
class Book {

}

class Customer {

}
*/

// To instantiate object by class.
/*
$book = new Book();
$customer = new Customer();
*/ 

// Class Properties
/*
class Book {
    public $isbn;
    public $title;
    public $author;
    public $available;
}

$book = new Book();
$book->title = "1986";
$book->author = "George Orwell";
$book->available = true;

var_dump($book);
*/

// Class Methods
// Method are function defined inside class, like function, method get some argument and perform some action.
/*
class Book {
    public $isbn;
    public $title;
    public $author;
    public $available;

    public function getCopy(): bool {
        if($this->available < 1) {
            return false;
        }
        else {
            $this->available--;
            return true;
        }
    }
}

$book = new Book();
$book->title = "1986";
$book->author = "George Orwell";
$book->isbn = 9785267006323;
$book->available = 12;

if($book->getCopy()) {
    echo 'Here, your copy.';
}
else {
    echo 'I am afraid that book is not available.';
}
*/

// Class constructors
/*
Constructors are functions that are invoked when someone creates a new instance of the class. They look like normal methods, with the exception that their name is always __construct, and that they do not have a return statement, as they always have to return the new instance. 
*/
/*
class Book {
    public function __construct(
        int $isbn, 
        string $title, 
        string $author, 
        int $available = 0) {
            $this->isbn = $isbn;
            $this->title = $title;
            $this->author = $author;
            $this->available = $available;
    }

    public function getCopy(): bool {
        if($this->available < 1) {
            return false;
        }
        else {
            $this->available--;
            return true;
        }
    }
}

$book = new Book("1986", "George Orwell", 9785267006323);
var_dump($book);
*/
// Magic method

// Properties and methods visibility
/*
private: This type allows access only to members of the same class. If A and B are
instances of the class C, A can access the properties and methods of B.
protected: This type allows access to members of the same class and instances from
classes that inherit from that one only. You will see inheritance in the next section.
public: This type refers to a property or method that is accessible from anywhere.
Any classes or code in general from outside the class can access it.
*/
/*
class Book {
    public function __construct(
        int $isbn, 
        string $title, 
        string $author, 
        int $available = 0) {
            $this->isbn = $isbn;
            $this->title = $title;
            $this->author = $author;
            $this->available = $available;
    }

    public function getCopy(): bool {
        if($this->available < 1) {
            return false;
        }
        else {
            $this->available--;
            return true;
        }
    }
}

class Customer {
    private $id;
    private $firstName;
    private $lastName;
    private $email;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $email) {
            $this->id = $id;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
    }
}

$book1 = new Book("1984", "George Orwell", 9785267006323, 10);
$customer1 = new Customer(1, 'John', 'Doe', 'johndoe@email.com');

$book1->available = 2;
$customer1->id = 3; //-> Cannot access private property Customer::$id
*/

// Encapsulation
/*
class Customer {
    private $id;
    private $firstName;
    private $lastName;
    private $email;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $email) {
            $this->id = $id;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
    }

    public function getId(): id {
        return $this->id;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }
}

class Book {
    public function __construct(
        int $isbn, 
        string $title, 
        string $author, 
        int $available = 0) {
            $this->isbn = $isbn;
            $this->title = $title;
            $this->author = $author;
            $this->available = $available;
    }

    public function getCopy(): bool {
        if($this->available < 1) {
            return false;
        }
        else {
            $this->available--;
            return true;
        }
    }

    public function getIsbn(): int {
        return $this->isbn;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function isAvailable(): bool {
        return $this->available;
    }

    public function addCopy() {
        $this->available++;
    }
}
*/

// Static property or method
/*
class Customer {
    private $id;
    private static $lastId = 0;
    private $firstName;
    private $lastName;
    private $email;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $email) {
            if(empty($id)) {
                $this->id = ++self::$lastId;
            }
            else {
                $this->id = $id;
                if($id > self::$lastId) {
                    self::$lastId = $id;
                }
            }
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
    }

    public function getId(): id {
        return $this->id;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public static function getLastId(): int {
        return self::$lastId;
    }
}

$customer1 = new Customer(3, 'John', 'Doe', 'johndow@gmail.com');
$customer2 = new Customer(null, 'Mary', 'Poppins', 'mp@gmail.com');
$customer3 = new Customer(7, 'James', 'Doe', 'jamesdow@gmail.com');

echo $customer1::getLastId();
*/

//Inheritance
/*
class Person {
    protected $firstName;
    protected $lastName;

    public function __construct(
        string $firstName,
        string $lastName) {
            $this->firstName = $firstName;
            $this->lastName = $lastName;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }
}

class Customer extends Person {
    private static $lastId = 0;
    private $id;
    private $email;

    public function __construct(
        int $id,
        string $email) {
            if(empty($id)) {
                $this->id = ++self::$lastId;
            }
            else {
                $this->id = $id;
                if($id > self::$lastId) {
                    self::$lastId = $id;
                }
            }
            $this->email = $email;
    }

    public static function getLastId(): int {
        return self::$lastId;
    }

    public function getId(): id {
        return $this->id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }
}
*/

// Overriding method
/*
class Pops {
    public function sayHi() {
        echo "Hi, I am pops";
    }
}

class Child extends Pops {
    public function sayHi() {
        echo "Hi, I am child";
    }
}

$pops = new Pops();
$child = new Child();

echo $pops->sayHi();
echo $child->sayHi();
*/

//Abstract classes
/*
class Book {
    public function __construct(
        int $isbn, 
        string $title, 
        string $author, 
        int $available = 0) {
            $this->isbn = $isbn;
            $this->title = $title;
            $this->author = $author;
            $this->available = $available;
    }

    public function getCopy(): bool {
        if($this->available < 1) {
            return false;
        }
        else {
            $this->available--;
            return true;
        }
    }

    public function getIsbn(): int {
        return $this->isbn;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function isAvailable(): bool {
        return $this->available;
    }

    public function addCopy() {
        $this->available++;
    }
}

class Person {
    protected $firstName;
    protected $lastName;

    public function __construct(
        string $firstName,
        string $lastName) {
            $this->firstName = $firstName;
            $this->lastName = $lastName;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }
}

abstract class Customer extends Person {
    private static $lastId = 0;
    private $id;
    private $email;

    public function __construct(
        int $id,
        string $email) {
            if(empty($id)) {
                $this->id = ++self::$lastId;
            }
            else {
                $this->id = $id;
                if($id > self::$lastId) {
                    self::$lastId - $id;
                }
            }
            $this->email = $email;
    }

    public static function getLastId(): int {
        return self::$lastId;
    }

    public function getId(): id {
        return $this->id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    abstract public function getMonthlyFee();
    abstract public function getAmountToBorrow();
    abstract public function getType();
}

class Basic extends Customer {
    public function getMonthlyFee(): float {
        return 5.0;
    }

    public function getAmountToBorrow(): int {
        return 3;
    }

    public function getType(): string {
        return 'Basic';
    }
}

class Premium extends Customer {
    public function getMonthlyFee(): float {
        return 10.0;
    }

    public function getAmountToBorrow(): int {
        return 10;
    }

    public function getType(): string {
        return 'Premium';
    }
}

$book1 = new Book("1984", "George Orwell", 9785267006323, 10);
$book2 = new Book("1984", "George Orwell", 9785267006323, 10);
print_r($book1);

function checkIfValid(Customer $customer, array $book): bool {
    return $customer->getAmountToBorrow() >= count($books);
}

$customer1 = new Basic(5, 'John', 'Doe', 'johndoe@gmail.com');
print_r(checkIfValid($customer1, [$book1, $book2]));

// without abstract class the following clas will fail
//$customer2 = new Customer(5, 'John', 'Doe', 'johndoe@gmail.com');
//print_r(checkIfValid($customer2, [$book1, $book2]));
*/

// Interface
/*
class Book {
    public function __construct(
        int $isbn, 
        string $title, 
        string $author, 
        int $available = 0) {
            $this->isbn = $isbn;
            $this->title = $title;
            $this->author = $author;
            $this->available = $available;
    }

    public function getCopy(): bool {
        if($this->available < 1) {
            return false;
        }
        else {
            $this->available--;
            return true;
        }
    }

    public function getIsbn(): int {
        return $this->isbn;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function isAvailable(): bool {
        return $this->available;
    }

    public function addCopy() {
        $this->available++;
    }
}

class Person {
    private static $lastId = 0;
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $email;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $email) {
            if(empty($id)) {
                $this->id = ++self::$lastId;
            }
            else {
                $this->id = $id;
                if($id > self::$lastId) {
                    self::$lastId - $id;
                }
            }
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
    }

    public static function getLastId(): int {
        return self::$lastId;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }
}

interface Customer {
    public function getMonthlyFee(): float;
    public function getAmountToBorrow(): int;
    public function getType(): string;
}

interface Payer {
    public function pay(float $amount);
    public function isExtentOfTaxes(): bool;
}

class Basic extends Person implements Customer {
    public function getMonthlyFee(): float {
        return 5.0;
    }

    public function getAmountToBorrow(): int {
        return 3;
    }

    public function getType(): string {
        return 'Basic';
    }

    public function pay(float $amount) {
        echo "Paying $amount.";
    }

    public function isExtentOfTaxes(): bool {
        return false;
    }
}

class Premium extends Person implements Customer {
    public function getMonthlyFee(): float {
        return 10.0;
    }

    public function getAmountToBorrow(): int {
        return 10;
    }

    public function getType(): string {
        return 'Premium';
    }

    public function pay(float $amount) {
        echo "Paying $amount.";
    }

    public function isExtentOfTaxes(): bool {
        return true;
    }
}

$book1 = new Book("1984", "George Orwell", 9785267006323, 10);
*/

// Traits
/*
class Book {
    public function __construct(
        int $isbn, 
        string $title, 
        string $author, 
        int $available = 0) {
            $this->isbn = $isbn;
            $this->title = $title;
            $this->author = $author;
            $this->available = $available;
    }

    public function getCopy(): bool {
        if($this->available < 1) {
            return false;
        }
        else {
            $this->available--;
            return true;
        }
    }

    public function getIsbn(): int {
        return $this->isbn;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function isAvailable(): bool {
        return $this->available;
    }

    public function addCopy() {
        $this->available++;
    }
}

trait Unique {
    private static $lastId = 0;
    protected $id;

    public function setId($id) {
        if(empty($id)) {
            $this->id = ++self::$lastId;
        }
        else {
            $this->id = $id;
            if($id > self::$lastId) {
                self::$lastId = $id;
            }
        }
    }

    public static function getLastId(): int {
        return self::$lastId;
    }

    public function getId(): int {
        return $this->id;
    }
}

class Person {
    use Unique;

    protected $firstName;
    protected $lastName;
    protected $email;

    public function __construct(
        $id,
        string $firstName,
        string $lastName,
        string $email) {
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
            $this->setId($id);
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }
}

interface Customer {
    public function getMonthlyFee(): float;
    public function getAmountToBorrow(): int;
    public function getType(): string;
}

interface Payer {
    public function pay(float $amount);
    public function isExtentOfTaxes(): bool;
}

class Basic extends Person implements Customer {
    public function getMonthlyFee(): float {
        return 5.0;
    }

    public function getAmountToBorrow(): int {
        return 3;
    }

    public function getType(): string {
        return 'Basic';
    }

    public function pay(float $amount) {
        echo "Paying $amount.";
    }

    public function isExtentOfTaxes(): bool {
        return false;
    }
}

class Premium extends Person implements Customer {
    public function getMonthlyFee(): float {
        return 10.0;
    }

    public function getAmountToBorrow(): int {
        return 10;
    }

    public function getType(): string {
        return 'Premium';
    }

    public function pay(float $amount) {
        echo "Paying $amount.";
    }

    public function isExtentOfTaxes(): bool {
        return true;
    }
}

$basic1 = new Basic(1, 'Name', 'Last', 'Email');
$basic2 = new Basic(null, 'Name', 'Last', 'Email');
$premium = new Premium(null, 'Name', 'Last', 'Email');

var_dump($basic1->getId());
var_dump($basic2->getId());
var_dump($premium->getId());
*/