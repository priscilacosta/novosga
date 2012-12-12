<?php
namespace modules\sga\cargos;

use \core\SGAContext;
use \core\util\Arrays;
use \core\model\SequencialModel;
use \core\model\Cargo;
use \core\controller\TreeModelController;

/**
 * CargosController
 *
 * @author rogeriolino
 */
class CargosController extends TreeModelController {

    protected function createModel() {
        return new Cargo();
    }
    
    protected function requiredFields() {
        return array('nome', 'descricao');
    }

    protected function preSave(SequencialModel $model) {
        $id_pai = (int) Arrays::value($_POST, 'id_pai', 0);
//        echo $id_pai; exit();
        $pai = $this->em()->find(get_class($model), $id_pai);
        if ($pai) {
            $model->setParent($pai);
        }
        if ($model->getId() == 0 && !$pai) {
            throw new \Exception(_('Favor escolher o Cargo pai'));
        }
    }

    protected function search($arg) {
        $query = $this->em()->createQuery("
            SELECT 
                e 
            FROM 
                \core\model\Cargo e 
            WHERE 
                UPPER(e.nome) LIKE :arg OR UPPER(e.descricao) LIKE :arg  
            ORDER BY 
                e.left, e.nome
        ");
        $query->setParameter('arg', $arg);
        return $query->getResult();
    }

}
