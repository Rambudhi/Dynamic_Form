<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use DB;

class DynamicFormController extends Controller
{
    public function dynamicForm()
    {
        return view('dynamic_form');
    }

    public function dbTable($id, $name)
    {   
        $field_db = DB::table('dynamic_form')->where('id', $id)->first();
        $name_db = str_replace(' ', '_', $name);

        $field_name = [];
        $data_value = [];

        $json = json_decode($field_db->json, true);

        foreach ($json as $key => $value) {
            # code...
            array_push($field_name, $value['name']);
        }

        $data_db = DB::table(strtolower($name_db))->get()->toArray();

        foreach ($data_db as $key => $value) {
            # code...
            $object = get_object_vars($value);
            $var = [];
            foreach ($object as $key => $v) {
                array_push($var, preg_replace('/\s+/', '', $v));
            }

            array_push($data_value, $var);
        }

        return view('database_table')->with(compact('field_name', 'data_value', 'name'));
    }

    public function form($id)
    {
        $dynamic_form = DB::table('dynamic_form')->where('id', $id)->first();

        if($dynamic_form == null) 
        {
            return redirect('/');
        }

        return view('form')->with(compact('dynamic_form'));
    }

    public function listForm()
    {
        $dynamic_form = DB::table('dynamic_form')->orderBy('form_name', 'Desc')->get();

        return view('list_form')->with(compact('dynamic_form'));
    }

    public function saveForm(Request $request)
    {
        try {
                $data = $request->all();

                $name = str_replace(' ', '_', $data['formName']);

                Schema::dropIfExists(strtolower($name));

                $result =  $data['result'];

                Schema::connection('pgsql')->create(strtolower($name), function(Blueprint $table) use($result)
                {
                    
                    foreach ($result as $var) {

                        if ($var['type'] == 'text' || $var['type'] == 'email') 
                        {
                            $table->string(strtolower($var['name']), 50)->nullable();
                        }

                        if ($var['type'] == 'textarea' || $var['type'] == 'file')
                        {
                            $table->text(strtolower($var['name']))->nullable();
                        }
                        
                        if ($var['type'] == 'number')
                        {
                            $table->integer(strtolower($var['name']))->nullable();
                        }

                        if ($var['type'] == 'select' || $var['type'] == 'checkbox-group' || $var['type'] == 'radio-group')
                        {
                            $table->char(strtolower($var['name']), 6)->nullable();
                        }

                        if ($var['type'] == 'password') 
                        {
                            $table->string(strtolower($var['name']), 50)->nullable();
                        }
                    }
                });

                DB::table('dynamic_form')->insert([
                    'form_name' => $data['formName'],
                    'json' => json_encode($data['result'])
                ]);

                return $data['formName'];
        } catch (Exception $e) {
            return $e;
        }
    }

    public function deleteForm(Request $request)
    {
        try {
            $data = $request->all();

            Schema::dropIfExists(strtolower($data['name']));

            DB::table('dynamic_form')->where('id', $data['id'])->delete();

            return redirect('/');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function save(Request $request)
    {
        try {
            $data = $request->all();

            $name = str_replace(' ', '_', $data['db']);

            unset($data['db']);

            $normalised = [];
            foreach ($data as $key => $value) 
            {                
                
                $normalised[$this->normalizeKey($key)] = $value;

                if(is_array($normalised[$this->normalizeKey($key)]))
                {
                    $normalised[$this->normalizeKey($key)] = implode(' ', $value);
                }
            }

            $data = $normalised;

            DB::table(strtolower($name))->insert($data);

            return 'Success';
        } catch (Exception $e) {
            return $e;
        }
    }

    private function normalizeKey($key)
    {
        // lowercase string
        $key = strtolower($key);

        // return normalized key
        return $key;
    }   
}
