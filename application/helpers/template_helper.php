<?php
    /**
     * Render the entire page including header and footer
     * @param string $view  Path of view file to be rendered
     * @param array $data  Array of data to be used
     */
    function render_page($view, $data = [])
    {
        $CI = &get_instance();
        $CI->load->view('template/header', $data);
        $CI->load->view($view, $data);
        $CI->load->view('template/footer', $data);
    }
?>