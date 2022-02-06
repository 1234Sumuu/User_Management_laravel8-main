<?php

namespace App\Http\Controllers;

use App\Models\User;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersExport extends Controller
{
    public function exportCsv(Request $request)
    {
        $filters = Session::get('searchUser');

        $users = User::where(function ($query) use ($filters) {

        // search by name
        if($request->name)
        {
            $result = User::where('name','LIKE','%'.$request->name.'%')->get();
        }

        // search by role name
        if($request->role_name)
        {
            $result = User::where('role_name','LIKE','%'.$request->role_name.'%')->get();
        }

        // search by status
        if($request->status)
        {
            $result = User::where('status','LIKE','%'.$request->status.'%')->get();
        }

        // search by name and role name
        if($request->name && $request->role_name)
        {
            $result = User::where('name','LIKE','%'.$request->name.'%')
                            ->where('role_name','LIKE','%'.$request->role_name.'%')
                            ->get();
        }

        // search by role name and status
        if($request->role_name && $request->status)
        {
            $result = User::where('role_name','LIKE','%'.$request->role_name.'%')
                            ->where('status','LIKE','%'.$request->status.'%')
                            ->get();
        }

        // search by name and status
        if($request->name && $request->status)
        {
            $result = User::where('name','LIKE','%'.$request->name.'%')
                            ->where('status','LIKE','%'.$request->status.'%')
                            ->get();
        }

        // search by name and role name and status
        if($request->name && $request->role_name && $request->status)
        {
            $result = User::where('name','LIKE','%'.$request->name.'%')
                            ->where('role_name','LIKE','%'.$request->role_name.'%')
                            ->where('status','LIKE','%'.$request->status.'%')
                            ->get();
        }

        // return view('usermanagement.user_control',compact('users','role_name','position','department','status_user','result'));

})->orderBy('created_at', 'desc')->get();

        $fileName = 'user-list.csv';
        $users = User::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );


        $columns = array('id', 'name', 'rec_id', 'email' , 'join_date', 'phone_number' ,'status', 'role_name', 'avatar', 'position', 'department', 'email_verified_at' ,'remember_token', 'updated_at');
        $callback = function() use($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $list) {
                $row['name']  = $list->name;
                $row['rec_id'] = $list->rec_id;
                $row['email']    = (!empty($list->email)  && isset($this->cTypeArray[$list->email])) ? $this->cTypeArray[$list->email] : '';
                $row['join_date'] = $list->join_date;
                $row['phone_number']    = $list->phone_number;
                $row['status']    = $list->status;
                $row['role_name']    = $list->role_name;
                $row['avatar']    = $list->avatar;
                $row['position'] = $list->position;
                $row['department'] = $list->department;
                $row['email_verified_at'] = $list->email_verified_at;
                $row['remember_token'] = $list->remember_token;
                // $row['Created By']  = (!empty($list->created_by)  && isset($this->userArray[$list->created_by])) ? $this->userArray[$list->created_by] : '';
                $row['Updated_at']  = $list->Updated_at;
                // $row['status']  = ($list->status == 1) ? 'Active' : 'Inactive' ;
                // : 'Disable'

                fputcsv($file, array($row['name'], $row['rec_id'], $row['email'], $row['Phone_number'], $row['status'],  $row['role_name'], $row['position'], $row['department'], $row['modify_user'], $row['Created By'], $row['Created On']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }

    // public function exportCsv()
    // {
    //     return User::all();
    // }

    // /**
    //  * Return Headings for the exported data
    //  *
    //  * @return array
    //  */
    // public function headings(): array
    // {
    //     return [
    //         'id', 'name', 'rec_id', 'email' , 'join_date', 'phone_number' ,'status', 'role_name', 'avatar', 'position', 'department', 'email_verified_at' ,'remember_token', 'updated_at'
    //     ];
    // }

}
