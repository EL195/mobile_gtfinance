<?php

namespace App\DataTables\Admin;

use App\Http\Helpers\Common;
use App\Models\DocumentVerification;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class AddressProofsDataTable extends DataTable
{

    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->editColumn('created_at', function ($documentVerification)
            {
                return dateFormat($documentVerification->created_at);
            })
            ->addColumn('user_id', function ($documentVerification)
            {
                $sender = isset($documentVerification->user) ? $documentVerification->user->first_name.' '.$documentVerification->user->last_name :"-";

                $senderWithLink = (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_user')) ? '<a href="' . url(Config::get('adminPrefix').'/users/edit/' . $documentVerification->user->id) . '">'.$sender.'</a>' : $sender;
                return $senderWithLink;
            })
            ->editColumn('status', function ($documentVerification)
            {
                if ($documentVerification->status == 'approved')
                {
                    $status = '<span class="label label-success">Approved</span>';
                }
                elseif ($documentVerification->status == 'pending')
                {
                    $status = '<span class="label label-primary">Pending</span>';
                }
                elseif ($documentVerification->status == 'rejected')
                {
                    $status = '<span class="label label-danger">Rejected</span>';
                }
                return $status;
            })
            ->addColumn('action', function ($documentVerification)
            {
                $edit = '';
                $edit = (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_address_verfication')) ?
                '<a href="' . url(Config::get('adminPrefix').'/address-proofs/edit/' . $documentVerification->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;' : '';
                return $edit;
            })
            ->rawColumns(['user_id', 'status', 'action'])
            ->make(true);
    }

    public function query()
    {
        $status   = isset(request()->status) ? request()->status : 'all';
        $from     = isset(request()->from) ? setDateForDb(request()->from) : null;
        $to       = isset(request()->to ) ? setDateForDb(request()->to) : null;
        $query    = (new DocumentVerification())->getAddressVerificationsList($from, $to, $status);

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'document_verifications.id', 'title' => 'ID', 'searchable' => false, 'visible' => false])
            ->addColumn(['data' => 'created_at', 'name' => 'document_verifications.created_at', 'title' => 'Date'])

            ->addColumn(['data' => 'user_id', 'name' => 'user.last_name', 'title' => 'User','visible' => false])//relation
            ->addColumn(['data' => 'user_id', 'name' => 'user.first_name', 'title' => 'User'])//relation

            ->addColumn(['data' => 'status', 'name' => 'document_verifications.status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters([
                'order'      => [[0, 'desc']],
                'pageLength' => Session::get('row_per_page'),
                'language'   => Session::get('language'),
            ]);
    }
}
