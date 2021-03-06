<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Area_Professor
 *
 * @author Helison
 */
class Application_Model_DbTable_AreaProfessor extends Zend_Db_Table_Abstract {

    protected $_name = 'area_professor';
    protected $_referenceMap = array(
        'AreaProfessorProfessor' => array(
            'refTableClass' => 'Application_Model_DbTable_Professor',
            'columns' => array('idProfessor'),
            'refColumns' => 'id_professor'
        ),
        'AreaProfessorArea' => array(
            'refTableClass' => 'Application_Model_DbTable_Area',
            'columns' => array('idArea'),
            'refColumns' => 'id_area'
        )
    );

    /*
      function getValuesToSelectElement($order = ' asc') {
      $class = get_called_class();
      $model = new $class;
      $info = $model->info();
      $select = $model->select()->order($order);
      $result = $model->fetchAll($select);
      $resultArray = array();
      foreach ($result as $row):
      $resultArray[$row->$info['primary'][1]] = $row->nome;
      endforeach;
      return $resultArray;
      }
     */

    public function listaAreaProfessorPor($value) {
        $select = $this->select()->order($value);
        return $this->fetchAll($select);
    }

    public function cadastraAreaProfessor($dados) {
        //$areaProfessor->id_area($dados['id_area']);
        //$areaProfessor->id_professor($dados['id_professor']);
        return $areaProfessor = $this->insert($dados);
    }

    public function editarArea(array $dados) {
        $area = $this->find($dados['id_area'])->current();
        $area->setNome($dados['nome']);
        $area->setDescricao($dados['descricao']);

        return $area->save();
    }

    public static function getPrimaryKeyName() {
        $class = get_called_class();
        $model = new $class;
        $info = $model->info();
        return $info['primary'][1];
    }

    public function removerAreasProfessor($id_professor) {
        $where = $this->getAdapter()->quoteInto('id_professor = ?', $id_professor);
        $this->delete($where);
    }

    public function getAreasInteresse($idProfessor) {
        $select = $this->select()->where("id_professor = ?", $idProfessor);
        $areasInteresse = $this->fetchAll($select);
        $lista = array();
        $modelArea = new Application_Model_DbTable_Area();
        foreach ($areasInteresse as $item) {
            $area = $modelArea->getArea($item['id_area']);
            $lista[$area->getId_area()] = $area->getNome();
        }
        return $lista;
    }

}
