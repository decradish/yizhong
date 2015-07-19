<?php
class Ori_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

	public function mAdd($data, $table='user'){
        $query = $this->db->insert($table, $data);
        return $query;
	}

	public function mGetAllReal($table='user', $order='desc'){
		$this->db->order_by('create_time', $order);
		$query = $this->db->get($table);
		$result = fOb2Arr($query->result());
		return $result;
	}

	public function mGetAll($limit=5, $no=0, $order='desc', $table='user'){
		$this->db->order_by('create_time', $order);
		$this->db->limit($limit, $no);
		$query = $this->db->get($table);
		$result = fOb2Arr($query->result());
		return $result;
	}

	public function mPngGetBy($field, $val, $limit=5, $no=0, $order='desc', $table='user'){
		$this->db->where($field, $val);
		$this->db->order_by('create_time', $order);
		$this->db->limit($limit, $no);
		$query = $this->db->get($table);
		$result = fOb2Arr($query->result());
		return $result;
	}

	public function mGet($id, $table='user'){
		$this->db->where('id', $id);
		$query = $this->db->get($table);
		return fOb2Arr($query->result());
	}

	public function mGetBy($field, $val, $table='user', $order=null){
		if($order){
			$this->db->order_by($order, "asc"); 
		}
		$this->db->where($field, $val);
		$query = $this->db->get($table);
		return fOb2Arr($query->result());
	}

	public function mGetByArray($aPost, $table='user'){
		foreach ($aPost as $key => $value) {
			$this->db->where($key, $value);
		}
		$query = $this->db->get($table);
		return fOb2Arr($query->result());
	}

	public function mUpdate($id, $data, $table='user'){
        $this->db->where('id', $id);
		$query = $this->db->update($table, $data);
		return $query;
	}

	public function mUpdateById($id, $data, $table='user'){
        $this->db->where('id', $id);
		$query = $this->db->update($table, $data);
		return $query;
	}

	public function mUpdateBy($field, $value, $data, $table='user'){
        $this->db->where($field, $value);
		$query = $this->db->update($table, $data);
		return $query;
	}

	public function mUpdateByArray($aPost, $data, $table='user'){
		foreach ($aPost as $key => $value) {
			$this->db->where($key, $value);
		}
		$query = $this->db->update($table, $data);
		return $query;
	}

	public function mDelete($id, $table='user'){
		$query = $this->db->delete($table, array('id' => $id));
		return $query;
	}

	public function mCountBy($by='id', $value='', $table='user'){
		$this->db->where($by, $value);
		$this->db->from($table);
		$query = $this->db->count_all_results();
		return $query;
	}

	public function mCountAll($table='user'){
		$query = $this->db->count_all_results($table);
		return $query;
	}
}