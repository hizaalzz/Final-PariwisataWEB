<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Admin\PariwisataModel;

class Pariwisata extends BaseController
{
    protected $halaman;
    protected $title;
    protected $pariwisata;

    public function __construct()
    {
        $this->halaman = 'pariwisata';
        $this->title = 'Pariwisata';

        $this->pariwisata = new PariwisataModel();
    }

    public function index()
    {
        $data = [
            'halaman'   => $this->halaman,
            'title'     => $this->title,
            'main'      => 'pariwisata/index'
        ];

        return view('layout/template', $data);
    }

    public function ajaxList()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']['value'];

        $total = $this->pariwisata->ajaxGetTotal();
        $output = [
            'length'          => $length,
            'draw'            => $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $total
        ];

        if ($search !== '') {
            $list = $this->pariwisata->ajaxGetDataSearch($search, $length, $start);
        } else {
            $list = $this->pariwisata->ajaxGetData($length, $start);
        }

        if ($search !== '') {
            $total_search = $this->pariwisata->ajaxGetTotalSearch($search);
            $output = [
                'recordsTotal'    => $total_search,
                'recordsFiltered' => $total_search
            ];
        }

        $data = [];
        $no = $start + 1;
        foreach ($list as $temp) {
            $aksi = '
                <div class="text-center">                
                    <a href="javascript:void(0)" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit Data" onclick="ajaxEdit(' . $temp['id'] . ')">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus Data" onclick="ajaxDelete(' . $temp['id'] . ')">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            ';

            $status = '
                <div class="text-center">                
                    <a href="javascript:void(0)" data-toggle="tooltip" title="' . ($temp['status'] == '0' ? 'Aktifkan' : 'Non-aktifkan') . '" onclick="ajaxStatus(' . $temp['id'] . ')">
                        ' . formatStatus($temp['status']) . '
                    </a>                    
                </div>
            ';

            $gambar = '
                <div class="text-center">
                    <img src="' . base_url('/uploads/img/' . $temp['gambar']) . '" alt="' . $temp['gambar'] . '" width="200px" height="125px">
                </div>
            ';

            $row = [];
            $row[] = $no++;
            $row[] = $gambar;
            $row[] = $temp['nama_pariwisata'];
            $row[] = $temp['harga'];
            $row[] = $temp['kategori'];
            $row[] = $temp['deskripsi'];
            $row[] = $status;
            $row[] = $aksi;

            $data[] = $row;
        }

        $output['data'] = $data;

        echo json_encode($output);
        exit();
    }

    public function ajaxEdit($id)
    {
        $data = $this->pariwisata->find($id);
        echo json_encode($data);
    }

    public function ajaxSave()
    {
        $this->_validate('save');

        $data = [
            'nama_pariwisata' => $this->request->getVar('nama_pariwisata'),
            'harga'       => $this->request->getVar('harga'),
            'deskripsi'   => $this->request->getVar('deskripsi'),
            'kategori'    => $this->request->getVar('kategori'),
            'gambar'      => uploadImage($this->request->getFile('gambar')),
            'status'      => '1'
        ];

        if ($this->pariwisata->save($data)) {
            echo json_encode(['status' => TRUE]);
        } else {
            echo json_encode(['status' => FALSE]);
        }
    }

    public function ajaxUpdate()
    {
        $this->_validate('update');

        $id = $this->request->getVar('id');
        $pariwisata = $this->pariwisata->find($id);

        if ($this->request->getFile('gambar') == '') {
            $gambar = $pariwisata['gambar'];
        } else {
            unlink('uploads/img/' . $pariwisata['gambar']);
            $gambar = uploadImage($this->request->getFile('gambar'));
        }

        $data = [
            'id'          => $id,
            'nama_pariwisata' => $this->request->getVar('nama_pariwisata'),
            'harga'       => $this->request->getVar('harga'),
            'deskripsi'   => $this->request->getVar('deskripsi'),
            'kategori'    => $this->request->getVar('kategori'),
            'gambar'      => $gambar,
        ];

        if ($this->pariwisata->save($data)) {
            echo json_encode(['status' => TRUE]);
        } else {
            echo json_encode(['status' => FALSE]);
        }
    }

    public function ajaxDelete($id)
    {
        $pariwisata = $this->pariwisata->find($id);
        unlink('uploads/img/' . $pariwisata['gambar']);

        if ($this->pariwisata->delete($id)) {
            echo json_encode(['status' => TRUE]);
        } else {
            echo json_encode(['status' => FALSE]);
        }
    }

    public function ajaxStatus($id)
    {
        $pariwisata = $this->pariwisata->find($id);
        $data['id'] = $id;

        if ($pariwisata['status'] == '0') {
            $data['status'] = '1';
        } else {
            $data['status'] = '0';
        }

        if ($this->pariwisata->save($data)) {
            echo json_encode(['status' => TRUE]);
        } else {
            echo json_encode(['status' => FALSE]);
        }
    }

    public function _validate($method)
    {
        if (!$this->validate($this->pariwisata->getRulesValidation($method))) {
            $validation = \Config\Services::validation();

            $data = [];
            $data['error_string'] = [];
            $data['inputerror'] = [];
            $data['status'] = TRUE;

            if ($validation->hasError('nama_pariwisata')) {
                $data['inputerror'][]     = 'nama_pariwisata';
                $data['error_string'][]   = $validation->getError('nama_pariwisata');
                $data['status']         = FALSE;
            }

            if ($validation->hasError('harga')) {
                $data['inputerror'][]     = 'harga';
                $data['error_string'][]   = $validation->getError('harga');
                $data['status']         = FALSE;
            }

            if ($validation->hasError('deskripsi')) {
                $data['inputerror'][]     = 'deskripsi';
                $data['error_string'][]   = $validation->getError('deskripsi');
                $data['status']         = FALSE;
            }

            if ($validation->hasError('kategori')) {
                $data['inputerror'][]     = 'kategori';
                $data['error_string'][]   = $validation->getError('kategori');
                $data['status']         = FALSE;
            }

            if ($validation->hasError('gambar')) {
                $data['inputerror'][]     = 'gambar';
                $data['error_string'][]   = $validation->getError('gambar');
                $data['status']         = FALSE;
            }

            if ($data['status'] == FALSE) {
                echo json_encode($data);
                exit();
            }
        }
    }
}