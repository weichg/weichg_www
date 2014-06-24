<?php
class HrController extends \Phalcon\Mvc\Controller
{

	public function indexAction()
	{
		 
	}
	
	public function regionAction()
	{
		$id = $this->request->get("id", 'int', 0);
		$s_id = $this->request->get("s_id", 'int', 0);
		
		$this->db->query("set names 'utf8'");
		$regions = $this->db->fetchAll("SELECT * FROM weic_region WHERE parent_id=$id");
		$ret = '<option value="0">请选择</option>';
		foreach ($regions as $z) {
			if ($s_id == $z['region_id']) {
				$ret .= "<option value=\"{$z['region_id']}\" selected>{$z['region_name']}</option>";
			} else {
				$ret .= "<option value=\"{$z['region_id']}\">{$z['region_name']}</option>";
			}
			
		}
		echo $ret;
	}
	
	public function baomingAction(){
		if ($this->request->isPost()) {
			$truename = $this->request->get("truename", 'string', "");
			$sex = $this->request->get("sex", 'string', "");
			$idcard = $this->request->get("idcard", 'string', "");
			$phone = $this->request->get("phone", 'string', "");
			$qq = $this->request->get("qq", 'string', "");
			$province = $this->request->get("province", 'int', 0);
			$city = $this->request->get("city", 'int', 0);
			$county = $this->request->get("county", 'int', 0);
			$college = $this->request->get("college", 'string', "");
			$major = $this->request->get("major", 'string', "");
			$exps = $this->request->get("exps", 'int', 0);
			$others = $this->request->get("others", 'int', 0);
			//$agree = $this->request->get("agree", 'int', 1);
			$profile = $this->request->get("profile", 'string', "");
		    
			$expe = 0;
			foreach ($exps as $e) {
				$expe += $e;
			}
			$other = 0;
			foreach ($others as $o) {
				$other += $o;
			}
			$this->db->query("set names 'utf8'");
			$this->db->insert('weic_baoming', array("$truename","$sex","$idcard","$phone","$qq",
					$province,$city,$county,"$college","$major",$expe,$other,"$profile",time()),
					array("truename","sex","idcard","phone","qq","province_id","city_id",
							"county_id","college","major","exps","other","profile","bm_time"));
			echo "success";
		}
		else {
			echo "error";
		}
	}
}
