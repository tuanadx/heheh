<?php
class APCuCache {
    /**
     * Lấy giá trị từ cache
     * 
     * @param string $key Khóa cache
     * @param mixed $default Giá trị mặc định nếu không tìm thấy
     * @return mixed Giá trị từ cache hoặc giá trị mặc định
     */
    public static function get($key, $default = null) {
        if (!extension_loaded('apcu')) {
            return $default;
        }
        
        $success = false;
        $value = apcu_fetch($key, $success);
        
        return $success ? $value : $default;
    }
    
    /**
     * Lưu giá trị vào cache
     * 
     * @param string $key Khóa cache
     * @param mixed $value Giá trị cần lưu
     * @param int $ttl Thời gian sống (giây)
     * @return bool Kết quả lưu trữ
     */
    public static function set($key, $value, $ttl = 3600) {
        if (!extension_loaded('apcu')) {
            return false;
        }
        
        return apcu_store($key, $value, $ttl);
    }
    
    /**
     * Kiểm tra xem khóa có tồn tại trong cache
     * 
     * @param string $key Khóa cache
     * @return bool Kết quả kiểm tra
     */
    public static function exists($key) {
        if (!extension_loaded('apcu')) {
            return false;
        }
        
        return apcu_exists($key);
    }
    
    /**
     * Xóa một khóa khỏi cache
     * 
     * @param string $key Khóa cache
     * @return bool Kết quả xóa
     */
    public static function delete($key) {
        if (!extension_loaded('apcu')) {
            return false;
        }
        
        return apcu_delete($key);
    }
    
    /**
     * Xóa toàn bộ cache
     * 
     * @return bool Kết quả xóa
     */
    public static function clear() {
        if (!extension_loaded('apcu')) {
            return false;
        }
        
        return apcu_clear_cache();
    }
}