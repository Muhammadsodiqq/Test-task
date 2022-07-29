<?php

class Test 
{
    public $file_name;

    public function __construct(string $file_name)
    {
        if(strlen($file_name) != 0) {

            $this->file_name = $file_name;

            fopen("$file_name.json", 'a+',true);
        }else {
            throw new Exception("The name of the file must be greater then 0");
        }
    }

    public function EditData(array $data) {
        $this->Action($data,false);
        echo "Edited succesfully" . PHP_EOL;
    }

    public function AddTolist(array $data) {
        $this->Action($data,true);
        echo "Added succesfully" . PHP_EOL;
    }


    public function DeleteData(string $name) {
        $content = json_decode(file_get_contents("$this->file_name.json",true),true);

        unset($content[$name]);

        file_put_contents("$this->file_name.json", json_encode($content));
        echo "Deleted succesfuly" . PHP_EOL;
    }

    public function Sum() {
        $content = json_decode(file_get_contents("$this->file_name.json",true),true);
        // print_r($content);
        $sum = 0;
        foreach($content as $value) {
            $sum += $value;
        }

        echo "The total amount of products is: $sum" . PHP_EOL;
    }

    public function GetData() {
        $content = json_decode(file_get_contents("$this->file_name.json",true),true);

        print_r($content);
    }
    protected function Action(array $data, bool $isCreate)
    {

        $content = json_decode(file_get_contents("$this->file_name.json",true),true);

        foreach($data as $key => $value) {

            $isset =  isset($content[$key]);

            if($isset){

                if(!is_numeric($value)) throw new Exception('value must be numeric');

                if($isCreate) {
                    $content[$key] = $content[$key] + $value;

                }else {


                    $content[$key] = $value;
                }

            }else {
                if($isCreate) $content[$key] = $value;

            }

        }

        file_put_contents("$this->file_name.json", json_encode($content));
    }

}

$action = new Test("database");

// $action->AddTolist(["Огурцы" => 50, "Помидоры" => 40, "Масло" => 40]); // for Add data to file
// $action->EditData(["Помидоры" => 20]); // for Edit data to file
// $action->DeleteData("Помидоры"); // for Delete data to file
// $action->Sum(); //  for get total amount
// $action->GetData(); // for get data from file
?>