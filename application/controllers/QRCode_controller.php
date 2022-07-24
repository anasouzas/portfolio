<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QRCode_controller extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
        $data['page_title'] = 'Portfolio - QRCode Generator';
		render_page('qrcode_generator/qrcode_generator_page', $data);
	}

	public function generate_qrcode($qrcode_content, $qrcode_filename)
	{
		$this->load->library('ciqrcode');

		$hex_data  = bin2hex($qrcode_content);
		$filename  = $qrcode_filename . '.jpg';
		$directory = 'assets/media/qrcodes/';

		if (!file_exists($directory)) mkdir($directory, 0775, true);

		$config['cacheable'] = true;
		$config['imagedir' ] = $directory;
		$config['quality'  ] = true;
		$config['size'     ] = '1024';
		$config['black'    ] = array(255,255,255);
		$config['white'    ] = array(255,255,255);

		$this->ciqrcode->initialize($config);

		$params['data'    ] = $qrcode_content;
		$params['level'   ] = 'L';
		$params['size'    ] = 10;
		$params['savename'] = FCPATH.$config['imagedir'].$filename;

		$this->ciqrcode->generate($params);

		$qrcode_image_path = $directory.$filename;

		return $qrcode_image_path;
	}

	public function generate_qrcode_image()
	{
		$data_from_ajax    = $this->input->post();
		$qrcode_content    = $data_from_ajax['qrcode_content'];
		$qrcode_filename   = $data_from_ajax['qrcode_filename'];
		$qrcode_image_path = $this->generate_qrcode($qrcode_content, $qrcode_filename);

		$response = [
			'status' => file_exists($qrcode_image_path) ? '1' : '0',
			'qrcode_image_path' => $qrcode_image_path 
		];
		
		echo json_encode($response);
	}
}
