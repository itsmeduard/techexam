<?php
namespace App\Csv;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\ModelPhonebook;
class PhonebookImport implements ToCollection
{
    public $c_title, $c_firstname, $c_lastname, $c_mobilenum, $c_companyname;

    public function __construct($title, $firstname, $lastname, $mobilenum, $companyname)
    {
        $this->c_title = $title;
        $this->c_firstname = $firstname;
        $this->c_lastname = $lastname;
        $this->c_mobilenum = $mobilenum;
        $this->c_companyname = $companyname;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            ModelPhonebook::updateOrInsert([
                'title'  => $row[$this->c_title],
                'firstname'  => $row[$this->c_firstname],
                'lastname'  => $row[$this->c_lastname],
                'mobilenum'  => $row[$this->c_mobilenum],
                'companyname'  => $row[$this->c_companyname],
            ]);
        }
    }
}
