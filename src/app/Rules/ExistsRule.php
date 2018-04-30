<?php 

namespace NamespacesName\Rules;

use Doctrine\ORM\EntityManager;

class ExistsRule
{
    protected $db;

    public function __construct(EntityManager $db) {
        $this->db = $db;
    }

    public function validate($field, $value, $params, $fields) {
        // Used model
        //dump($params); // 0 => "NamespacesName\Models\User"
        
        $result = $this->db->getRepository($params[0])
            ->findOneBy([
                $field => $value
            ]);
        return $result === null;
    }
}