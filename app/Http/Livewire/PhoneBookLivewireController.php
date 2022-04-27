<?php
namespace App\Http\Livewire;
use App\Csv\PhonebookImport;
use Livewire\WithFileUploads;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\{ Column };
use Illuminate\Database\Eloquent\Builder;
use App\Models\{ ModelPhonebook };
use Maatwebsite\Excel\Facades\Excel;
class PhoneBookLivewireController extends DataTableComponent
{
    use WithFileUploads;
    public bool $dumpFilters = false;
    public bool $responsive = true;
    public array $phonebook = [];
    protected $model = ModelPhonebook::class;

    public $columnSearch = [
        'title' => null,
        'firstname' => null,
        'lastname' => null,
        'mobilenum' => null,
        'companyname' => null,
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setOfflineIndicatorEnabled()
            ->setDefaultSort('created_at', 'asc')
            ->setFilterLayoutSlideDown()
            ->setRememberColumnSelectionEnabled()
            ->setRefreshTime(10000)
            ->setRefreshVisible()
            ->setTrAttributes(function($row, $index) {
                if ($index % 2 === 1) {
                    return [
                        'class' => 'bg-gray-200',
                    ];
                }

                return [];
            })
            ->setSecondaryHeaderTrAttributes(function($rows) {
                return ['class' => 'bg-gray-100'];
            })
            ->setSecondaryHeaderTdAttributes(function(Column $column, $rows) {
                if ($column->isField('id')) {
                    return ['class' => 'text-red-500'];
                }

                return ['default' => true];
            })
            ->setFooterTrAttributes(function($rows) {
                return ['class' => 'bg-gray-100'];
            })
            ->setFooterTdAttributes(function(Column $column, $rows) {
                if ($column->isField('name')) {
                    return ['class' => 'text-green-500'];
                }

                return ['default' => true];
            })
            ->setUseHeaderAsFooterEnabled()
            ->setHideBulkActionsWhenEmptyEnabled();
    }

    public function columns(): array
    {

//Title, First Name, Last Name, Mobile Number, Company Name
        return [
            Column::make('Title', 'title'),
            Column::make('Firstname', 'firstname')
                ->sortable()
                ->searchable(),
            Column::make('Lastname', 'lastname')
                ->sortable()
                ->searchable(),
            Column::make('MobileNumber', 'mobilenum')
                ->sortable()
                ->searchable(),
            Column::make('Company Name', 'companyname'),
            Column::make("Actions")
                ->label(
                    fn($row, Column $column) => view('tables.modals.modal-phonebook-action', ['row' => $row])
                ),
        ];
    }

    public function builder(): Builder
    {
        $data = ModelPhonebook::query()
            ->select('id','title','firstname','lastname','mobilenum','companyname');

        if($data->count() == 0)
        {
            return ModelPhonebook::query()
                ->select('id','title','firstname','lastname','mobilenum','companyname')
                ->where('id',0)
                ->withTrashed();

        } elseif($data->count() > 0) {
            return ModelPhonebook::query()
                ->select('id','title','firstname','lastname','mobilenum','companyname')
                ->when($this->columnSearch['firstname'] ?? null, fn ($query, $firstname) => $query
                    ->where('firstname', 'like', '%' . $firstname . '%')
                )
                ->when($this->columnSearch['lastname'] ?? null, fn ($query, $lastname) => $query
                    ->where('lastname', 'like', '%' . $lastname . '%')
                )
                ->when($this->columnSearch['mobilenum'] ?? null, fn ($query, $mobilenum) => $query
                    ->where('mobilenum', 'like', '%' . $mobilenum . '%')
                )
                ;
        }
    }

    /*For Modal*/
    public $updateMode = false;
    /*Item*/
    public $row_id, $title, $firstname, $lastname, $mobilenum, $companyname;

    //For Modal
    /*Reset fields when modal close*/
    private function resetInputFields()
    {
        $this->row_id = '';
        $this->title = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->mobilenum = '';
        $this->companyname = '';
        $this->uploadFile = '';
    }

    protected $rules = [
        'title' => 'required|max:50',
        'firstname' => 'required|max:50',
        'lastname' => 'required|max:50',
        'mobilenum' => 'required|max:50',
        'companyname' => 'required|max:50',
    ];

    //Add Item
    /*Show Item*/
    public function show_item($id)
    {
        $this->updateMode  = true;
        $data = ModelPhonebook::findOrFail($id);
        $this->row_id    = $data->id;
        $this->title = $data->title;
        $this->firstname = $data->firstname;
        $this->lastname = $data->lastname;
        $this->mobilenum = $data->mobilenum;
        $this->companyname = $data->companyname;
    }

    /*Update Item*/
    public function update_item()
    {
        $this->validate();
        $data = ModelPhonebook::findOrFail($this->row_id);
        $data->update([
            'title' => $this->title,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'mobilenum' => $this->mobilenum,
            'companyname' => $this->companyname,
        ]);

        $this->updateMode = false;
        $this->dispatchBrowserEvent('swal', [
            'title'     =>  'Item Updated',
            'timer'     =>  5000,
            'icon'      =>  'success',
            'toast'     =>  true,
            'position'  =>  'top-right'
        ]);
        $this->resetInputFields();
        $this->emit('modalStore');/*Close Modal*/
    }

    /*Close Modal*/
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
        $this->emit('modalStore');/*Close Modal*/
        $this->emit('modalDelete');/*Close Modal*/
    }

    /*Apply Soft Delete Here*/
    public function destroy_item()
    {
        ModelPhonebook::findOrFail($this->row_id)->delete();
        $this->dispatchBrowserEvent('swal', [
            'title'     =>  'Item Deleted',
            'timer'     =>  5000,
            'icon'      =>  'warning',
            'toast'     =>  true,
            'position'  =>  'top-right'
        ]);
        $this->updateMode = false;
        $this->resetInputFields();
        $this->emit('modalDelete');/*Close Modal*/
    }

    public $select_title, $select_firstname, $select_lastname, $select_mobilenum, $select_companyname, $uploadFile=null;

    public function import()
    {
        /*import data from csv*/
        $this->validate([
            'uploadFile' => 'required',
            'select_title' => 'required|different:select_firstname|different:select_lastname|different:select_mobilenum|different:select_companyname',
            'select_firstname' => 'required|different:select_title|different:select_lastname|different:select_mobilenum|different:select_companyname',
            'select_lastname' => 'required|different:select_firstname|different:select_mobilenum|different:select_companyname',
            'select_mobilenum' => 'required|different:select_firstname|different:select_lastname|different:select_title|different:select_companyname',
            'select_companyname' => 'required|different:select_firstname|different:select_lastname|different:select_mobilenum|different:select_title',
        ], ['required'   => 'The :attribute field is required']);

        $path = $this->uploadFile->getRealPath();

        Excel::import(new PhonebookImport($this->select_title, $this->select_firstname, $this->select_lastname, $this->select_mobilenum, $this->select_companyname), $path);

        $this->updateMode = false;
        $this->dispatchBrowserEvent('swal', [
            'title'    =>  'Data Imported',
            'timer'    =>  5000,
            'icon'     =>  'success',
            'toast'    =>  true,
            'position' =>  'top-right'
        ]);
        $this->resetInputFields();
        $this->emit('modalStore');/*Close Modal*/
    }
}
