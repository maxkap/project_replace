<?php
class ModelModuleProductsReplace extends Model {
    
    public function getProductIdsByCategory($category_id) {
        
        $product_ids = array();

        $query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$category_id . "'");

        foreach ($query->rows as $result) {
                $product_ids[] = $result['product_id'] ;
        }

        return $product_ids;
        
    }
    
    
    public function deleteProductsFromCategory($category_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$category_id . "'");
    }
    
    public function startReplace($categories_from, $category_to, $replace_to = 0, $replace_from = 0) {
        
        if ($replace_to){
            $this->deleteProductsFromCategory($category_to);
        }
        
        $products_to_insert = array();
        
        foreach ($categories_from as $category_id) {
            
            $products = $this->getProductIdsByCategory($category_id);
            if ($products)  {
                $products_to_insert = array_merge($products_to_insert, $products);
            }
            if ($replace_from){
                $this->deleteProductsFromCategory($category_id);
            }
            
        }
        
        
        $this->insertProductsToCategory($products_to_insert, $category_to);
    }
    
    
    public function insertProductsToCategory($products_to_insert, $category_id) {
        
        $sql = "REPLACE INTO `" . DB_PREFIX . "product_to_category` (`product_id`, `category_id`) VALUES ";
        
        $insert = array();
        
        foreach ($products_to_insert as $product_id) {
            
            $insert[] = " ($product_id, $category_id) ";
            
        }
        
        $this->db->query($sql . implode(',', $insert));
        
    }
    
}
