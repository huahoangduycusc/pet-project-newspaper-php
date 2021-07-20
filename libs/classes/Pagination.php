<?php
class Pagination
{
    /**
     * Biến config chứa tất cả các cấu hình
     *
     * @var array
     */
    private $config = [
        'total' => 0, // tổng số mẩu tin
        'limit' => 10, // số mẩu tin trên một trang
        'full' => true, // true nếu hiện full số page, flase nếu không muốn hiện false
        'querystring' => 'page', // GET id nhận page
        'url' => 'url'
    ];

    /**
     * khởi tạo
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        // kiểm tra xem trong config có limit, total đủ điều kiện không
        if (isset($config['limit']) && $config['limit'] < 0 || isset($config['total']) && $config['total'] < 0) {
            // nếu không thì dừng chương trình và hiển thị thông báo.
            die('limit và total không được nhỏ hơn 0');
        }
        // Kiểm tra xem config có querystring không
        if (!isset($config['querystring'])) {
            //nếu không để mặc định là page
            $config['querystring'] = 'page';
        }
        if (!isset($config['querys'])) {
            //nếu không để mặc định là page
            $config['querys'] = 'list';
        }
        $this->config = $config;
    }

    /**
     * Lấy ra tổng số trang
     *
     * @return int
     */
    private function gettotalPage()
    {
        return ceil($this->config['total'] / $this->config['limit']);
    }

    /**
     * Lấy ra trang hiện tại
     *
     * @return int
     */
    private function getCurrentPage()
    {
        // kiểm tra tồn tại GET querystring và có >=1 không
        if (isset($_GET[$this->config['querystring']]) && (int)$_GET[$this->config['querystring']] >= 1) {
            // Nếu có kiểm tra tiếp xem nó có lớn hơn tổn số trang không.
            if ((int)$_GET[$this->config['querystring']] > $this->gettotalPage()) {
                // nếu lớn hơn thì trả về tổng số page
                return (int)$this->gettotalPage();
            } else {
                // còn không thì trả về số trang
                return (int)$_GET[$this->config['querystring']];
            }

        } else {
            // nếu không có querystring thì nhận mặc định là 1
            return 1;
        }
    }

    /**
     * lấy ra trang phía trước
     *
     * @return string
     */
    private function getPrePage()
    {
        global $homeurl;
        // nếu trang hiện tại bằng 1 thì trả về null
        if ($this->getCurrentPage() === 1) {
            return;
        } else {
            // còn không thì trả về html code
            return '<li><a href="'.$homeurl.'/'.$this->config['url'].'&' . $this->config['querystring'] . '=1">«</a></li>';
        }
    }

    /**
     * Lấy ra trang phía sau
     *
     * @return string
     */
    private function getNextPage()
    {
        global $homeurl;
        // nếu trang hiện tại lơn hơn = totalpage thì trả về rỗng
        if ($this->getCurrentPage() >= $this->gettotalPage()) {
            return;
        } else {
            // còn không thì trả về HTML code
            return '<li><a href="'.$homeurl.'/'.$this->config['url'].'&' . $this->config['querystring'] . '=' . ($this->gettotalPage()) . '">»</a></li>';
        }
    }

    /**
     * Hiển thị html code của page
     *
     * @return string
     */
    public function getPagination()
    {
        global $homeurl;
        // tạo biến data rỗng
        if($this->gettotalPage() > 1)
        {
        $data = '';

            for ($i = ($this->getCurrentPage() - 2) > 0 ? ($this->getCurrentPage() - 1) : 1; $i <= (($this->getCurrentPage() + 2) > $this->gettotalPage() ? $this->gettotalPage() : ($this->getCurrentPage() + 2)); $i++) {
                if ($i === $this->getCurrentPage()) {
                    $data .= '<li class="active"><a href="">' . $i . '</a></li>';
                } else {
                    $data .= '<li><a href="'.$homeurl.'/'.$this->config['url'].'&' . $this->config['querystring'] . '=' . $i . '">' . $i . '</a></li>';
                }
            }
        return '' . $this->getPrePage() . $data . $this->getNextPage() . '';
        }
    }
}
?>