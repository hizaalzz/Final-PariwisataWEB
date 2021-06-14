<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Admin\UserModel;

class User extends BaseController
{
    protected $halaman;
    protected $title;
    protected $user;

    public function __construct()
    {
        $this->halaman = 'user';
        $this->title = 'User';

        $this->user = new UserModel();
    }

    public function index()
    {
        $data = [
            'halaman'   => $this->halaman,
            'title'     => $this->title,
            'main'      => 'user/index'
        ];

        return view('layout/template', $data);
    }

    public function ajaxList()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']['value'];

        $total = $this->user->ajaxGetTotal();
        $output = [
            'length'          => $length,
            'draw'            => $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $total
        ];

        if ($search !== '') {
            $list = $this->user->ajaxGetDataSearch($search, $length, $start);
        } else {
            $list = $this->user->ajaxGetData($length, $start);
        }

        if ($search !== '') {
            $total_search = $this->user->ajaxGetTotalSearch($search);
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
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus Data" onclick="ajaxDelete(' . $temp['id'] . ')">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            ';

            $status = '
                <div class="text-center">                
                    <a href="javascript:void(0)" data-toggle="tooltip" title="' . ($temp['status_user'] == '0' ? 'Aktifkan' : 'Non-aktifkan') . '" onclick="ajaxStatus(' . $temp['id'] . ')">
                        ' . formatStatus($temp['status_user']) . '
                    </a>                    
                </div>
            ';

            $row = [];
            $row[] = $no++;
            $row[] = $temp['nama'];
            $row[] = $temp['no_telp'];
            $row[] = $temp['email'];
            $row[] = $status;
            $row[] = $aksi;

            $data[] = $row;
        }

        $output['data'] = $data;

        echo json_encode($output);
        exit();
    }

    public function ajaxDelete($id)
    {
        if ($this->user->delete($id)) {
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    public function ajaxStatus($id)
    {
        $user = $this->user->find($id);
        $data['id'] = $id;

        if ($user['status_user'] == '0') {
            $data['status_user'] = '1';
            $result = $this->user->save($data);
        } else {
            $data['status_user'] = '0';
            $result = $this->user->save($data);
        }

        if ($result) {
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }
}