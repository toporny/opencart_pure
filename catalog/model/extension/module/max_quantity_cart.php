<?php
class ModelExtensionModuleMaxQuantityCart extends Model {

	private function getProductsAndQuantities($ids) {
		$sql  = "SELECT product_id, quantity ";
		$sql .= " FROM `" . DB_PREFIX . "product` ";
		$sql .= " WHERE product_id in (".implode (",", $ids).")";
		$query = $this->db->query($sql);
		$return = array();
		foreach ($query->rows as $item) {
			$return[$item['product_id']] = $item['quantity'];
		} 
		return $return; 
	}


	public function putMaxQuantityToProducts($products) {
		$ids = array();
		foreach ($products as $product) {
			$ids[] = $product['product_id'];
		}
		if (count($ids)>0) {
			$result = $this->getProductsAndQuantities($ids);
			foreach ($products as &$product) {
				$product['max_quantity'] = $result[$product['product_id']];
			}
		}
		return $products;
	}
}