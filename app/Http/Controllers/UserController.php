<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * This function that returns a list of running proccesses.
     *
     * @return mixed
     */
    public function GetPs() {
        $result = shell_exec(env("CMD_PROCCESS_LIST"));
        if($result==null) {
            return response([
                "status"=>false,
                "error"=>"Command Execution Failed",
                "data"=>null
            ], 500);
        }
        return response([
            "status"=>true,
            "error"=>null,
            "data"=>$result
        ]);
    }

    /**
     * This function does returns a list of directories in side default directory specified in .env
     *
     * @return mixed
     */
    public function ListDirectory() {
        $username = Auth::user()->name;
        $this->_createDirectory($username);
        $result = array_diff(scandir(env('USER_DEFAULT_DIRECTORY') . DIRECTORY_SEPARATOR . $username), array('..', '.'));
        $actualResult = [];
        foreach($result as $item) {
            if(is_dir(env('USER_DEFAULT_DIRECTORY') . DIRECTORY_SEPARATOR . $username . DIRECTORY_SEPARATOR . $item)) {
                $actualResult[] = $item;
            }
        }
        return response([
            "status"=>true,
            "error"=>null,
            "data"=>$actualResult
        ]);
    }

    /**
     * this private function does the actual directory creation job
     *
     * @param darectory_name
     */
    private function _createDirectory($directory_name) {
        $directory_name = trim($directory_name);
        $directory_name = str_replace(" ", "_", $directory_name);
        $directory_name = env('USER_DEFAULT_DIRECTORY') . DIRECTORY_SEPARATOR . $directory_name;
        if (!file_exists($directory_name)) {
            mkdir($directory_name, 0777, true);
        }
    }

    /**
     * this function creates directory in the default directory specified in .env
     *
     * @param directory_name
     *
     * @return mixed
     */
    public function CreateDirectory(Request $request) {
        if($request->input('directory_name')==null){
            return response([
                "status"=>false,
                "error"=>"`directory_name` must specified!",
                "data"=>null
            ], 400);
        }

        $username = Auth::user()->name;
        $this->_createDirectory($username);
        $this->_createDirectory($username . DIRECTORY_SEPARATOR . $request->input('directory_name'));

        return response([
            "status"=>true,
            "error"=>null,
            "data"=>null
        ]);
    }


    /**
     * this private function does the actual file creation job
     *
     * @param file_name
     */
    private function _createFile($username, $file_name) {
        $file_name = trim($file_name);
        $file_name = str_replace(" ", "_", $file_name);
        $file_name = env('USER_DEFAULT_DIRECTORY') . DIRECTORY_SEPARATOR . $username . DIRECTORY_SEPARATOR . $file_name;
        if (!file_exists($file_name)) {
            file_put_contents($file_name, '');
        }
    }

    /**
     * this function creates file in the default directory specified in .env
     *
     * @param file_name
     *
     * @return mixed
     */
    public function CreateFile(Request $request) {
        if($request->input('file_name')==null){
            return response([
                "status"=>false,
                "error"=>"`file_name` must specified!",
                "data"=>null
            ], 400);
        }

        $username = Auth::user()->name;
        $this->_createDirectory($username);
        $this->_createFile($username, $request->input('file_name'));

        return response([
            "status"=>true,
            "error"=>null,
            "data"=>null
        ]);
    }

    /**
     * This function does returns a list of files in side default directory specified in .env
     *
     * @return mixed
     */
    public function ListFile() {
        $username = Auth::user()->name;
        $this->_createDirectory($username);
        $result = array_diff(scandir(env('USER_DEFAULT_DIRECTORY') . DIRECTORY_SEPARATOR . $username), array('..', '.'));
        $actualResult = [];
        foreach($result as $item) {
            if(!is_dir(env('USER_DEFAULT_DIRECTORY') . DIRECTORY_SEPARATOR . $username . DIRECTORY_SEPARATOR . $item)) {
                $actualResult[] = $item;
            }
        }
        return response([
            "status"=>true,
            "error"=>null,
            "data"=>$actualResult
        ]);
    }
}
