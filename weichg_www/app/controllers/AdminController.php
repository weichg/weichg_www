<?php
class AdminController extends \Phalcon\Mvc\Controller
{

	public function indexAction()
	{
		
	}
	
	public function logoutAction()
	{
		//Forward to the login form again
		return $this->dispatcher->forward(array(
				'controller' => 'session',
				'action' => 'remove'
		));
	}
	
	public function baomingAction()
	{
		if ($this->session->has("auth")) {
			$currentPage = $this->request->get("page", "int", 1);
			$province = $this->request->get("province", 'int', 0);
			$city = $this->request->get("city", 'int', 0);
			$county = $this->request->get("county", 'int', 0);
			
			$where = "";
			if ($province) {
				$where .= " AND b.province_id=$province";
			}
			if ($city) {
				$where .= " AND b.city_id=$city";
			}
			if ($county) {
				$where .= " AND b.county_id=$county";
			}
			
			$this->db->query("set names 'utf8'");
			// The data set to paginate
			$sql = "SELECT b.id AS id, b.truename AS truename, b.sex AS sex, b.idcard AS idcard, b.phone AS phone, b.qq AS qq, r1.region_name AS province, r2.region_name AS city, r3.region_name AS county, b.college AS college, b.major AS major, b.exps AS exps, b.other AS other, b.profile AS profile, b.bm_time AS bm_time FROM weic_baoming AS b, weic_region AS r1, weic_region AS r2, weic_region AS r3 where b.province_id=r1.region_id and b.city_id=r2.region_id and b.county_id=r3.region_id";
			$sql .= $where;
			$baos = $this->db->fetchAll($sql);
	
			// Create a Model paginator, show 10 rows by page starting from $currentPage
			$paginator = new \Phalcon\Paginator\Adapter\NativeArray (
				array(
					"data" => $baos,
					"limit"=> 50,
					"page" => $currentPage
				)
			);
			
			// Get the paginated results
			$page = $paginator->getPaginate();
			$this->view->setVar("page", $page);
			$this->view->setVar("province_id", $province);
			$this->view->setVar("city_id", $city);
			$this->view->setVar("county_id", $county);
		} else {
			return $this->dispatcher->forward(array(
					'controller' => 'admin',
					'action' => 'index'
			));
		}
	}
}