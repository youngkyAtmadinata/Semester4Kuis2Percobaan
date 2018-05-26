<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jabatan_model');
        $this->load->helper(array('url'));
        $this->load->model('Pegawai_model');

        // Konfigurasi Upload
        $config['upload_path']          = './assets/uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1500;
        $config['max_width']            = 1536;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);
    }

    public function index()
    {
        $pegawai = $this->Pegawai_model->list();

        $data = [
                    'title' => 'Pemrograman Web Framework :: Data Pegawai',
                    'pegawai' => $pegawai,
                ];
                $this->load->database();
                $jumlah_data = $this->Pegawai_model->jumlah_data();
                $this->load->library('pagination');
                $config['base_url'] = base_url().'index.php/pegawai/index/';
                $config['total_rows'] = $jumlah_data;
                $config['per_page'] = 5;
                $from = $this->uri->segment(3);
                $this->pagination->initialize($config);		
                $data['user'] = $this->Pegawai_model->data($config['per_page'],$from);
                
        $this->load->view('pegawai/index', $data);
    }

    public function create($error='')
    {
        $jabatan = $this->Jabatan_model->list();
        $data = [
            'error' => $error,
            'data' => $jabatan
        ];
        $this->load->view('pegawai/create', $data);
    }

    public function show($id)
    {
        $pegawai = $this->Pegawai_model->show($id);
        $data = [
            'data' => $pegawai
        ];
        $this->load->view('pegawai/show', $data);
    }
    
    public function store()
    {
        // Ambil value 
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $jabatan = $this->input->post('jabatan');

        // Validasi Nama dan Jabatan
        $dataval = $nama;
        $errorval = $this->validate($dataval);

        // Pesan Error atau Upload
        if ($errorval==false)
        {
            // Percobaan Upload
            if ( ! $this->upload->do_upload('foto'))
            {
                $error = $this->upload->display_errors();
                $this->create($error);
            }
            else
            {
                // Insert data
                $data = [
                    'nama' => $nama,
                    'kode' => $jabatan,
                    'alamat' => $alamat,
                    'foto' => $this->upload->data('file_name')
                    ];
                $result = $this->Pegawai_model->insert($data);
                
                if ($result)
                {
                    redirect(pegawai);
                }
                else
                {
                    $error = array('error' => 'Gagal');
                    $this->load->view('pegawai/create', $error);
                }
            }
        }
        else
        {
            $error = validation_errors();
            $this->create($error);
        }
    }

    public function edit($id,$error='')
    {
      // TODO: tampilkan view edit data
        $pegawai = $this->Pegawai_model->show($id);
        $jabatan = $this->Jabatan_model->list();
        $data = [
            'data' => $pegawai,
            'datajab' => $jabatan,
            'error' => $error
        ];
        $this->load->view('pegawai/edit', $data);
      
    }

    public function update($id)
    {
        //Ambil Value
        $id=$this->input->post('id');
        $nama = $this->input->post('nama');
        $jabatan = $this->input->post('jabatan');
        $alamat= $this->input->post('alamat');

        // Validasi Nama dan Jabatan
        $dataval = [
            'nama' => $nama,
            'jabatan' => $jabatan,
            'alamat' => $alamat
            ];
        $errorval = $this->validate($dataval);

        if ($errorval==false)
        {
            if ( ! $this->upload->do_upload('foto'))
            {
                $data = [
                    'nama' => $nama,
                    'kode' => $jabatan,
                    'alamat' => $alamat
                    ];
                $result = $this->Pegawai_model->update($id,$data);

                if ($result)
                {
                    redirect('pegawai');
                }
                else
                {
                    $data = array('error' => 'Gagal');
                    $this->load->view('pegawai/edit', $data);
                }
            }
            else
            {
                $data = [
                    'nama' => $nama,
                    'kode' => $jabatan,
                    'alamat' => $alamat,
                    'foto' => $this->upload->data('file_name')
                    ];
                $result = $this->Pegawai_model->update($id,$data);
                
                if ($result)
                {
                    redirect('pegawai');
                }
                else
                {
                    $data = array('error' => 'Gagal');
                    $this->load->view('pegawai/edit', $data);
                }
            }
        }
        else
        {
            $error = validation_errors();
            $this->edit($id,$error);
        }

        
    }

    public function destroy($id)
    {
        $pegawai = $this->Pegawai_model->show($id);

        delete_files(FCPATH.'assets/uploads/'.$pegawai->foto);
        
        $this->Pegawai_model->delete($id);

        redirect('pegawai');
    }

    public function validate($dataval)
    {
        // Validasi Nama dan Jabatan
        $rules = [
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'trim|required|callback_alpha_space'
            ]
          ];

        $this->form_validation->set_rules($rules);

        if (! $this->form_validation->run())
        { return true; }
        else
        { return false; }
    } 

    public function alpha_space($str)
    {
        return ( ! preg_match("/^([a-z ])+$/i", $str)) ? FALSE : TRUE;
    }
}

/* End of file Controllername.php */
