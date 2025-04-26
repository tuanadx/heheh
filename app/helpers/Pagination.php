<?php
class Pagination {
    private $currentPage;
    private $totalItems;
    private $itemsPerPage;
    private $totalPages;
    private $urlPattern;

    public function __construct($currentPage, $totalItems, $itemsPerPage, $urlPattern) {
        $this->currentPage = (int)$currentPage;
        $this->totalItems = (int)$totalItems;
        $this->itemsPerPage = (int)$itemsPerPage;
        $this->urlPattern = $urlPattern;
        
        // Calculate total pages
        $this->totalPages = ceil($this->totalItems / $this->itemsPerPage);
        
        // Make sure current page is valid
        if ($this->currentPage < 1) {
            $this->currentPage = 1;
        }
        
        if ($this->currentPage > $this->totalPages && $this->totalPages > 0) {
            $this->currentPage = $this->totalPages;
        }
    }
    
    public function getOffset() {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }
    
    public function getLimit() {
        return $this->itemsPerPage;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
    }
    
    public function getTotalPages() {
        return $this->totalPages;
    }
    
    public function getTotalItems() {
        return $this->totalItems;
    }
    
    public function hasPages() {
        return $this->totalPages > 1;
    }
    
    public function hasPrevious() {
        return $this->currentPage > 1;
    }
    
    public function hasNext() {
        return $this->currentPage < $this->totalPages;
    }
    
    public function previousUrl() {
        if (!$this->hasPrevious()) {
            return '#';
        }
        
        return str_replace('{page}', $this->currentPage - 1, $this->urlPattern);
    }
    
    public function nextUrl() {
        if (!$this->hasNext()) {
            return '#';
        }
        
        return str_replace('{page}', $this->currentPage + 1, $this->urlPattern);
    }
    
    public function pageUrl($page) {
        return str_replace('{page}', $page, $this->urlPattern);
    }
    
    public function getPageLinks($sideLinksCount = 2) {
        $links = [];
        
        $startPage = max(1, $this->currentPage - $sideLinksCount);
        $endPage = min($this->totalPages, $this->currentPage + $sideLinksCount);
        
        // Always show first page link
        if ($startPage > 1) {
            $links[] = [
                'page' => 1,
                'url' => $this->pageUrl(1),
                'isActive' => false
            ];
            
            // Add ellipsis if necessary
            if ($startPage > 2) {
                $links[] = [
                    'page' => '...',
                    'url' => '#',
                    'isActive' => false,
                    'isEllipsis' => true
                ];
            }
        }
        
        // Add page links
        for ($i = $startPage; $i <= $endPage; $i++) {
            $links[] = [
                'page' => $i,
                'url' => $this->pageUrl($i),
                'isActive' => ($i == $this->currentPage)
            ];
        }
        
        // Always show last page link
        if ($endPage < $this->totalPages) {
            // Add ellipsis if necessary
            if ($endPage < $this->totalPages - 1) {
                $links[] = [
                    'page' => '...',
                    'url' => '#',
                    'isActive' => false,
                    'isEllipsis' => true
                ];
            }
            
            $links[] = [
                'page' => $this->totalPages,
                'url' => $this->pageUrl($this->totalPages),
                'isActive' => false
            ];
        }
        
        return $links;
    }
    
    public function render() {
        if (!$this->hasPages()) {
            return '';
        }
        
        $html = '<nav aria-label="Phân trang">';
        $html .= '<ul class="pagination justify-content-center mt-4">';
        
        // Previous Page Link
        $html .= '<li class="page-item' . (!$this->hasPrevious() ? ' disabled' : '') . '">';
        $html .= '<a class="page-link" href="' . $this->previousUrl() . '" aria-label="Trang trước">';
        $html .= '<span aria-hidden="true">&laquo;</span>';
        $html .= '</a>';
        $html .= '</li>';
        
        // Page Links
        foreach ($this->getPageLinks() as $link) {
            $isEllipsis = isset($link['isEllipsis']) && $link['isEllipsis'];
            
            $html .= '<li class="page-item' . ($link['isActive'] ? ' active' : '') . ($isEllipsis ? ' disabled' : '') . '">';
            $html .= '<a class="page-link" href="' . $link['url'] . '">' . $link['page'] . '</a>';
            $html .= '</li>';
        }
        
        // Next Page Link
        $html .= '<li class="page-item' . (!$this->hasNext() ? ' disabled' : '') . '">';
        $html .= '<a class="page-link" href="' . $this->nextUrl() . '" aria-label="Trang sau">';
        $html .= '<span aria-hidden="true">&raquo;</span>';
        $html .= '</a>';
        $html .= '</li>';
        
        $html .= '</ul>';
        $html .= '</nav>';
        
        return $html;
    }
} 