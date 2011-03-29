<?php

class Playroom extends Shop_Controller {

    private $module;


  function  Playroom(){
    parent::Shop_Controller();
    $this->module = strtolower(get_class());
    $this->load->module_model('kaimonokago','MKaimonokago');

  }


    function index(){
        $lang_id = $this->lang_id;
        $fields = array('id', 'name','shortdesc','image','parentid','status','table_id','lang_id');
        $orderby = array('lang_id','parentid','table_id');
        $data['items']= $this->MKaimonokago->getAll($this->module,$fields, $orderby,$lang_id);
        $data['module']=$this->module;
        $data['title'] = 'Playroom';
        $data['page'] = 'index';
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
      
       // redirect( 'welcome/playroom','refresh');
  }


  function puzzles(){
        $data['module_name']=$this->module_name;
        $data['title'] = 'Puzzle';
        $data['page'] = 'puzzles/puzzle';
        $data['module'] = $this->module_name;
        $this->load->view($this->_container,$data);
  }

}